@extends('layouts.didacta')

@section('content')

<h1 class="titulo">Editar usuario</h1>

<div style="
    max-width:700px;
    margin:auto;
    background:white;
    padding:30px;
    border-radius:16px;
    box-shadow:0 6px 20px rgba(0,0,0,0.12);
">

    @if ($errors->any())
        <div style="background:#f8d7da; color:#721c24; padding:12px; border-radius:8px; margin-bottom:20px;">
            <ul style="margin:0; padding-left:18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.update', $user->id_user) }}">
        @csrf
        @method('PUT')

        <label style="font-weight:600;">Nombre</label>
        <input type="text" name="name" value="{{ $user->name }}" class="custom-input"
               style="width:100%; margin-bottom:15px; padding:10px; border-radius:8px; border:1px solid #ccc;" required>

        <label style="font-weight:600;">Apellido</label>
        <input type="text" name="surname" value="{{ $user->surname }}" class="custom-input"
               style="width:100%; margin-bottom:15px; padding:10px; border-radius:8px; border:1px solid #ccc;" required>

        <label style="font-weight:600;">Email</label>
        <input type="email" name="mail" value="{{ $user->mail }}" class="custom-input"
               style="width:100%; margin-bottom:15px; padding:10px; border-radius:8px; border:1px solid #ccc;" required>

        <label style="font-weight:600;">Rol</label>
        <select name="id_role" class="custom-input"
                style="width:100%; margin-bottom:15px; padding:10px; border-radius:8px; border:1px solid #ccc;">
            <option value="1" {{ $user->id_role == 1 ? 'selected' : '' }}>Admin</option>
            <option value="2" {{ $user->id_role == 2 ? 'selected' : '' }}>Profesor</option>
            <option value="3" {{ $user->id_role == 3 ? 'selected' : '' }}>Alumno</option>
        </select>

        <label style="font-weight:600;">Estado</label>
        <select name="status" class="custom-input"
                style="width:100%; margin-bottom:15px; padding:10px; border-radius:8px; border:1px solid #ccc;">
            <option value="activo" {{ $user->status == 'activo' ? 'selected' : '' }}>Activo</option>
            <option value="inactivo" {{ $user->status == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
        </select>

        <label style="font-weight:600;">Nueva contraseña (opcional)</label>
        <input type="password" name="password" class="custom-input"
               style="width:100%; margin-bottom:25px; padding:10px; border-radius:8px; border:1px solid #ccc;">

        <button type="submit" class="admin-btn" style="padding:10px 20px;">
            Guardar cambios
        </button>
        <div style="margin-top:30px;">
        <a href="{{ url('/admin/users/') }}"
           style="display:inline-block; background:#6c757d; color:white;
                  padding:12px 24px; border-radius:6px; font-size:1rem;
                  font-weight:bold; text-decoration:none;">
            Cancelar
        </a>
    </div>
</form>

</div>

@endsection
