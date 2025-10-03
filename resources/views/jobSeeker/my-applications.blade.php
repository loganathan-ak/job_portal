<x-layout title="My Applications">

    <h2 class="text-2xl font-semibold mb-6">My Applications</h2>

    <div class="bg-white shadow rounded-xl p-6 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied On</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($applications as $application)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $application->job->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $application->job->employer->company_name ?? $application->job->employer->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $application->job->category }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($application->status == 'pending')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                            @elseif($application->status == 'accepted')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Accepted
                                </span>
                            @elseif($application->status == 'rejected')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Rejected
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $application->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('jobs.show', $application->job->id) }}" class="text-blue-600 hover:underline">View Job</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">You have not applied to any jobs yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $applications->links() }}
        </div>
    </div>

</x-layout>
