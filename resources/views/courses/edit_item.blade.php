@include('includes.header')
<link rel="stylesheet" href="{{ asset('recursos/css/principal.css') }}">

<div class="curso-header">
    <h1>✏️ Editar {{ $item->type === 'temario' ? 'temario' : 'tarea' }}</h1>
</div>

<div class="curso-wrapper" style="max-width:600px; margin:40px auto;">

    @if($errors->any())
        <div style="background:#f8d7da; color:#721c24; padding:10px;
                    border-radius:6px; margin-bottom:15px;">
            <ul style="margin:0; padding-left:20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('items.update', $item->id_item) }}"
          enctype="multipart/form-data"
          style="display:flex; flex-direction:column; gap:16px;">
        @csrf
        @method('PUT')

        <div>
            <label style="font-weight:bold;">Título</label>
            <input type="text" name="title" value="{{ old('title', $item->title) }}"
                   style="width:100%; padding:10px; border:1px solid #ccc;
                          border-radius:6px; margin-top:6px; box-sizing:border-box;">
        </div>

        @if($item->type === 'tarea')
            <div>
                <label style="font-weight:bold;">Descripción</label>
                <textarea name="description" rows="4"
                          style="width:100%; padding:10px; border:1px solid #ccc;
                                 border-radius:6px; margin-top:6px; box-sizing:border-box;">{{ old('description', $item->description) }}</textarea>
            </div>

            <div>
                <label style="font-weight:bold;">Fecha de entrega</label>
                <input type="date" name="due_date"
                       value="{{ old('due_date', $item->due_date ? \Carbon\Carbon::parse($item->due_date)->format('Y-m-d') : '') }}"
                       style="width:100%; padding:10px; border:1px solid #ccc;
                              border-radius:6px; margin-top:6px; box-sizing:border-box;">
            </div>
        @endif

        @if($item->type === 'temario')
            <div>
                <label style="font-weight:bold;">PDF actual</label>
                @if($item->file_path)
                    <div style="margin-top:6px;">
                        <a href="{{ asset($item->file_path) }}" target="_blank"
                           style="color:#4a6fa5; font-weight:bold;">
                            📄 Ver PDF actual
                        </a>
                    </div>
                @else
                    <p style="color:#666; font-size:0.9rem;">No hay PDF subido.</p>
                @endif
            </div>

            <div>
                <label style="font-weight:bold;">Subir nuevo PDF</label>
                <input type="file" name="file" accept=".pdf"
                       style="width:100%; padding:10px; border:1px solid #ccc;
                              border-radius:6px; margin-top:6px; box-sizing:border-box;">
                <p style="font-size:0.85rem; color:#666; margin-top:4px;">
                    Deja vacío para mantener el PDF actual.
                </p>
            </div>
        @endif

        {{-- BOTONES --}}
        <button type="submit"
                style="background:#4a6fa5; color:white; border:none;
                       padding:12px; border-radius:6px; font-size:1rem;
                       cursor:pointer; font-weight:bold;">
            💾 Guardar cambios
        </button>

        <a href="{{ route('courses.show', $course->view_name) }}"
           style="background:#6c757d; color:white; border:none;
                  padding:12px; border-radius:6px; font-size:1rem;
                  cursor:pointer; font-weight:bold; text-align:center;
                  text-decoration:none; display:block;">
            ✖ Cancelar
        </a>

    </form>
</div>

@include('includes.footer')