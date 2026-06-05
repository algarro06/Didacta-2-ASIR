@extends('layouts.didacta')

@section('content')

<h1 class="titulo">Gestión de usuarios</h1>

@if(session('success'))
    <div style="background:#d4edda; color:#155724; padding:12px; border-radius:8px; margin-bottom:20px;">
        {{ session('success') }}
    </div>
@endif

<div style="max-width:1100px; margin:auto;">

    <table style="width:100%; border-collapse:separate; border-spacing:0 10px;">
        <thead>
            <tr style="background:#f0f4ff; color:#1a2a6c;">
                <th style="padding:12px;">Nombre</th>
                <th style="padding:12px;">Email</th>
                <th style="padding:12px;">Rol</th>
                <th style="padding:12px;">Estado</th>
                <th style="padding:12px;">Acciones</th>
            </tr>
        </thead>

        <tbody>
        @foreach($users as $u)
            <tr style="background:white; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.08);">
                <td style="padding:14px;">{{ $u->full_name }}</td>
                <td style="padding:14px;">{{ $u->mail }}</td>
                <td style="padding:14px;">{{ $u->id_role }}</td>
                <td style="padding:14px;">{{ $u->status }}</td>

                <td style="padding:14px; display:flex; gap:10px;">

                    <a href="{{ route('admin.users.edit', $u->id_user) }}"
                       class="admin-btn"
                       style="padding:8px 14px;">
                        Editar
                    </a>

                    <form method="POST"
                          action="{{ route('admin.users.delete', $u->id_user) }}"
                          onsubmit="return confirm('¿Seguro que quieres eliminar este usuario?');">
                        @csrf
                        @method('DELETE')

                        <button class="admin-btn"
                                style="background:#dc3545; color:white; padding:8px 14px;">
                            🗑 Borrar
                        </button>
                    </form>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="margin-top:30px;">
        <a href="{{ url('/home') }}"
           style="display:inline-block; background:#6c757d; color:white;
                  padding:12px 24px; border-radius:6px; font-size:1rem;
                  font-weight:bold; text-decoration:none;">
            Cancelar
        </a>
    </div>

</div>

@endsection
