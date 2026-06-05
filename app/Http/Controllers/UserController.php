<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Userr;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'surname'  => 'required|string|max:255',
            'mail'     => 'required|email|unique:userr,mail',
            'clave'    => 'required|string|min:4',
            'status'   => 'required|string',
            'rol'      => 'required|integer'
        ]);

        Userr::create([
            'name'              => $request->nombre,
            'surname'           => $request->surname,
            'mail'              => $request->mail,
            'password'          => Hash::make($request->clave),
            'registration_date' => now(),
            'status'            => $request->status,
            'id_role'           => $request->rol,
            'full_name'         => $request->nombre . ' ' . $request->surname
        ]);

        return redirect('/')->with('success', 'Usuario creado correctamente');
    }

    public function index()
    {
        if (auth()->user()->id_role != 1) {
            return redirect('/403');
        }

        $users = Userr::all();
        return view('admin.users.index', compact('users'));
    }

    public function edit($id)
    {
        if (auth()->user()->id_role != 1) {
            return redirect('/403');
        }

        $user = Userr::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->id_role != 1) {
            return redirect('/403');
        }

        $user = Userr::findOrFail($id);

        $request->validate([
            'name'    => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'mail'    => 'required|email|unique:userr,mail,' . $id . ',id_user',
            'status'  => 'required|string',
            'id_role' => 'required|integer',
        ]);

        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->mail = $request->mail;
        $user->status = $request->status;
        $user->id_role = $request->id_role;
        $user->full_name = $request->name . ' ' . $request->surname;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy($id)
    {
        if (auth()->user()->id_role != 1) {
            return redirect('/403');
        }

        $user = Userr::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'Usuario eliminado correctamente');
    }
}
