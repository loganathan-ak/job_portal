<x-layout title="Job Details">

    <div class="max-w-4xl mx-auto bg-white shadow rounded-xl p-6 space-y-4">
        <h2 class="text-2xl font-semibold">{{ $job->title }}</h2>

        <div>
            <span class="font-medium text-gray-700">Company:</span>
            {{ $job->employer->company_name ?? $job->employer->name ?? 'N/A' }}
        </div>

        <div>
            <span class="font-medium text-gray-700">Category:</span>
            {{ $job->category }}
        </div>

        <div>
            <span class="font-medium text-gray-700">Location:</span>
            {{ $job->location ?? '-' }}
        </div>

        <div>
            <span class="font-medium text-gray-700">Status:</span>
            @if($job->is_active)
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                    Active
                </span>
            @else
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                    Inactive
                </span>
            @endif
        </div>

        <div>
            <span class="font-medium text-gray-700">Description:</span>
            <p class="mt-1 text-gray-600">{{ $job->description }}</p>
        </div>

        <div>
            <span class="font-medium text-gray-700">Skills Required:</span>
            <p class="mt-1 text-gray-600">
                @php
                    $skills = json_decode($job->skills, true) ?? [];
                @endphp
                {{ $skills ? implode(', ', $skills) : '-' }}
            </p>
        </div>

        <div>
            <span class="font-medium text-gray-700">Salary Range:</span>
            <p class="mt-1 text-gray-600">
                {{ $job->salary_min ? '₹'.number_format($job->salary_min) : '-' }} 
                -
                {{ $job->salary_max ? '₹'.number_format($job->salary_max) : '-' }}
            </p>
        </div>

        @php
            $user = auth()->user();
            $applied = $user->jobseeker && $user->jobseeker->applications->contains('job_id', $job->id);
        @endphp

        <div class="mt-4">
            @if($applied)
                <span class="inline-block px-4 py-2 bg-green-100 text-green-800 rounded-full font-semibold">
                    You have already applied
                </span>
            @else
                <form action="{{ route('applications.store', $job->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 px-6 rounded-xl font-semibold hover:opacity-90 transition shadow-lg">
                        Apply Now
                    </button>
                </form>
            @endif
        </div>
    </div>

</x-layout>
