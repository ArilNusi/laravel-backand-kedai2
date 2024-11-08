<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        // Middleware untuk akses peran
    $this->middleware('role:admin,staff,user')->only(['index', 'create', 'store']);
    $this->middleware('role:admin,staff')->only(['edit', 'update']);
    $this->middleware('role:admin')->only(['destroy']);
    }

    // Index - dapat diakses oleh admin, staff, dan user
    public function index(Request $request)
    {
        $users = User::when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('pages.user.index', compact('users'));
    }

    // Create - hanya untuk admin dan staff
    public function create()
    {
        $roles = Role::all();
        return view('pages.user.create', compact('roles'));
    }

    // Store - hanya untuk admin dan staff
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'phone' => 'required',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }

    // Edit - hanya untuk admin dan staff
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::pluck('name')->all();

        // Staff tidak boleh mengedit admin
        if (auth()->user()->role === 'staff' && $user->role === 'admin') {
            return redirect()->route('user.index')->with('error', 'You cannot edit admin users.');
        }

        return view('pages.user.edit', compact('user', 'roles'));
    }

    // Update - hanya untuk admin dan staff
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8',
            'phone' => 'required',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($id);

        // Staff tidak boleh mengubah role admin
        if (auth()->user()->role === 'staff' && $user->role === 'admin') {
            return redirect()->route('user.index')->with('error', 'You cannot change role for admin users.');
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->role = $request->role;
        $user->save();

        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }

    // Destroy - hanya untuk admin
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Cegah pengguna menghapus dirinya sendiri
        if (auth()->user()->id === $user->id) {
            return redirect()->route('user.index')->with('error', 'You cannot delete yourself.');
        }

        // Staff tidak boleh menghapus admin
        if (auth()->user()->role === 'staff' && $user->role === 'admin') {
            return redirect()->route('user.index')->with('error', 'You cannot delete admin users.');
        }

        try {
            $user->delete();
            return redirect()->route('user.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('user.index')->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }
}
