<form method="POST" action="{{ url('/logout') }}" class="logout-form">
    @csrf

    <button type="submit" class="footer-btn logout-full">
        Cerrar sesión
    </button>
</form>