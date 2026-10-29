<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getUsers()
    {
        $users = User::where('status', 1)
            ->with('assignedRole')
            ->orderBy('created_at', 'ASC')
            ->get();

        $data = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->assignedRole?->role_name ?? $user->role ?? '',
                'status' => $user->status,
            ];
        });

        return response()->json(['data' => $data]);
    }

    public function index()
    {
        $users = User::latest()->get();
        return view('user_management.index', compact('users'));
    }


    public function create()
    {
        $roles = Role::pluck('role_name', 'id')->all(); // Fetch role IDs as keys
        return view('user_management.create', compact('roles'));
    }

    public function store(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role_id' => ['required', 'integer', 'exists:roles,id'],
            'status' => ['required', 'in:0,1'],
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['role'] = $validatedData['role_id'];
        unset($validatedData['role_id']);

        User::create($validatedData);

        return redirect()->route('user.index')->with('success', 'User created successfully');
    }

    public function edit($id)
    {
        $user = User::with('assignedRole')->findOrFail($id);

        $roles = Role::pluck('role_name', 'id')->all();

        $userRole = $user->assignedRole?->role_name;

        return view('user_management.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'roles' => 'required', // Ensure the role is selected
            'status' => 'required',
        ]);
        // dd($request);

        $role = Role::where('role_name', $request->input('roles'))->first();

        $user = User::findOrFail($id);
    
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'status' => $request->input('status'),
            'role' => $role ? $role->id : null, // Store the role ID
        ]);
    
        return redirect()->route('user.index')->with('success', 'User updated successfully');
       
    }


    public function delete(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Something went wrong. Please try again.'], 404);
        }

        $user->update([
            'status' => 0
        ]);

        return response()->json(['success' => 'User deleted successfully!']);
    }

}
