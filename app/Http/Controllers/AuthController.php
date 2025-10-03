<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jobseeker;
use App\Models\Employer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
   public function register(Request $request)
{
    // Base validation
    $rules = [
        'name'      => 'required|string|max:255',
        'email'     => 'required|string|email|max:255|unique:users',
        'role'      => 'required|in:jobseeker,employer',
        'password'  => 'required|string|min:6|confirmed',
    ];

    // Add role-specific validation
    if ($request->role === 'jobseeker') {
        $rules = array_merge($rules, [
            'phone'      => 'nullable|string|max:20',
            'resume'     => 'required|mimes:pdf,doc,docx|max:2048', // 2MB
            'experience' => 'required|integer|min:0',
            'skills'     => 'nullable|string|max:500',
        ]);
    }

    if ($request->role === 'employer') {
        $rules = array_merge($rules, [
            'company_name'        => 'required|string|max:255',
            'company_website'     => 'nullable|url|max:255',
            'contact_number'      => 'nullable|string|max:20',
            'company_logo'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'company_description' => 'nullable|string|max:1000',
        ]);
    }

    // Run validation
    $validated = $request->validate($rules);

    // Create user
    $user = User::create([
        'name'     => $validated['name'],
        'email'    => $validated['email'],
        'role'     => $validated['role'],
        'password' => Hash::make($validated['password']),
    ]);

    // Save extra details depending on role
    if ($user->role === 'jobseeker') {
        $resumePath = $request->hasFile('resume')
            ? $request->file('resume')->store('resumes', 'public')
            : null;

        Jobseeker::create([
            'user_id'   => $user->id,
            'phone'     => $validated['phone'] ?? null,
            'resume'    => $resumePath,
            'experience'=> $validated['experience'] ?? null,
            'skills'    => $validated['skills'] ?? null,
        ]);
    }

    if ($user->role === 'employer') {
        $logoPath = $request->hasFile('company_logo')
            ? $request->file('company_logo')->store('company_logos', 'public')
            : null;

        Employer::create([
            'user_id'             => $user->id,
            'company_name'        => $validated['company_name'],
            'company_website'     => $validated['company_website'] ?? null,
            'contact_number'      => $validated['contact_number'] ?? null,
            'company_logo'        => $logoPath,
            'company_description' => $validated['company_description'] ?? null,
        ]);
    }

    Auth::login($user);

    return redirect()->route('login')->with('success', 'Registration successful!');
}



public function login(Request $request)
{
    // Validate input
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required|string',
    ]);

    // Attempt login
    if (Auth::attempt($credentials, $request->filled('remember'))) {
        $request->session()->regenerate(); // Prevent session fixation

        // Redirect based on role
        $user = Auth::user();
        if ($user->role === 'jobseeker') {
            return redirect()->route('jobseeker.dashboard');
        } elseif ($user->role === 'employer') {
            return redirect()->route('employer.dashboard');
        } else {
            return redirect()->route('welcome');
        }
    }

    // If authentication fails
    throw ValidationException::withMessages([
        'email' => ['The provided credentials do not match our records.'],
    ]);
}



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    

}
