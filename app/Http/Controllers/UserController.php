<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private function authorizeAdmin(): void
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Access denied.');
        }
    }

    public function index(): JsonResponse
    {
        $users = User::all();
        return response()->json($users);
    }

    public function count(): JsonResponse
    {
        $this->authorizeAdmin();

        return response()->json([
            'users' => User::count(),
        ]);
    }

    public function countAdmins(): JsonResponse
    {
        $this->authorizeAdmin();

        $admins = User::where('role', 'admin')->count();
        return response()->json([
            'admins' => $admins,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => 'required|string|in:user,admin',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        return response()->json($user, 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $this->authorizeAdmin();

        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => "required|string|email|unique:users,email,{$id}",
            'password' => 'nullable|string|min:6',
            'role'     => 'required|string|in:user,admin',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return response()->json($user);
    }

    public function destroy($id): JsonResponse
    {
        $this->authorizeAdmin();

        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }
    
    public function onlineCount()
{
    $timeLimit = now()->subMinutes(5);
    $onlineUsersCount = \App\Models\User::where('last_activity', '>=', $timeLimit)->count();
    return response()->json(['count' => $onlineUsersCount]);
}

}
