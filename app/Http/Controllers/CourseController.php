<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('courses.index', compact('courses'));
    }

    public function show($title)
    {
        $course = Course::where('view_name', $title)->firstOrFail();
        $user = Auth::user();

        if (in_array($user->id_role, [1, 2])) {
            return view('courses.' . $title, compact('course'));
        }

        if (!$course->students->contains('id_user', $user->id_user)) {
            return redirect('/403');
        }

        return view('courses.' . $title, compact('course'));
    }

    public function students($title)
    {
        $course = Course::where('view_name', $title)->firstOrFail();
        $user = Auth::user();

        if (!in_array($user->id_role, [1, 2])) {
            return redirect('/403');
        }

        $enrolled = $course->students;
        $available = User::where('id_role', 3)
            ->whereNotIn('id_user', $enrolled->pluck('id_user'))
            ->get();

        return view('courses.students', compact('course', 'enrolled', 'available'));
    }

    public function enrollStudent(Request $request, $title)
    {
        $course = Course::where('view_name', $title)->firstOrFail();
        $user = Auth::user();

        if (!in_array($user->id_role, [1, 2])) {
            return redirect('/403');
        }

        $course->students()->attach($request->user_id);
        return back()->with('success', 'Alumno añadido correctamente.');
    }

    public function removeStudent(Request $request, $title, $userId)
    {
        $course = Course::where('view_name', $title)->firstOrFail();
        $user = Auth::user();

        if (!in_array($user->id_role, [1, 2])) {
            return redirect('/403');
        }

        $course->students()->detach($userId);
        return back()->with('success', 'Alumno eliminado correctamente.');
    }

    public function create()
    {
        $user = Auth::user();

        if (!in_array($user->id_role, [1, 2])) {
            return redirect('/403');
        }

        return view('courses.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!in_array($user->id_role, [1, 2])) {
            return redirect('/403');
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'title.required' => 'El nombre del curso es obligatorio.',
            'title.max'      => 'El nombre del curso no puede superar los 255 caracteres.',
            'image.image'    => 'El archivo debe ser una imagen.',
            'image.mimes'    => 'La imagen debe ser de tipo: jpg, jpeg, png o webp.',
            'image.max'      => 'La imagen no puede superar los 2MB.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $viewName = strtolower(str_replace(' ', '_', $request->title));
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = $viewName . '.' . $extension;

            $request->file('image')->move(
                public_path('recursos/imagenes/Imagenes_cursos'),
                $fileName
            );

            $imagePath = $fileName;
        }

        $viewName = strtolower(str_replace(' ', '_', $request->title));

        $course = Course::create([
            'title'         => $request->title,
            'description'   => $request->description,
            'status'        => 'Activo',
            'creation_date' => now(),
            'image'         => $imagePath,
            'view_name'     => $viewName,
        ]);

        $viewContent = <<<BLADE
@include('includes.header')
<link rel="stylesheet" href="{{ asset('recursos/css/principal.css') }}">
<script src="{{ asset('recursos/js/principal.js') }}"></script>

<div class="curso-header">
    <h1>{$course->title}</h1>
    <p>Bienvenido al curso de {$course->title}</p>
</div>

@if(in_array(auth()->user()->id_role, [1, 2]))
    <div style="display:flex; justify-content:flex-end; gap:10px; padding:10px 20px;">
        <a href="{{ route('courses.students', '{$viewName}') }}"
           style="background:#4a6fa5; color:white; padding:8px 18px;
                  border-radius:6px; text-decoration:none; font-weight:bold;">
            👥 Gestionar alumnos
        </a>
        <button onclick="document.getElementById('modal-seccion').style.display='flex'"
                style="background:#28a745; color:white; padding:8px 18px;
                       border-radius:6px; border:none; font-weight:bold; cursor:pointer;">
            ➕ Añadir apartado
        </button>
    </div>
@endif

@if(session('success'))
    <div style="background:#d4edda; color:#155724; padding:10px 20px;
                margin:0 20px 10px; border-radius:6px;">
        ✅ {{ session('success') }}
    </div>
@endif

<div class="curso-wrapper">
    <div class="curso-temas">

        @forelse(\$course->sections as \$section)
            <div class="tema">
                <button class="tema-titulo" onclick="toggleTema(this)">
                    📂 {{ \$section->title }} <span class="flecha">▲</span>
                </button>
                <div class="tema-contenido abierto">
                    @foreach(\$section->items as \$item)
                        <div style="display:flex; align-items:center; gap:8px;">
                            @if(\$item->type === 'temario')
                                <a href="{{ asset(\$item->file_path) }}" target="_blank">
                                    📄 {{ \$item->title }}
                                </a>
                            @else
                                <a href="{{ route('items.task', \$item->id_item) }}">
                                    ✏️ {{ \$item->title }}
                                    @if(\$item->due_date)
                                        <span style="font-size:0.8rem; color:#888;">
                                            (Entrega: {{ \Carbon\Carbon::parse(\$item->due_date)->format('d/m/Y') }})
                                        </span>
                                    @endif
                                </a>
                            @endif
                            @if(in_array(auth()->user()->id_role, [1, 2]))
                                <a href="{{ route('items.edit', \$item->id_item) }}"
                                   style="background:none; border:none; color:#4a6fa5;
                                          cursor:pointer; font-size:0.85rem; text-decoration:none;">
                                    ✏️
                                </a>
                                <form method="POST" action="{{ route('items.destroy', \$item->id_item) }}"
                                      style="display:inline; margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            style="background:none; border:none; color:#dc3545;
                                                   cursor:pointer; font-size:0.85rem;"
                                            onclick="return confirm('¿Eliminar este contenido?')">
                                        🗑
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                    @if(in_array(auth()->user()->id_role, [1, 2]))
                        <div style="display:flex; gap:8px; margin-top:12px;">
                            <button onclick="abrirModalItem({{ \$section->id_section }}, 'temario')"
                                    style="background:#4a6fa5; color:white; border:none;
                                           padding:5px 12px; border-radius:4px; cursor:pointer; font-size:0.85rem;">
                                ➕ Temario
                            </button>
                            <button onclick="abrirModalItem({{ \$section->id_section }}, 'tarea')"
                                    style="background:#fd7e14; color:white; border:none;
                                           padding:5px 12px; border-radius:4px; cursor:pointer; font-size:0.85rem;">
                                ➕ Tarea
                            </button>
                            <form method="POST" action="{{ route('sections.destroy', \$section->id_section) }}"
                                  style="margin:0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        style="background:#dc3545; color:white; border:none;
                                               padding:5px 12px; border-radius:4px; cursor:pointer; font-size:0.85rem;"
                                        onclick="return confirm('¿Eliminar este apartado y todo su contenido?')">
                                    🗑 Borrar apartado
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <p style="padding:20px;">No hay apartados todavía.</p>
        @endforelse

    </div>
</div>

@if(in_array(auth()->user()->id_role, [1, 2]))
<div id="modal-seccion"
     style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
            background:rgba(0,0,0,0.5); z-index:9999;
            justify-content:center; align-items:center;">
    <div style="background:white; border-radius:10px; padding:30px;
                width:100%; max-width:420px;">
        <h2 style="margin-top:0;">➕ Nuevo apartado</h2>
        <form method="POST" action="{{ route('sections.store', \$course->id_course) }}">
            @csrf
            <input type="text" name="title" placeholder="Nombre del apartado"
                   style="width:100%; padding:10px; border:1px solid #ccc;
                          border-radius:6px; margin-bottom:15px; box-sizing:border-box;">
            <div style="display:flex; gap:10px; justify-content:flex-end;">
                <button type="button"
                        onclick="document.getElementById('modal-seccion').style.display='none'"
                        style="background:#6c757d; color:white; border:none;
                               padding:10px 18px; border-radius:6px; cursor:pointer;">
                    Cancelar
                </button>
                <button type="submit"
                        style="background:#28a745; color:white; border:none;
                               padding:10px 18px; border-radius:6px; cursor:pointer; font-weight:bold;">
                    Crear
                </button>
            </div>
        </form>
    </div>
</div>

<div id="modal-item"
     style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
            background:rgba(0,0,0,0.5); z-index:9999;
            justify-content:center; align-items:center;">
    <div style="background:white; border-radius:10px; padding:30px;
                width:100%; max-width:480px; max-height:90vh; overflow-y:auto;">
        <h2 style="margin-top:0;" id="modal-item-titulo">➕ Añadir contenido</h2>
        <form method="POST" id="form-item" action="" enctype="multipart/form-data"
              style="display:flex; flex-direction:column; gap:14px;">
            @csrf
            <input type="hidden" name="type" id="input-type">
            <div>
                <label style="font-weight:bold;">Título</label>
                <input type="text" name="title"
                       style="width:100%; padding:10px; border:1px solid #ccc;
                              border-radius:6px; margin-top:6px; box-sizing:border-box;">
            </div>
            <div id="campos-tarea" style="display:none;">
                <div>
                    <label style="font-weight:bold;">Descripción</label>
                    <textarea name="description" rows="3"
                              style="width:100%; padding:10px; border:1px solid #ccc;
                                     border-radius:6px; margin-top:6px; box-sizing:border-box;"></textarea>
                </div>
                <div style="margin-top:10px;">
                    <label style="font-weight:bold;">Fecha de entrega</label>
                    <input type="date" name="due_date"
                           style="width:100%; padding:10px; border:1px solid #ccc;
                                  border-radius:6px; margin-top:6px; box-sizing:border-box;">
                </div>
            </div>
            <div id="campos-temario" style="display:none;">
                <label style="font-weight:bold;">PDF a subir</label>
                <input type="file" name="file" accept=".pdf"
                       style="width:100%; padding:10px; border:1px solid #ccc;
                              border-radius:6px; margin-top:6px; box-sizing:border-box;">
            </div>
            <div style="display:flex; gap:10px; justify-content:flex-end;">
                <button type="button"
                        onclick="document.getElementById('modal-item').style.display='none'"
                        style="background:#6c757d; color:white; border:none;
                               padding:10px 18px; border-radius:6px; cursor:pointer;">
                    Cancelar
                </button>
                <button type="submit"
                        style="background:#4a6fa5; color:white; border:none;
                               padding:10px 18px; border-radius:6px; cursor:pointer; font-weight:bold;">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>
@endif

@include('includes.footer')

<script>
function toggleTema(btn) {
    const contenido = btn.nextElementSibling;
    const flecha = btn.querySelector(".flecha");
    contenido.classList.toggle("abierto");
    flecha.textContent = contenido.classList.contains("abierto") ? "▲" : "▼";
}

function abrirModalItem(sectionId, tipo) {
    const modal = document.getElementById('modal-item');
    const form = document.getElementById('form-item');
    const titulo = document.getElementById('modal-item-titulo');
    const inputType = document.getElementById('input-type');
    const camposTarea = document.getElementById('campos-tarea');
    const camposTemario = document.getElementById('campos-temario');

    form.action = '/sections/' + sectionId + '/items';
    inputType.value = tipo;

    if (tipo === 'tarea') {
        titulo.textContent = '✏️ Nueva tarea';
        camposTarea.style.display = 'block';
        camposTemario.style.display = 'none';
    } else {
        titulo.textContent = '📄 Nuevo temario';
        camposTarea.style.display = 'none';
        camposTemario.style.display = 'block';
    }

    modal.style.display = 'flex';
}

document.getElementById('modal-seccion').addEventListener('click', function(e) {
    if (e.target === this) this.style.display = 'none';
});
document.getElementById('modal-item').addEventListener('click', function(e) {
    if (e.target === this) this.style.display = 'none';
});
</script>
BLADE;

        file_put_contents(
            resource_path('views/courses/' . $viewName . '.blade.php'),
            $viewContent
        );

        return redirect('/home')->with('success', 'Curso "' . $course->title . '" creado correctamente.');
    }

    public function edit($id)
    {
        $user = Auth::user();

        if (!in_array($user->id_role, [1, 2])) {
            return redirect('/403');
        }

        $course = Course::findOrFail($id);
        $courses = Course::all();

        return view('courses.edit', compact('course', 'courses'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        if (!in_array($user->id_role, [1, 2])) {
            return redirect('/403');
        }

        $course = Course::findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'title.required' => 'El nombre del curso es obligatorio.',
            'title.max'      => 'El nombre del curso no puede superar los 255 caracteres.',
            'image.image'    => 'El archivo debe ser una imagen.',
            'image.mimes'    => 'La imagen debe ser de tipo: jpg, jpeg, png o webp.',
            'image.max'      => 'La imagen no puede superar los 2MB.',
        ]);

        if ($request->hasFile('image')) {
            if ($course->image) {
                $oldPath = public_path('recursos/imagenes/Imagenes_cursos/' . $course->image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = $course->view_name . '.' . $extension;

            $request->file('image')->move(
                public_path('recursos/imagenes/Imagenes_cursos'),
                $fileName
            );

            $course->image = $fileName;
        }

        $course->title       = $request->title;
        $course->description = $request->description;
        $course->save();

        return redirect('/home')->with('success', 'Curso "' . $course->title . '" actualizado correctamente.');
    }

    public function destroy($id)
    {
        $user = Auth::user();

        if (!in_array($user->id_role, [1, 2])) {
            return redirect('/403');
        }

        $course = Course::findOrFail($id);

        $bladePath = resource_path('views/courses/' . $course->view_name . '.blade.php');
        if (file_exists($bladePath)) {
            unlink($bladePath);
        }

        if ($course->image) {
            $imagePath = public_path('recursos/imagenes/Imagenes_cursos/' . $course->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $course->students()->detach();
        $course->delete();

        return redirect('/home')->with('success', 'Curso "' . $course->title . '" eliminado correctamente.');
    }
}