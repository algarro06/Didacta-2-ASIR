@include('includes.header')
<link rel="stylesheet" href="{{ asset('recursos/css/principal.css') }}">

<div class="curso-header dark-section">
    <h1>Editar curso</h1>
</div>

<div class="curso-wrapper dark-box" style="max-width:600px; margin:40px auto;">

    @if($errors->any())
        <div class="alert-error dark-alert">
            <ul style="margin:0; padding-left:20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="margin-bottom:20px;">
        <label class="dark-label" style="font-weight:bold;">Selecciona el curso a editar</label>
        <select id="selector-curso"
                class="dark-input"
                style="width:100%; padding:10px; border:1px solid #ccc;
                       border-radius:6px; margin-top:6px; font-size:1rem;">
            @foreach($courses as $c)
                <option value="{{ route('courses.edit', $c->id_course) }}"
                        {{ $c->id_course == $course->id_course ? 'selected' : '' }}>
                    {{ $c->title }}
                </option>
            @endforeach
        </select>
    </div>

    <form method="POST" action="{{ route('courses.update', $course->id_course) }}"
          enctype="multipart/form-data"
          class="dark-form"
          style="display:flex; flex-direction:column; gap:16px;">
        @csrf
        @method('PUT')

        <div>
            <label class="dark-label" style="font-weight:bold;">Nombre del curso</label>
            <input type="text" name="title" value="{{ old('title', $course->title) }}"
                   class="dark-input"
                   style="width:100%; padding:10px; border:1px solid #ccc;
                          border-radius:6px; margin-top:6px; box-sizing:border-box;">
        </div>

        <div>
            <label class="dark-label" style="font-weight:bold;">Descripción</label>
            <textarea name="description" rows="4"
                      class="dark-input"
                      style="width:100%; padding:10px; border:1px solid #ccc;
                             border-radius:6px; margin-top:6px; box-sizing:border-box;">{{ old('description', $course->description) }}</textarea>
        </div>

        <div>
            <label class="dark-label" style="font-weight:bold;">Imagen del curso</label>

            @if($course->image)
                <div style="margin-top:8px; margin-bottom:8px;">
                    <img src="{{ asset('recursos/imagenes/Imagenes_cursos/' . $course->image) }}"
                         style="width:120px; height:80px; object-fit:cover; border-radius:6px;">
                    <p class="dark-text" style="font-size:0.85rem; color:#666; margin-top:4px;">Imagen actual</p>
                </div>
            @endif

            <input type="file" name="image" accept="image/*"
                   class="dark-input"
                   style="width:100%; padding:10px; border:1px solid #ccc;
                          border-radius:6px; margin-top:6px; box-sizing:border-box;">

            <p class="dark-text" style="font-size:0.85rem; color:#666; margin-top:4px;">
                Deja vacío para mantener la imagen actual.
            </p>
        </div>

        <button type="submit"
                class="dark-btn"
                style="background:#4a6fa5; color:white; border:none;
                       padding:12px; border-radius:6px; font-size:1rem;
                       cursor:pointer; font-weight:bold;">
            Guardar cambios
        </button>

        <a href="{{ url('/home') }}"
           class="dark-btn"
           style="background:#6c757d; color:white; border:none;
                  padding:12px; border-radius:6px; font-size:1rem;
                  cursor:pointer; font-weight:bold; text-align:center;
                  text-decoration:none; display:block;">
            Cancelar
        </a>

    </form>
</div>

@include('includes.footer')

<script>
document.getElementById('selector-curso').addEventListener('change', function() {
    window.location.href = this.value;
});
</script>
