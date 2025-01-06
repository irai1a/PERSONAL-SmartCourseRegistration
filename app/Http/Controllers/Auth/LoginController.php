<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle the login request
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Check the user's role and redirect to the corresponding dashboard
            if ($user->role == 'student') {
                return redirect()->route('student.dashboard'); // Redirect to the student dashboard
            }

            if ($user->role == 'academic_staff') {
                return redirect()->route('academic.dashboard'); // Redirect to the academic staff dashboard
            }
        }

        // If authentication fails, redirect back to the login page with errors
        return redirect()->route('login')->withErrors(['email' => 'Invalid credentials']);
    }

    /**
     * Handle a successful login and redirect based on the user role.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Auth\Events\Login $event
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        // Check user role and redirect accordingly
        if ($user->role == 'student') {
            return redirect()->route('student.dashboard'); // Redirect to student dashboard
        } elseif ($user->role == 'academic_staff') {
            return redirect()->route('academic.dashboard'); // Redirect to academic staff dashboard
        }

        return redirect('/'); // Default redirection if no role matched
    }
}
