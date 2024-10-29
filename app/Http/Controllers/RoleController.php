<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RoleController extends Controller
{
    /**
     * Display a listing of the roles.
     */
    public function index(): View
    {
        $roles = Role::all();
        return view('gestion.role', compact('roles'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles'],
        ]);

        Role::create($request->only('name'));

        return redirect()->route('roles.index')->with('status', 'Role created successfully!');
    }

    /**
     * Update the specified role in storage.
     */

     public function edit(Role $role): View
     {
         $roles = Role::all();
         return view('gestion.role', compact('role'));
     }
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name,' . $role->id],
        ]);
        $role->name = $request->name;

        $role->save();

        return redirect()->route('roles.index')->with('status', 'Role updated successfully!');
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        $role->delete();
        return redirect()->route('roles.index')->with('status', 'Role deleted successfully!');
    }
}
