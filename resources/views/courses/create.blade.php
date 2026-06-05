@include('includes.header')
<link rel="stylesheet" href="{{ asset('recursos/css/principal.css') }}">

<div class="curso-header dark-section">
    <h1>Crear nuevo curso</h1>
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

    <form method="POST" action="{{ route('courses.store') }}" enctype="multipart/form-data"
          class="dark-form">
        @csrf

        <div>
            <label class="dark-label">Nombre del curso</label>
            <input type="text" name="title" value="{{ old('title') }}"
                   placeholder="Ej: Física"
                   class="dark-input">
        </div>

        <div>
            <label class="dark-label">Descripción</label>
            <textarea name="description" rows="4"
                      placeholder="Descripción del curso..."
                      class="dark-input">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="dark-label">Imagen del curso</label>
            <input type="file" name="image" accept="image/*"
                   class="dark-input">
        </div>

        <button type="submit" class="btn-primary dark-btn">
            Crear curso
        </button>

        <a href="{{ url('/home') }}" class="btn-secondary dark-btn">
            Cancelar
        </a>

    </form>

</div>

@include('includes.footer')
