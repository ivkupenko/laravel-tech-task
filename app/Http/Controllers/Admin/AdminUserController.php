<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Users\Role;
use App\Models\Users\Gender;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::filter(request()->all())->with(['gender', 'role'])->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        $genders = Gender::all();

        return view('admin.users.create', compact('roles', 'genders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'gender_id' => 'nullable|exists:genders,id',
            'age' => 'nullable|integer|min:1|max:120',
            'role_id' => 'required|exists:roles,id',
        ]);

        $validated['password'] = Hash::make('password');
        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');

    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $genders = Gender::all();

        return view('admin.users.edit', compact('user', 'roles', 'genders'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'gender_id' => 'nullable|exists:genders,id',
            'age' => 'nullable|integer|min:1|max:120',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
