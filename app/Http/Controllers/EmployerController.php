<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;
use App\Models\Application;

class EmployerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // Fetch jobs posted by this employer
        $jobs = Job::where('user_id', $user->id)
                    ->withCount('applications') // get applications count per job
                    ->latest()
                    ->take(5)
                    ->get();

        // Fetch recent applications to the employer's jobs
        $applications = Application::whereIn('job_id', $jobs->pluck('id'))
                                   ->with(['job', 'applicant'])
                                   ->latest()
                                   ->take(5)
                                   ->get();

        // Dashboard stats
        $totalJobs = Job::where('user_id', $user->id)->count();
        $activeJobs = Job::where('user_id', $user->id)->where('is_active', true)->count();
        $totalApplications = Application::whereIn('job_id', $jobs->pluck('id'))->count();

        return view('employer.employer-dashboard', compact(
            'jobs',
            'applications',
            'totalJobs',
            'activeJobs',
            'totalApplications'
        ));
    }


    public function myJobs()
{
    $user = Auth::user();

    // Get all jobs created by this employer, including application count
    $jobs = Job::where('user_id', $user->id)->get();

    // Pass jobs to the view
    return view('employer.my-jobs', compact('jobs'));
}


    public function createJob()
{
    $user = Auth::user();
    return view('employer.create-job');
}


public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'category' => 'required|string|in:Software Development,Design,Marketing,Sales,Finance,Other',
        'description' => 'required|string',
        'location' => 'nullable|string|max:255',
        'skills' => 'nullable|array',
        'skills.*' => 'string|max:50',
        'salary_min' => 'nullable|integer|min:0',
        'salary_max' => 'nullable|integer|min:0',
        'is_active' => 'nullable|boolean',
    ]);

    Job::create([
        'user_id' => Auth::id(),
        'title' => $request->title,
        'category' => $request->category,
        'description' => $request->description,
        'location' => $request->location,
        'skills' => $request->skills ? json_encode($request->skills) : null,
        'salary_min' => $request->salary_min,
        'salary_max' => $request->salary_max,
        'is_active' => $request->has('is_active') ? 1 : 0,
    ]);

    return redirect()->route('jobs.list')->with('success', 'Job created successfully!');
}


    public function edit($id)
    {
        $job = Job::where('user_id', Auth::id())->findOrFail($id);
        return view('employer.create-job', compact('job'));
    }

public function update(Request $request, $id)
{
    $job = Job::where('user_id', Auth::id())->findOrFail($id);

    $request->validate([
        'title' => 'required|string|max:255',
        'category' => 'required|string|in:Software Development,Design,Marketing,Sales,Finance,Other',
        'description' => 'required|string',
        'location' => 'nullable|string|max:255',
        'skills' => 'nullable|array',
        'skills.*' => 'string|max:50',
        'salary_min' => 'nullable|integer|min:0',
        'salary_max' => 'nullable|integer|min:0',
        'is_active' => 'nullable|boolean',
    ]);

    $job->update([
        'title' => $request->title,
        'category' => $request->category,
        'description' => $request->description,
        'location' => $request->location,
        'skills' => $request->skills ? json_encode($request->skills) : null,
        'salary_min' => $request->salary_min,
        'salary_max' => $request->salary_max,
        'is_active' => $request->has('is_active') ? 1 : 0,
    ]);

    return redirect()->route('jobs.list')->with('success', 'Job updated successfully!');
}


    /**
     * Delete a specific job.
     */
    public function destroy($id)
    {
        $job = Job::where('user_id', Auth::id())->findOrFail($id);
        $job->delete();

        return redirect()->route('jobs.list')->with('success', 'Job deleted successfully!');
    }



     public function applicantList()
    {
        $user = Auth::user();

        // Get all applications for jobs posted by this employer
        $applications = Application::with('job', 'applicant.jobseeker')
            ->whereHas('job', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->latest()
            ->paginate(10);

        return view('employer.applicants-list', compact('applications'));
    }

    // Optional: Update status
    public function updateApplicant($id, Request $request)
    {
        $application = Application::findOrFail($id);
        $application->status = $request->status;
        $application->save();

        return redirect()->back()->with('success', 'Application status updated.');
    }

}
