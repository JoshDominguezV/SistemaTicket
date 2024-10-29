<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::with('role')->get();
        $roles = Role::all();
        return view('gestion.users', compact('users', 'roles'));
    }

    public function create(): View
    {
        $roles = Role::all();
        return view('gestion.users', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validateRequest($request);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('users.index')->with('status', 'User created successfully!');
    }

    public function edit(User $user): View
    {
        $roles = Role::all();
        return view('gestion.users', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        'role_id' => 'required|exists:roles,id',
        'password' => 'nullable|string|min:8|confirmed', // Confirmed puede ser removido si no lo necesitas
    ]);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->username = $request->username;
    $user->role_id = $request->role_id;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->route('users.index')->with('success', 'User updated successfully.');
}


    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return redirect()->route('users.index')->with('status', 'User deleted successfully!');
    }

    protected function validateRequest(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $request->user()->id,
            'username' => 'required|string|max:255|unique:users,username,' . $request->user()->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);
    }
}
