@include('includes.header')
<link rel="stylesheet" href="{{ asset('recursos/css/principal.css') }}">

<div class="curso-header">
    <h1>{{ $item->title }}</h1>
</div>

<div class="curso-wrapper" style="max-width:700px; margin:30px auto;">

    @if(session('success'))
        <div style="background:#d4edda; color:#155724; padding:10px;
                    border-radius:6px; margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background:#f8f9fa; border-radius:8px; padding:20px; margin-bottom:25px;">
        <p><strong>Descripción:</strong> {{ $item->description ?? 'Sin descripción.' }}</p>
        @if($item->due_date)
            <p><strong>Fecha de entrega:</strong>
                {{ \Carbon\Carbon::parse($item->due_date)->format('d/m/Y') }}
            </p>
        @endif
    </div>

    @if(!in_array(auth()->user()->id_role, [1, 2]))
        <h2>Entregar tarea</h2>

        @if($submission)
            <div style="background:#d4edda; color:#155724; padding:10px;
                        border-radius:6px; margin-bottom:15px;">
                Ya entregaste esta tarea. Puedes volver a entregar para actualizarla.
            </div>
        @endif

        <form method="POST" action="{{ route('items.submit', $item->id_item) }}"
              enctype="multipart/form-data"
              style="display:flex; flex-direction:column; gap:14px;">
            @csrf

            <div>
                <label style="font-weight:bold;">Archivo a entregar</label>
                <input type="file" name="file"
                       style="width:100%; padding:10px; border:1px solid #ccc;
                              border-radius:6px; margin-top:6px; box-sizing:border-box;">
            </div>

            <div>
                <label style="font-weight:bold;">Comentario (opcional)</label>
                <textarea name="comment" rows="3"
                          style="width:100%; padding:10px; border:1px solid #ccc;
                                 border-radius:6px; margin-top:6px; box-sizing:border-box;">
                </textarea>
            </div>

            <button type="submit"
                    style="background:#4a6fa5; color:white; border:none;
                           padding:10px; border-radius:6px; font-weight:bold; cursor:pointer;">
                Entregar
            </button>
        </form>
    @endif

    @if(in_array(auth()->user()->id_role, [1, 2]))
        <a href="{{ route('items.submissions', $item->id_item) }}"
           style="display:inline-block; background:#4a6fa5; color:white; padding:10px 20px;
                  border-radius:6px; text-decoration:none; font-weight:bold;">
            Ver entregas de alumnos
        </a>
    @endif

</div>

@include('includes.footer')