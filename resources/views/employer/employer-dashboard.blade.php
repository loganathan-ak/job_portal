<x-layout title="Employer Dashboard">

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white shadow rounded-xl p-6">
            <h2 class="text-gray-500 font-semibold">Total Jobs</h2>
            <p class="text-2xl font-bold text-blue-600">{{ $totalJobs ?? 0 }}</p>
        </div>

        <div class="bg-white shadow rounded-xl p-6">
            <h2 class="text-gray-500 font-semibold">Applications Received</h2>
            <p class="text-2xl font-bold text-blue-600">{{ $totalApplications ?? 0 }}</p>
        </div>

        <div class="bg-white shadow rounded-xl p-6">
            <h2 class="text-gray-500 font-semibold">Active Listings</h2>
            <p class="text-2xl font-bold text-blue-600">{{ $activeJobs ?? 0 }}</p>
        </div>
    </div>

    <!-- Recent Jobs Table -->
    <div class="bg-white shadow rounded-xl p-6 mb-6">
        <h2 class="font-semibold text-lg mb-4">Recent Job Postings</h2>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2">Job Title</th>
                    <th class="px-4 py-2">Category</th>
                    <th class="px-4 py-2">Applications</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $job)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $job->title }}</td>
                        <td class="px-4 py-2">{{ $job->category ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $job->applications_count }}</td>
                        <td class="px-4 py-2">
                            @if($job->is_active)
                                <span class="text-green-600 font-semibold">Active</span>
                            @else
                                <span class="text-red-600 font-semibold">Inactive</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <a href="{{ route('jobs.edit', $job->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            |
                            <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center text-gray-500">No jobs posted yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Recent Applications -->
    <div class="bg-white shadow rounded-xl p-6">
        <h2 class="font-semibold text-lg mb-4">Recent Applications</h2>
        <ul class="divide-y divide-gray-200">
            @forelse($applications as $app)
                <li class="py-3 flex justify-between items-center">
                    <span>{{ $app->job->title }} - {{ $app->applicant->name }}</span>
                    <span class="text-gray-500 text-sm">{{ $app->created_at->diffForHumans() }}</span>
                </li>
            @empty
                <li class="py-3 text-center text-gray-500">No applications received yet.</li>
            @endforelse
        </ul>
    </div>

</x-layout>
