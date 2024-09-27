<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole('user');

        return redirect()->route('home')->with('success', 'Registration successful. You can now log in.');
    }

    public function requestRole(Request $request)
    {
        $request->validate([
            'role' => 'required|in:author,editor',
        ]);

        $user = auth()->user();
        $user->requested_role = $request->role;
        $user->save();


        return redirect()->route('home')->with('success', 'Role request submitted for approval.');
    }
}
