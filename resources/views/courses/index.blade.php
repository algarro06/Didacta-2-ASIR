@include('includes.header')
<link rel="stylesheet" href="{{ asset('recursos/css/principal.css') }}">

<div class="curso-header">
    <h1>📚 Cursos disponibles</h1>
</div>

<div class="curso-wrapper">
    @foreach($courses as $course)
        <div style="border:1px solid #ccc; margin:10px; padding:15px; border-radius:8px;">
            <h3>{{ ucfirst($course->title) }}</h3>
            <p>{{ $course->description }}</p>
            <p>Estado: {{ $course->status }}</p>
            <a href="{{ route('courses.show', $course->title) }}"
               style="display:inline-block; padding:8px 16px; background:#4a6fa5;
                      color:white; border-radius:6px; text-decoration:none; margin-top:8px;">
                📖 Entrar al curso
            </a>
        </div>
    @endforeach
</div>

@include('includes.footer')