<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class JobseekerController extends Controller
{
    public function dashboard()
{
   $user = Auth::user();

    // All applications by this job seeker
    $applications = $user->jobseeker ? $user->jobseeker->applications : collect();

    // All active jobs
    $activeJobs = Job::where('is_active', 1)->get();

    // Optional: calculate profile completeness
    $profileCompletion = 80; // Example static value

    // Latest 10 jobs for table
    $jobs = Job::with('employer')->latest()->take(10)->get();

    return view('jobseeker.jobseeker-dashboard', compact('applications', 'activeJobs', 'jobs', 'profileCompletion'));
}



public function find(Request $request)
{
    $user = Auth::user();
    $query = Job::with('employer')->where('is_active', 1);

    if ($keyword = $request->keyword) {
        $query->where(function($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
              ->orWhere('description', 'like', "%{$keyword}%");
        });
    }

    if ($category = $request->category) {
        $query->where('category', $category);
    }

    if ($location = $request->location) {
        $query->where('location', 'like', "%{$location}%");
    }

    $jobs = $query->latest()->get();

    $applications = $user->jobseeker ? $user->jobseeker->applications->pluck('job_id')->toArray() : [];

    if ($request->ajax()) {
        return response()->json([
            'jobs' => $jobs,
            'applications' => $applications,
            'csrf' => csrf_token(),
        ]);
    }

    return view('jobseeker.find-jobs', compact('jobs', 'applications'));
}






    public function myApplications()
    {
        $user = Auth::user();

        if (!$user->jobseeker) {
            return redirect()->back()->with('error', 'Only job seekers have applications.');
        }

        $applications = $user->jobseeker->applications()->with('job.employer')->latest()->paginate(10);

        return view('jobseeker.my-applications', compact('applications'));
    }
}
