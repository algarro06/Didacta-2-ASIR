@include('includes.header')
<link rel="stylesheet" href="{{ asset('recursos/css/principal.css') }}">

<div class="curso-header dark-section">
    <h1>Alumnos — {{ ucfirst($course->title) }}</h1>
</div>

<div class="curso-wrapper dark-box">

    @if(session('success'))
        <div class="dark-alert"
             style="background:#d4edda; color:#155724; padding:10px;
                    border-radius:6px; margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif

    <h2 class="dark-text">Alumnos matriculados</h2>

    @if($enrolled->isEmpty())
        <p class="dark-text">No hay alumnos matriculados en este curso todavía.</p>
    @else
        <table class="dark-table"
               style="width:100%; border-collapse:collapse; margin-bottom:30px;">
            <thead>
                <tr style="background:#f0f0f0;">
                    <th style="padding:10px; border:1px solid #ccc; text-align:left;">Nombre</th>
                    <th style="padding:10px; border:1px solid #ccc; text-align:left;">Apellido</th>
                    <th style="padding:10px; border:1px solid #ccc; text-align:left;">Email</th>
                    <th style="padding:10px; border:1px solid #ccc; text-align:center;">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($enrolled as $student)
                <tr>
                    <td style="padding:10px; border:1px solid #ccc;" class="dark-text">{{ $student->name }}</td>
                    <td style="padding:10px; border:1px solid #ccc;" class="dark-text">{{ $student->surname }}</td>
                    <td style="padding:10px; border:1px solid #ccc;" class="dark-text">{{ $student->mail }}</td>
                    <td style="padding:10px; border:1px solid #ccc; text-align:center;">
                        <form method="POST"
                              action="{{ route('courses.remove', [$course->view_name, $student->id_user]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="dark-btn"
                                    style="background:#dc3545; color:white; border:none;
                                           padding:6px 14px; border-radius:4px; cursor:pointer;"
                                    onclick="return confirm('¿Seguro que quieres eliminar a este alumno del curso?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <h2 class="dark-text">Añadir alumno al curso</h2>

    @if($available->isEmpty())
        <p class="dark-text">No hay más alumnos disponibles para añadir.</p>
    @else
        <form method="POST"
              action="{{ route('courses.enroll', $course->view_name) }}"
              style="display:flex; gap:10px; align-items:center; margin-top:10px;">
            @csrf
            <select name="user_id"
                    class="dark-input"
                    style="padding:8px; border-radius:4px; border:1px solid #ccc; min-width:250px;">
                @foreach($available as $student)
                    <option value="{{ $student->id_user }}">
                        {{ $student->name }} {{ $student->surname }} — {{ $student->mail }}
                    </option>
                @endforeach
            </select>
            <button type="submit"
                    class="dark-btn"
                    style="background:#28a745; color:white; border:none;
                           padding:8px 18px; border-radius:4px; cursor:pointer;">
                Añadir
            </button>
        </form>
    @endif

    <div style="margin-bottom:20px; margin-top:20px;">
        <a href="{{ route('courses.show', $course->view_name) }}"
           class="dark-btn"
           style="display:inline-block; background:#6c757d; color:white; padding:8px 18px;
                  border-radius:6px; text-decoration:none; font-weight:bold;">
            ← Volver al curso
        </a>
    </div>

</div>

@include('includes.footer')
