<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    /**
     * Show the settings page.
     */
    public function edit()
    {
        return view('settings');
    }

    /**
     * Update user settings for both employer and jobseeker.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Common validation
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ];

        // Role-specific validation
        if ($user->role === 'employer') {
            $rules = array_merge($rules, [
                'company_name' => 'nullable|string|max:255',
                'company_website' => 'nullable|url|max:255',
                'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'company_description' => 'nullable|string|max:2000',
            ]);
        } elseif ($user->role === 'jobseeker') {
            $rules = array_merge($rules, [
                'phone' => 'nullable|string|max:20',
                'resume' => 'nullable|mimes:pdf,doc,docx|max:5120',
                'experience' => 'nullable|numeric|min:0',
                'skills' => 'nullable|string|max:500',
            ]);
        }

        $request->validate($rules);

        // Update common fields
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Update role-specific fields
        if ($user->role === 'employer') {
            $employer = $user->employer;

            $employer->company_name = $request->company_name;
            $employer->company_website = $request->company_website;
            $employer->company_description = $request->company_description;

            if ($request->hasFile('company_logo')) {
                $employer->company_logo = $request->file('company_logo')->store('company_logos', 'public');
            }

            $employer->save();

        } elseif ($user->role === 'jobseeker') {
            $jobseeker = $user->jobseeker;

            $jobseeker->phone = $request->phone;
            $jobseeker->experience = $request->experience;
            $jobseeker->skills = $request->skills;

            if ($request->hasFile('resume')) {
                $jobseeker->resume = $request->file('resume')->store('resumes', 'public');
            }

            $jobseeker->save();
        }

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}
