<div class="header">

    <div class="logo-area">
        <h1 class="titulo animacion">Didacta</h1>
        <h6 class="subtitulo animacion">Tu plataforma de recursos educativos</h6>
    </div>

    <!-- 👤 USUARIO -->
    <div class="user-welcome animacion">
        ¡Bienvenido, {{ auth()->user()->name ?? 'Usuario' }}!
    </div>

    @php
        $current = request()->path();
    @endphp

    <!-- 🔙 SOLO EN PÁGINAS INTERNAS -->
    @if (!str_contains($current, 'principal'))
        <div class="user-actions animacion">
            <a href="{{ url('/home') }}" class="back-btn">
                ← Volver al panel
            </a>
        </div>
    @endif

</div>

<hr class="linea animacion">

<!-- 🔥 MENU + DARK MODE + ADMIN -->
<div class="menu-wrapper animacion">

    <div class="menu">
        <article class="menu-item">
            <a href="{{ url('/home') }}">Recursos Educativos</a>
        </article>

        <article class="menu-item">
            <a href="{{ url('/news') }}">Novedades y Noticias</a>
        </article>

        <article class="menu-item">
            <a href="{{ url('/community') }}">Comunidad</a>
        </article>

        <article class="menu-item">
            <a href="{{ url('/events') }}">Eventos y Talleres</a>
        </article>
    </div>

    <!-- 🌙 BOTÓNES DERECHA -->
    <div style="display: flex; align-items: center; gap: 10px;">

        <!-- 🔐 BOTÓN ADMIN SOLO PROFESORES/ADMIN -->
        @if(auth()->check() && auth()->user()->id_role <= 2)
            <a href="{{ url('/admin/users/create') }}" class="admin-btn">
                ➕ Usuarios
            </a>
        @endif

        <!-- 🌙 DARK MODE -->
        <button id="theme-toggle" class="theme-btn">
            🌙
        </button>

    </div>

</div>