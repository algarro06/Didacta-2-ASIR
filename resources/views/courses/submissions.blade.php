@include('includes.header')
<link rel="stylesheet" href="{{ asset('recursos/css/principal.css') }}">
<div class="curso-header">
    <h1>📬 Entregas — {{ $item->title }}</h1>
</div>
<div class="curso-wrapper">
    @if($submissions->isEmpty())
        <p>Ningún alumno ha entregado esta tarea todavía.</p>
    @else
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#f0f0f0;">
                    <th style="padding:10px; border:1px solid #ccc; text-align:left;">Alumno</th>
                    <th style="padding:10px; border:1px solid #ccc; text-align:left;">Comentario</th>
                    <th style="padding:10px; border:1px solid #ccc; text-align:left;">Fecha</th>
                    <th style="padding:10px; border:1px solid #ccc; text-align:center;">Archivo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($submissions as $sub)
                <tr>
                    <td style="padding:10px; border:1px solid #ccc;">
                        {{ $sub->user->name }} {{ $sub->user->surname }}
                    </td>
                    <td style="padding:10px; border:1px solid #ccc;">
                        {{ $sub->comment ?? '—' }}
                    </td>
                    <td style="padding:10px; border:1px solid #ccc;">
                        {{ $sub->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td style="padding:10px; border:1px solid #ccc; text-align:center;">
                        <a href="{{ asset($sub->file_path) }}" target="_blank"
                           style="color:#4a6fa5; font-weight:bold;">
                            📥 Descargar
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@include('includes.footer')