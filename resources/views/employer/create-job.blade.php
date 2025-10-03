@php
    $isEdit = isset($job);
@endphp

<x-layout :title="$isEdit ? 'Edit Job' : 'Add New Job'">

    <div class="bg-white shadow rounded-xl p-6 max-w-3xl mx-auto">
        <h2 class="text-2xl font-semibold mb-6">{{ $isEdit ? 'Edit Job' : 'Add New Job' }}</h2>

        <form id="jobForm" action="{{ $isEdit ? route('jobs.update', $job->id) : route('jobs.store') }}" method="POST" class="space-y-5">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <!-- Job Title -->
            <div>
                <label for="title" class="block text-gray-700 font-medium mb-1">Job Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $job->title ?? '') }}"
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-gray-700 font-medium mb-1">Description</label>
                <textarea name="description" id="description" rows="5"
                          class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">{{ old('description', $job->description ?? '') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Location -->
            <div>
                <label for="location" class="block text-gray-700 font-medium mb-1">Location</label>
                <input type="text" name="location" id="location" value="{{ old('location', $job->location ?? '') }}"
                       placeholder="City, Country"
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
                @error('location')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-gray-700 font-medium mb-1">Category</label>
                <select name="category" id="category"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
                    <option value="" disabled {{ old('category', $job->category ?? '') ? '' : 'selected' }}>Select Category</option>
                    @foreach(['Software Development','Design','Marketing','Sales','Finance','Other'] as $cat)
                        <option value="{{ $cat }}" {{ old('category', $job->category ?? '') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                @error('category')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Skills (comma-separated) -->
            <div>
                <label for="skills" class="block text-gray-700 font-medium mb-1">Skills Required</label>
                <input type="text" name="skills_input" id="skills" 
                        value="{{ old('skills', isset($job->skills) ? implode(', ', (array) json_decode($job->skills)) : '') }}"
                       placeholder="PHP, Laravel, Tailwind"
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
                @error('skills')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Salary Range -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="salary_min" class="block text-gray-700 font-medium mb-1">Salary Min</label>
                    <input type="number" name="salary_min" id="salary_min"
                           value="{{ old('salary_min', $job->salary_min ?? '') }}" placeholder="e.g., 30000"
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
                    @error('salary_min')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="salary_max" class="block text-gray-700 font-medium mb-1">Salary Max</label>
                    <input type="number" name="salary_max" id="salary_max"
                           value="{{ old('salary_max', $job->salary_max ?? '') }}" placeholder="e.g., 60000"
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
                    @error('salary_max')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Active Checkbox -->
            <div>
                <label for="is_active" class="inline-flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" class="rounded border-gray-300"
                        {{ old('is_active', $job->is_active ?? false) ? 'checked' : '' }}>
                    <span class="ml-2 text-gray-700">Active</span>
                </label>
            </div>

            <!-- Submit -->
            <button type="submit"
                    class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 px-6 rounded-xl font-semibold hover:opacity-90 transition shadow-lg">
                {{ $isEdit ? 'Update Job' : 'Create Job' }}
            </button>
        </form>
    </div>

    <!-- JS to handle comma-separated skills -->
    <script>
    document.getElementById('jobForm').addEventListener('submit', function(e) {
        const skillsInput = document.getElementById('skills');
        const skillsStr = skillsInput.value;

        // Split by comma, trim spaces, remove empty entries
        const skillsArray = skillsStr.split(',')
            .map(s => s.trim())
            .filter(s => s.length > 0);

        // Append hidden inputs for each skill
        skillsArray.forEach(skill => {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'skills[]';
            hiddenInput.value = skill;
            this.appendChild(hiddenInput);
        });

        // Remove the original input to avoid conflicts
        skillsInput.remove();
    });
    </script>

</x-layout>
