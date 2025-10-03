<x-layout title="My Jobs">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">My Jobs</h2>
        <a href="{{ route('jobs.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-xl font-medium hover:bg-blue-700 transition">
            + Add New Job
        </a>
    </div>
            @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-lg flex items-center" role="alert">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414L9 13.414l4.707-4.707z" clip-rule="evenodd" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-lg flex items-center" role="alert">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-4a1 1 0 112 0v1a1 1 0 11-2 0v-1zm0-6a1 1 0 112 0v4a1 1 0 11-2 0V8z" clip-rule="evenodd" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white shadow rounded-xl overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applications</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($jobs as $job)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $job->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $job->category }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $job->applications->count() }}</td>
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
                            <a href="{{ route('jobs.edit', $job->id) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                            <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
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

</x-layout>
