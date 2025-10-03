<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
        public function show($id)
    {
        $job = Job::with('employer')->findOrFail($id);

        return view('jobs.view-job', compact('job'));
    }


        public function store($jobId)
    {
        $user = Auth::user();

        // Ensure user is a jobseeker
        if (!$user->jobseeker) {
            return redirect()->back()->with('error', 'Only job seekers can apply.');
        }

        // Check if job exists and is active
        $job = Job::findOrFail($jobId);
        if (!$job->is_active) {
            return redirect()->back()->with('error', 'This job is no longer active.');
        }

        // Prevent duplicate applications
        $alreadyApplied = Application::where('job_id', $job->id)
            ->where('user_id', $user->id)
            ->exists();

        if ($alreadyApplied) {
            return redirect()->back()->with('error', 'You have already applied for this job.');
        }

        // Create application
        Application::create([
            'job_id' => $job->id,
            'user_id' => $user->id,
            'status' => 'pending', // default status
        ]);

        return redirect()->back()->with('success', 'You have successfully applied for this job.');
    }
}
