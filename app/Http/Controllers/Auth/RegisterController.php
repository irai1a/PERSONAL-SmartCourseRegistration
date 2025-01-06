<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        // Show the registration form
        return view('auth.register');
    }

    public function register(Request $request)
{
    // Validate the request data
    $request->validate([
        'name' => 'required|string|max:255', // Validate the name field
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|in:student,academic_staff',
    ]);

    // Create the new user in the database
    $user = User::create([
        'name' => $request->name, // Store the name
        'email' => $request->email,
        'password' => bcrypt($request->password), // Hash the password
        'role' => $request->role, // Store the role
    ]);

    // Log the user in
    Auth::login($user);

    // Redirect to the home page or dashboard
    return redirect('/home'); // Or wherever you want to redirect the user
}


}
