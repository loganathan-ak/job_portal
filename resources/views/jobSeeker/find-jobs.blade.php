<x-layout title="Find Jobs">

    <h2 class="text-2xl font-semibold mb-6">Find Jobs</h2>

    <!-- Filter Form -->
    <form id="filterForm" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <input type="text" name="keyword" id="keyword" value="{{ request('keyword') }}" placeholder="Keyword"
               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">

        <select name="category" id="category"
                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
            <option value="">All Categories</option>
            @foreach(['Software Development','Design','Marketing','Sales','Finance','Other'] as $cat)
                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>

        <input type="text" name="location" id="location" value="{{ request('location') }}" placeholder="Location"
               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">

        {{-- <button type="submit"
                class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 px-6 rounded-xl font-semibold hover:opacity-90 transition shadow-lg">
            Filter
        </button> --}}
    </form>

    <!-- Jobs Table -->
    <div class="bg-white shadow rounded-xl p-6 overflow-x-auto" id="jobsTable">
    <table class="min-w-full divide-y divide-gray-200">
<thead class="bg-gray-50">
    <tr>
        <th>Job Title</th>
        <th>Company</th>
        <th>Category</th>
        <th>Location</th> <!-- new -->
        <th>Status</th>
        <th>Action</th>
    </tr>
</thead>
<tbody id="table-body">
    @forelse($jobs as $job)
        <tr>
            <td class="text-center">{{ $job->title }}</td>
            <td class="text-center">{{ $job->employer->company_name ?? $job->employer->name }}</td>
            <td class="text-center">{{ $job->category }}</td>
            <td class="text-center">{{ $job->location ?? '-' }}</td> <!-- display location -->
            <td class="text-center">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $job->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $job->is_active ? 'Active' : 'Inactive' }}
                </span>
            </td>
            <td class="text-center">
                <a href="{{ route('jobs.show', $job->id) }}" class="text-blue-600 hover:underline">View</a>
                @if(in_array($job->id, $applications))
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
            <td colspan="6" class="text-center text-gray-500">No jobs found.</td>
        </tr>
    @endforelse
</tbody>
</table>


</div>


</x-layout>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('jobs.find') }}",
            type: "GET",
            data: $(this).serialize(),
            dataType: 'json',
success: function(response) {
    // Clear existing rows
    $('#table-body').empty();

    if(response.jobs && response.jobs.length > 0){
        response.jobs.forEach(function(job){
            let statusClass = job.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
            let statusText = job.is_active ? 'Active' : 'Inactive';

            let appliedHtml = response.applications.includes(job.id) 
                ? '<span class="text-green-600 ml-2 font-medium">Applied</span>' 
                : `<form action="/applications/${job.id}" method="POST" class="inline-block ml-2">
                       <input type="hidden" name="_token" value="${response.csrf}">
                       <button type="submit" class="text-indigo-600 hover:underline">Apply</button>
                   </form>`;

let row = `<tr class="bg-white divide-y divide-gray-200">
    <td class="px-6 py-4 text-center whitespace-nowrap">${job.title}</td>
    <td class="px-6 py-4 text-center whitespace-nowrap">${job.employer ? (job.employer.company_name || job.employer.name) : ''}</td>
    <td class="px-6 py-4 text-center whitespace-nowrap">${job.category}</td>
    <td class="px-6 py-4 text-center whitespace-nowrap">${job.location || '-'}</td>
    <td class="px-6 py-4 text-center whitespace-nowrap">
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusClass}">${statusText}</span>
    </td>
    <td class="px-6 py-4 text-center whitespace-nowrap">
        <a href="/jobs/${job.id}" class="text-blue-600 hover:underline">View</a>
        ${appliedHtml}
    </td>
</tr>`;


            $('#table-body').append(row);
        });
    } else {
        $('#table-body').append('<tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">No jobs found.</td></tr>');
    }
}

        });
    });

    $('#keyword').on('keyup', function() { $('#filterForm').submit(); });
    $('#category, #location').on('change', function() { $('#filterForm').submit(); });
});

</script>