<x-layout title="Applicants List">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">Applicants for Your Jobs</h2>
        <a href="{{ route('applications.export.excel') }}"
           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">
           Export to Excel
        </a>
    </div>

    <div class="bg-white shadow rounded-xl p-6 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applicant Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied On</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Resume</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($applications as $application)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $application->job->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $application->applicant->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $application->applicant->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $application->applicant->jobseeker->phone ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $application->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($application->status == 'pending')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            @elseif($application->status == 'accepted')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Accepted</span>
                            @elseif($application->status == 'rejected')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($application->applicant->jobseeker->resume)
                                <a href="{{ asset('storage/' . $application->applicant->jobseeker->resume) }}"
                                   class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm"
                                   target="_blank" download>
                                    Download
                                </a>
                            @else
                                <span class="text-gray-500 text-sm">No Resume</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('applications.update', $application->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="border rounded px-2 py-1 text-sm">
                                    <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>Accept</option>
                                    <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Reject</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">No applicants found yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $applications->links() }}
        </div>
    </div>

</x-layout>
