@include('includes.header')
<link rel="stylesheet" href="{{ asset('recursos/css/principal.css') }}">

<div class="curso-header page-crear-header">
    <h1>Crear nuevo curso</h1>
</div>

<div class="curso-wrapper page-crear-wrapper" style="max-width:600px; margin:40px auto;">

    @if($errors->any())
        <div class="alert-crear-curso"
             style="background:#f8d7da; color:#721c24; padding:10px;
                    border-radius:6px; margin-bottom:15px;">
            <ul style="margin:0; padding-left:20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('courses.store') }}" enctype="multipart/form-data"
          class="form-crear-curso"
          style="display:flex; flex-direction:column; gap:16px;">
        @csrf

        <div>
            <label class="label-crear-curso" style="font-weight:bold;">Nombre del curso</label>
            <input type="text" name="title" value="{{ old('title') }}"
                   placeholder="Ej: Física"
                   class="input-crear-curso"
                   style="width:100%; padding:10px; border:1px solid #ccc;
                          border-radius:6px; margin-top:6px; box-sizing:border-box;">
        </div>

        <div>
            <label class="label-crear-curso" style="font-weight:bold;">Descripción</label>
            <textarea name="description" rows="4"
                      placeholder="Descripción del curso..."
                      class="input-crear-curso"
                      style="width:100%; padding:10px; border:1px solid #ccc;
                             border-radius:6px; margin-top:6px; box-sizing:border-box;">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="label-crear-curso" style="font-weight:bold;">Imagen del curso</label>
            <input type="file" name="image" accept="image/*"
                   class="input-crear-curso"
                   style="width:100%; padding:10px; border:1px solid #ccc;
                          border-radius:6px; margin-top:6px; box-sizing:border-box;">
        </div>

        <button type="submit"
                class="btn-crear-curso"
                style="background:#4a6fa5; color:white; border:none;
                       padding:12px; border-radius:6px; font-size:1rem;
                       cursor:pointer; font-weight:bold;">
            Crear curso
        </button>

        <a href="{{ url('/home') }}"
           class="btn-cancelar-curso"
           style="background:#6c757d; color:white; border:none;
                  padding:12px; border-radius:6px; font-size:1rem;
                  cursor:pointer; font-weight:bold; text-align:center;
                  text-decoration:none; display:block;">
            Cancelar
        </a>

    </form>

</div>

@include('includes.footer')
