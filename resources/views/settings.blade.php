<x-layout title="Settings">

    <div class="bg-white shadow rounded-xl p-6 max-w-3xl mx-auto">
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
        <h2 class="text-2xl font-semibold mb-6">Account Settings</h2>

        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Common Fields --}}
            <div>
                <label for="name" class="block text-gray-700 font-medium mb-1">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}"
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}"
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-gray-700 font-medium mb-1">New Password</label>
                <input type="password" name="password" id="password"
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-gray-700 font-medium mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
            </div>

            {{-- Employer-specific Fields --}}
            @if(auth()->user()->role === 'employer')
                <div>
                    <label for="company_name" class="block text-gray-700 font-medium mb-1">Company Name</label>
                    <input type="text" name="company_name" id="company_name" 
                           value="{{ old('company_name', auth()->user()->employer->company_name ?? '') }}"
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
                </div>

                <div>
                    <label for="company_website" class="block text-gray-700 font-medium mb-1">Company Website</label>
                    <input type="url" name="company_website" id="company_website" 
                           value="{{ old('company_website', auth()->user()->employer->company_website ?? '') }}"
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
                </div>

                <div>
    <label for="company_logo" class="block text-gray-700 font-medium mb-1">Company Logo</label>
    
    <input type="file" name="company_logo" id="company_logo" accept="image/*"
           class="w-full text-gray-700 p-2 border rounded-xl border-gray-300">

    @if(auth()->user()->employer && auth()->user()->employer->company_logo)
        @php
            $logoPath = asset('storage/' . auth()->user()->employer->company_logo);
        @endphp
        <div class="mt-2 w-24 h-24 border rounded-lg overflow-hidden bg-gray-50 flex items-center justify-center">
            <a href="{{ $logoPath }}" target="_blank">
                <img src="{{ $logoPath }}" alt="Company Logo" class="object-cover w-full h-full">
            </a>
        </div>
    @endif
</div>


                <div>
                    <label for="company_description" class="block text-gray-700 font-medium mb-1">Company Description</label>
                    <textarea name="company_description" id="company_description" rows="3"
                              class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">{{ old('company_description', auth()->user()->employer->company_description ?? '') }}</textarea>
                </div>
            @endif

            {{-- Job Seeker-specific Fields --}}
            @if(auth()->user()->role === 'jobseeker')
                <div>
                    <label for="phone" class="block text-gray-700 font-medium mb-1">Phone Number</label>
                    <input type="text" name="phone" id="phone" 
                           value="{{ old('phone', auth()->user()->jobseeker->phone ?? '') }}"
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
                </div>

                {{-- Resume --}}
{{-- Resume --}}
<div>
    <label for="resume" class="block text-gray-700 font-medium mb-1">Resume</label>
    <input type="file" name="resume" id="resume" accept=".pdf,.doc,.docx"
           class="w-full text-gray-700 p-2 border rounded-xl border-gray-300">

    @if(auth()->user()->jobseeker && auth()->user()->jobseeker->resume)
        @php
            $resumePath = asset('storage/' . auth()->user()->jobseeker->resume);
            $extension = pathinfo(auth()->user()->jobseeker->resume, PATHINFO_EXTENSION);
        @endphp

        <div class="mt-2 flex flex-col items-center space-y-1 p-2 border rounded-lg bg-gray-50 w-fit">
            @if(in_array($extension, ['pdf', 'doc', 'docx']))
                <a href="{{ $resumePath }}" target="_blank" class="flex flex-col items-center text-gray-800 hover:underline">
                    <span class="w-12 h-12 bg-gray-200 text-gray-700 font-bold flex items-center justify-center rounded-md">
                        FILE
                    </span>
                    <span class="text-sm mt-1">Current File</span>
                </a>
            @endif
        </div>

    @endif
</div>



                <div>
                    <label for="experience" class="block text-gray-700 font-medium mb-1">Experience (Years)</label>
                    <input type="number" name="experience" id="experience" min="0" 
                           value="{{ old('experience', auth()->user()->jobseeker->experience ?? '') }}"
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
                </div>

                <div>
                    <label for="skills" class="block text-gray-700 font-medium mb-1">Skills</label>
                    <input type="text" name="skills" id="skills" 
                           value="{{ old('skills', auth()->user()->jobseeker->skills ?? '') }}"
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
                </div>
            @endif

            <button type="submit"
                    class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 px-6 rounded-xl font-semibold hover:opacity-90 transition shadow-lg">
                Update Settings
            </button>
        </form>
    </div>

</x-layout>
