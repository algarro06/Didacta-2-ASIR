@include('includes.header')
<link rel="stylesheet" href="{{ asset('recursos/css/principal.css') }}">

<div class="curso-header dark-section">
    <h1>Cursos disponibles</h1>
</div>

<div class="curso-wrapper dark-box">
    @foreach($courses as $course)
        <div class="curso-card dark-box"
             style="border:1px solid #ccc; margin:10px; padding:15px; border-radius:8px;">
             
            <h3 class="dark-text">{{ ucfirst($course->title) }}</h3>
            <p class="dark-text">{{ $course->description }}</p>
            <p class="dark-text">Estado: {{ $course->status }}</p>

            <a href="{{ route('courses.show', $course->title) }}"
               class="dark-btn"
               style="display:inline-block; padding:8px 16px; background:#4a6fa5;
                      color:white; border-radius:6px; text-decoration:none; margin-top:8px;">
                Entrar al curso
            </a>
        </div>
    @endforeach
</div>

@include('includes.footer')
