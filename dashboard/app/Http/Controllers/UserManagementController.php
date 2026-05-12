<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; // IMPORT INI
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.user', compact('users'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        return view('admin.add-user');
    }

    /**
     * Store a newly created user
     */
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
        'role' => 'required|in:admin,mentor,student',
        'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    try {
        DB::beginTransaction();

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role']
        ];

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('profile_photos', $filename, 'public');
            $userData['profile_photo'] = $path;
        }

        $user = User::create($userData);

        DB::commit();

        return redirect()->route('users.index')
            ->with('success', 'User created successfully!');
            
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withInput()
            ->with('error', 'Failed to create user: ' . $e->getMessage());
    }
}
    /**
     * Show the form for editing user
     */
public function edit($id)
{
    \Log::info("=== EDIT USER DEBUG ===");
    \Log::info("User ID requested: " . $id);
    \Log::info("URL: " . request()->fullUrl());
    
    try {
        $user = User::find($id);
        
        \Log::info("User found: " . ($user ? $user->name : 'NULL'));
        \Log::info("User data: " . ($user ? json_encode($user->toArray()) : 'NO DATA'));
        
        if (!$user) {
            \Log::warning("User not found with ID: " . $id);
            return redirect('/data-admin')->with('error', 'User not found with ID: ' . $id);
        }
        
        return view('admin.edit-user', compact('user'));
    } catch (\Exception $e) {
        \Log::error("Error editing user: " . $e->getMessage());
        return redirect('/data-admin')->with('error', 'Error loading user: ' . $e->getMessage());
    }
}

    /**
     * Update the specified user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|in:admin,mentor,student',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            DB::beginTransaction();

            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => $validated['role']
            ];

            // Update password only if provided
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($validated['password']);
            }

            // Handle profile photo upload
            if ($request->hasFile('profile_photo')) {
                // Delete old photo if exists
                if ($user->profile_photo) {
                    Storage::disk('public')->delete($user->profile_photo);
                }

                $file = $request->file('profile_photo');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('profile_photos', $filename, 'public');
                $userData['profile_photo'] = $path;
            }

            $user->update($userData);

            DB::commit();

            return redirect()->route('users.index')
                ->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to update user: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified user
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Delete profile photo if exists
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $user->delete();

            return redirect()->route('users.index')
                ->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }

    /**
     * Get user data for AJAX requests
     */
    public function getUserData($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }
}