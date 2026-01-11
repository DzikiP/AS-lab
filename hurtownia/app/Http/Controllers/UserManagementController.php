<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    // Lista wszystkich użytkowników
    public function index()
    {
        // Pobierz użytkowników z relacją role, poza adminami
        $users = User::with('role')
            ->whereHas('role', function ($query) {
                $query->where('name', '!=', 'admin');
            })
            ->get();

        return view('users.index', compact('users'));
    }

    // Formularz tworzenia nowego użytkownika
    public function create()
    {
        $roles = Role::all(); // admin, worker, client
        return view('users.create', compact('roles'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|unique:users,username,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->username = $request->username;
        $user->role_id = $request->role_id;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Użytkownik został zaktualizowany!');
    }


    // Zapis nowego użytkownika
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'created_by' => $request->user()->name,
            'updated_by' => $request->user()->name,
        ]);

        return redirect()->route('users.index')->with('success', 'Użytkownik został dodany!');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Użytkownik został usunięty.');
    }
}
