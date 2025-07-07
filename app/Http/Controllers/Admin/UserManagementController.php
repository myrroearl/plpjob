<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = User::query();

            // Search functionality
            if ($search = $request->input('search')) {
                $query->where(function($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('middle_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('degree_name', 'like', "%{$search}%");
                });
            }

            // Role filter
            if ($roles = $request->input('roles')) {
                $query->whereIn('role', $roles);
            }

            // Verification status filter
            if ($request->has('verified')) {
                if ($request->input('verified') === '1') {
                    $query->whereNotNull('email_verified_at');
                } else {
                    $query->whereNull('email_verified_at');
                }
            }

            // Sorting
            switch ($request->input('sort')) {
                case 'oldest':
                    $query->oldest();
                    break;
                case 'name':
                    $query->orderBy('first_name')->orderBy('last_name');
                    break;
                default:
                    $query->latest();
                    break;
            }

            $users = $query->paginate(10)->withQueryString();
            return view('admin.users.index', compact('users'));

        } catch (\Exception $e) {
            Log::error('User listing error: ' . $e->getMessage());
            return back()->with('error', 'Error loading users: ' . $e->getMessage());
        }
    }

    public function edit(User $user)
    {
        try {
            return view('admin.users.edit', compact('user'));
        } catch (\Exception $e) {
            Log::error('User edit error: ' . $e->getMessage());
            return back()->with('error', 'Error loading user details: ' . $e->getMessage());
        }
    }

    public function update(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:100',
                'middle_name' => 'nullable|string|max:100',
                'last_name' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'degree_name' => 'required|string|max:100',
                // 'role' => 'required|in:user,recruiter,admin', // Remove or make optional if not in form
            ]);

            $user->update($validated);

            // Log the successful update
            Log::info("User updated successfully: {$user->id}");

            return redirect()->route('admin.users.index')
                ->with('success', 'User updated successfully');

        } catch (\Exception $e) {
            Log::error('User update error: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Error updating user: ' . $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            
            // Log the successful deletion
            Log::info("User deleted successfully: {$user->id}");

            return redirect()->route('admin.users.index')
                ->with('success', 'User deleted successfully');

        } catch (\Exception $e) {
            Log::error('User deletion error: ' . $e->getMessage());
            return back()->with('error', 'Error deleting user: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'required|unique:users,id',
                'first_name' => 'required|string|max:100',
                'middle_name' => 'nullable|string|max:100',
                'last_name' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email',
                'degree_name' => 'required|string|max:100',
                'birthday' => 'required|date',
            ]);

            // Generate username and password from ID and birthday
            $birthday = new \DateTime($request->birthday);
            $username = $validated['id'];
            $password = $username . $birthday->format('m/d/y');

            // Calculate age
            $today = new \DateTime();
            $age = $birthday->diff($today)->y;

            // Create user with generated credentials and calculated age
            $user = User::create([
                'id' => $validated['id'],
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'password' => $password,
                'degree_name' => $validated['degree_name'],
                'age' => $age, // Add the calculated age
            ]);

            Log::info("User created successfully: {$user->id}");
            return response()->json([
                'message' => 'User created successfully',
                'username' => $username,
                'password' => $password
            ]);

        } catch (\Exception $e) {
            Log::error('User creation error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error creating user: ' . $e->getMessage()
            ], 422);
        }
    }

    public function updateUser(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'id' => 'required|unique:users,id,' . $user->id,
                'first_name' => 'required|string|max:100',
                'middle_name' => 'required|string|max:100',
                'last_name' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'degree_name' => 'required|string|max:100',
                'birthday' => 'required|date',
            ]);

            // If the ID is changed, update it
            if ($user->id !== $validated['id']) {
                $user->id = $validated['id'];
            }

            // Generate new password if birthday is changed
            if ($request->filled('birthday')) {
                $birthday = new \DateTime($request->birthday);
                $username = $validated['id'];
                $password = $username . $birthday->format('m/d/y');
                $validated['password'] = $password;
            }

            $user->update($validated);

            Log::info("User updated successfully: {$user->id}");
            return response()->json([
                'message' => 'User updated successfully',
                'password' => $password ?? null
            ]);

        } catch (\Exception $e) {
            Log::error('User update error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error updating user: ' . $e->getMessage()
            ], 422);
        }
    }

    public function show(User $user)
    {
        try {
            return view('admin.users.show', compact('user'));
        } catch (\Exception $e) {
            Log::error('User view error: ' . $e->getMessage());
            return back()->with('error', 'Error loading user details: ' . $e->getMessage());
        }
    }
}