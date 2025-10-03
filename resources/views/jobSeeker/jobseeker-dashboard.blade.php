<x-layout title="Job Seeker Dashboard">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">Welcome, {{ auth()->user()->name }}</h2>
    </div>

    <!-- Stats Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="text-gray-500 font-medium">Total Applications</h3>
          <p class="text-2xl font-bold mt-2">{{ optional($applications)->count() ?? 0 }}</p>
        </div>
        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="text-gray-500 font-medium">Active Jobs</h3>
            <p class="text-2xl font-bold mt-2">{{ $activeJobs->count() ?? 0 }}</p>
        </div>
        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="text-gray-500 font-medium">Profile Completeness</h3>
            <p class="text-2xl font-bold mt-2">{{ $profileCompletion ?? '0%' }}</p>
        </div>
    </div>

    <!-- Recent Jobs Section -->
    <div class="bg-white shadow rounded-xl p-6">
        <h3 class="text-xl font-semibold mb-4">Recent Jobs</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($jobs as $job)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $job->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $job->employer->company_name ?? $job->employer->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $job->category }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($job->is_active)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('jobs.show', $job->id) }}" class="text-blue-600 hover:underline">View</a> 
                                 @php
                                    $applied = auth()->user()->jobseeker
                                        ? auth()->user()->jobseeker->applications->contains('job_id', $job->id)
                                        : false;
                                @endphp

                                @if($applied)
                                    <span class="text-green-600 ml-2 font-medium">Applied</span>
                                @else
                                    <form action="{{ route('applications.store', $job->id) }}" method="POST" class="inline-block ml-2">
                                        @csrf
                                        <button type="submit" class="text-indigo-600 hover:underline">Apply</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No jobs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-layout>
