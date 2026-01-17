<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('role')
            ->whereHas('role', fn($q) => $q->where('name', '!=', 'admin'));

        if ($search = $request->get('search')) {
            $query->where('username', 'like', "%{$search}%");
        }

        if ($roleId = $request->get('role_id')) {
            $query->where('role_id', $roleId);
        }

        $allowedSorts = ['id', 'username', 'created_at'];
        $sort = in_array($request->get('sort'), $allowedSorts) ? $request->get('sort') : 'id';
        $direction = $request->get('direction') === 'desc' ? 'desc' : 'asc';
        $query->orderBy($sort, $direction);

        $users = $query->paginate(10)->withQueryString();

        $roles = Role::all();

        return view('users.index', compact('users', 'sort', 'direction', 'search', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $adminRoleId = Role::where('name', 'admin')->value('id');

        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6|confirmed',
            'role_id' => ['required', 'exists:roles,id', 'not_in:' . $adminRoleId],
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('users.index')->with('success', 'Użytkownik został dodany!');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $adminRoleId = Role::where('name', 'admin')->value('id');

        $request->validate([
            'username' => 'required|unique:users,username,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'role_id' => ['required', 'exists:roles,id', 'not_in:' . $adminRoleId],
        ]);

        $user->username = $request->username;
        $user->role_id = $request->role_id;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Użytkownik został zaktualizowany!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Użytkownik został usunięty!');
    }
}
