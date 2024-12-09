<?php
namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request){
        $incomingFields = $request->validate([
            'loginname'     => 'required',
            'loginpassword' => 'required'
        ]);

        if (Auth::attempt(['name' => $incomingFields['loginname'], 'password' => $incomingFields['loginpassword']])) {
            $request->session()->regenerate();
            return redirect()->route('pages.dashboard.index'); // Redirect to dashboard after successful login
        }

        return redirect()->route('pages.Authorization.login1')->withErrors(['loginname' => 'Invalid credentials.']);
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('pages.Authorization.login1');
    }

    public function register(Request $request)
    {
        // Validate input data
        $incomingFields = $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:8|max:10',
            
        ]);

        // Hash the password
        $incomingFields['password'] = bcrypt($incomingFields['password']);

        // Create the user without logging them in
        User::create($incomingFields);

        // Redirect to the login page
        return redirect()->route('pages.Authorization.login1')->with('success', 'Registration successful! Please log in.');
    }
}
