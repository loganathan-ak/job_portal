<x-auth-layout 
    title="Join JobPortal" 
    subtitle="Create your account and start your career journey"
    :illustrationTitle="'Grow Your Career'"
    :illustrationSubtitle="'Find the right job or hire the best talent with JobPortal.'">

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-5 ">
        @csrf

        <div class="grid grid-cols-1 gap-4">
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Full Name" required
                   class="w-full px-4 py-3 rounded-xl border @error('name') border-red-500 @else border-gray-300 @enderror focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
            @error('name')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror

            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required
                   class="w-full px-4 py-3 rounded-xl border @error('email') border-red-500 @else border-gray-300 @enderror focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
            @error('email')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror

            <select name="role" id="role" required onchange="toggleRoleFields()"
                    class="w-full px-4 py-3 rounded-xl border @error('role') border-red-500 @else border-gray-300 @enderror focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
                <option value="jobseeker" {{ old('role')=='jobseeker' ? 'selected' : '' }}>Job Seeker</option>
                <option value="employer" {{ old('role')=='employer' ? 'selected' : '' }}>Employer</option>
            </select>
            @error('role')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Job Seeker Fields -->
        <div id="jobseeker-fields" class="space-y-4 mt-4">
            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone Number"
                   class="w-full px-4 py-3 rounded-xl border @error('phone') border-red-500 @else border-gray-300 @enderror focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
            @error('phone')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror

            <input type="file" name="resume" accept=".pdf,.doc,.docx"
                   class="w-full text-gray-700 p-2 border @error('resume') border-red-500 @else border-gray-300 @enderror rounded-xl">
            @error('resume')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror

            <input type="number" name="experience" min="0" value="{{ old('experience') }}" placeholder="Experience (Years)"
                   class="w-full px-4 py-3 rounded-xl border @error('experience') border-red-500 @else border-gray-300 @enderror focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
            @error('experience')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror

            <input type="text" name="skills" value="{{ old('skills') }}" placeholder="Skills (e.g., PHP, Laravel, Tailwind)"
                   class="w-full px-4 py-3 rounded-xl border @error('skills') border-red-500 @else border-gray-300 @enderror focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
            @error('skills')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Employer Fields -->
        <div id="employer-fields" class="space-y-4 mt-4 hidden">
            <input type="text" name="company_name" value="{{ old('company_name') }}" placeholder="Company Name"
                   class="w-full px-4 py-3 rounded-xl border @error('company_name') border-red-500 @else border-gray-300 @enderror focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
            @error('company_name')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror

            <input type="url" name="company_website" value="{{ old('company_website') }}" placeholder="Company Website"
                   class="w-full px-4 py-3 rounded-xl border @error('company_website') border-red-500 @else border-gray-300 @enderror focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
            @error('company_website')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror

            <input type="text" name="contact_number" value="{{ old('contact_number') }}" placeholder="Contact Number"
                   class="w-full px-4 py-3 rounded-xl border @error('contact_number') border-red-500 @else border-gray-300 @enderror focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
            @error('contact_number')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror

            <input type="file" name="company_logo" accept="image/*"
                   class="w-full text-gray-700 p-2 border @error('company_logo') border-red-500 @else border-gray-300 @enderror rounded-xl">
            @error('company_logo')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror

            <textarea name="company_description" rows="3" placeholder="Company Description"
                      class="w-full px-4 py-3 rounded-xl border @error('company_description') border-red-500 @else border-gray-300 @enderror focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">{{ old('company_description') }}</textarea>
            @error('company_description')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 gap-4">
            <input type="password" name="password" placeholder="Password" required
                   class="w-full px-4 py-3 rounded-xl border @error('password') border-red-500 @else border-gray-300 @enderror focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
            @error('password')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror

            <input type="password" name="password_confirmation" placeholder="Confirm Password" required
                   class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
        </div>

        <button type="submit"
                class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-xl font-semibold hover:opacity-90 transition shadow-lg">
            Register
        </button>

        <p class="text-center text-gray-500 text-sm mt-2">
            Already have an account?
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-medium">Login</a>
        </p>
    </form>

    <script>
        function toggleRoleFields() {
            const role = document.getElementById('role').value;
            document.getElementById('jobseeker-fields').classList.toggle('hidden', role !== 'jobseeker');
            document.getElementById('employer-fields').classList.toggle('hidden', role !== 'employer');
        }
        toggleRoleFields();
    </script>
</x-auth-layout>
