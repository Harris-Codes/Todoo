<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use App\Models\User;



class AuthController extends Controller

{
     // =====================Login=============================
    //When User first visit /Login this method runs
    public function showLoginForm()
    {
        return view('login');
    }

    //This method run once someone press submit the login form
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

           // To check if it's a student or teacher
            if (Auth::user()->role === 'Teacher') {
                return redirect()->route('teacher.dashboard');
            } elseif (Auth::user()->role === 'Student') {
                return redirect()->route('student.homepage');
            } else {
                return redirect('/dashboard'); // fallback
            }

        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->onlyInput('email');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // =====================Register=============================
    public function showRegisterForm()
    {
        return view('register');
    }

    // Handles form submission for registration
    public function register(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|string|in:Student,Teacher',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Optional validation
        ]);
        
        $imagePath = null;

        // Handle the uploaded profile picture if exists
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('profile_pictures', $filename, 'public');
        } else {
            $path = null;
        }
        
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'profile_picture' => $path,
        ]);
        

        return redirect('/login')->with('success', 'Account created successfully. Please log in.');
        
    }

    

}
