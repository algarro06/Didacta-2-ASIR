<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Didacta</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('recursos/css/principal.css') }}">
</head>
<body>
@include('includes.header')

@if(in_array(auth()->user()->id_role, [1, 2]))
    <div style="text-align:right; padding:10px 30px; display:flex; justify-content:flex-end; gap:10px;">

        @if(auth()->user()->id_role == 1)
            <a href="{{ route('admin.users.index') }}" class="admin-btn">
                👤 Editar usuarios
            </a>
        @endif

        <a href="{{ route('courses.create') }}"
           style="background:#4a6fa5; color:white; padding:8px 18px;
                  border-radius:6px; text-decoration:none; font-weight:bold;">
            ➕ Crear nuevo curso
        </a>

        <a href="{{ route('courses.edit', $courses->first()->id_course ?? 0) }}"
           style="background:#fd7e14; color:white; padding:8px 18px;
                  border-radius:6px; text-decoration:none; font-weight:bold;">
            ✏️ Editar curso
        </a>

        <button onclick="document.getElementById('modal-eliminar').style.display='flex'"
                style="background:#dc3545; color:white; padding:8px 18px;
                       border-radius:6px; border:none; font-weight:bold; cursor:pointer;">
            🗑 Eliminar curso
        </button>

    </div>
@endif

@if(session('success'))
    <div style="background:#d4edda; color:#155724; padding:10px 30px;
                margin:10px 30px; border-radius:6px;">
        ✅ {{ session('success') }}
    </div>
@endif

<div class="courses-container">
    @forelse($courses as $course)
        <a href="{{ route('courses.show', $course->view_name) }}" class="course-card">
            @if($course->image)
                <img src="{{ asset('recursos/imagenes/Imagenes_cursos/' . $course->image) }}" class="course-img">
            @else
                <img src="{{ asset('recursos/imagenes/Imagenes_cursos/' . $course->view_name . '.jpg') }}" class="course-img">
            @endif
            <div class="course-info">
                <h3>{{ $course->title }}</h3>
                <p>{{ $course->description }}</p>
            </div>
        </a>
    @empty
        <p style="padding:20px;">No hay cursos disponibles.</p>
    @endforelse
</div>

@if(in_array(auth()->user()->id_role, [1, 2]))
<div id="modal-eliminar"
     style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
            background:rgba(0,0,0,0.5); z-index:9999;
            justify-content:center; align-items:center;">
    <div style="background:white; border-radius:10px; padding:30px;
                width:100%; max-width:450px; box-shadow:0 4px 20px rgba(0,0,0,0.3);">
        <h2 style="margin-top:0;">🗑 Eliminar curso</h2>
        <p style="color:#666;">Selecciona el curso que quieres eliminar. Esta acción no se puede deshacer.</p>
        <form method="POST" id="form-eliminar" action="">
            @csrf
            @method('DELETE')
            <select id="select-curso"
                    style="width:100%; padding:10px; border:1px solid #ccc;
                           border-radius:6px; margin-bottom:20px; font-size:1rem;">
                <option value="">-- Selecciona un curso --</option>
                @foreach($courses as $course)
                    <option value="{{ route('courses.destroy', $course->id_course) }}">
                        {{ $course->title }}
                    </option>
                @endforeach
            </select>
            <div style="display:flex; gap:10px; justify-content:flex-end;">
                <button type="button"
                        onclick="document.getElementById('modal-eliminar').style.display='none'"
                        style="background:#6c757d; color:white; border:none;
                               padding:10px 20px; border-radius:6px; cursor:pointer;">
                    Cancelar
                </button>
                <button type="submit"
                        onclick="return confirmarEliminar()"
                        style="background:#dc3545; color:white; border:none;
                               padding:10px 20px; border-radius:6px; cursor:pointer; font-weight:bold;">
                    🗑 Eliminar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('select-curso').addEventListener('change', function() {
    document.getElementById('form-eliminar').action = this.value;
});
function confirmarEliminar() {
    const select = document.getElementById('select-curso');
    if (!select.value) {
        alert('Por favor selecciona un curso.');
        return false;
    }
    return confirm('¿Seguro que quieres eliminar este curso? Se borrará también su página y todas las matriculaciones.');
}
document.getElementById('modal-eliminar').addEventListener('click', function(e) {
    if (e.target === this) {
        this.style.display = 'none';
    }
});
</script>
@endif

@include('includes.footer')
<script src="{{ asset('recursos/js/principal.js') }}"></script>
</body>
</html>
