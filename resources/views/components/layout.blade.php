<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex h-screen bg-gray-100 font-sans text-gray-800">

<aside class="w-64 bg-white shadow-lg hidden md:flex flex-col transition-all duration-300">
    <div class="p-4 flex flex-col items-center border-b border-gray-200">
        <img src="{{ asset('images/Group-654-1.svg') }}" alt="JobPortal Logo" class="h-10 w-auto mb-4">
    </div>

    <nav class="mt-6 flex-1 px-4 space-y-2">
        @if(auth()->user()->role === 'employer')
            <a href="{{ route('employer.dashboard') }}" 
               class="flex items-center px-4 py-2 rounded-lg transition
               {{ request()->routeIs('employer.dashboard') ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-blue-50 hover:text-blue-600' }}">
               <i data-feather="home" class="w-5 h-5 mr-3"></i>
               Dashboard
            </a>

            <a href="{{ route('jobs.list') }}" 
               class="flex items-center px-4 py-2 rounded-lg transition
               {{ request()->routeIs('jobs.list') ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-blue-50 hover:text-blue-600' }}">
               <i data-feather="briefcase" class="w-5 h-5 mr-3"></i>
               My Jobs
            </a>

            <a href="{{ route('applications.list') }}" 
               class="flex items-center px-4 py-2 rounded-lg transition
               {{ request()->routeIs('applications.list') ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-blue-50 hover:text-blue-600' }}">
               <i data-feather="file-text" class="w-5 h-5 mr-3"></i>
               Applications
            </a>

            <a href="{{ route('settings') }}" 
               class="flex items-center px-4 py-2 rounded-lg transition
               {{ request()->routeIs('settings') ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-blue-50 hover:text-blue-600' }}">
               <i data-feather="settings" class="w-5 h-5 mr-3"></i>
               Company Profile
            </a>

        @elseif(auth()->user()->role === 'jobseeker')
            <a href="{{ route('jobseeker.dashboard') }}" 
               class="flex items-center px-4 py-2 rounded-lg transition
               {{ request()->routeIs('jobseeker.dashboard') ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-blue-50 hover:text-blue-600' }}">
               <i data-feather="home" class="w-5 h-5 mr-3"></i>
               Dashboard
            </a>

            <a href="{{ route('jobs.find') }}" 
               class="flex items-center px-4 py-2 rounded-lg transition
               {{ request()->routeIs('jobs.find') ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-blue-50 hover:text-blue-600' }}">
               <i data-feather="search" class="w-5 h-5 mr-3"></i>
               Find Jobs
            </a>

            <a href="{{ route('my.applications') }}" 
               class="flex items-center px-4 py-2 rounded-lg transition
               {{ request()->routeIs('my.applications') ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-blue-50 hover:text-blue-600' }}">
               <i data-feather="file-text" class="w-5 h-5 mr-3"></i>
               My Applications
            </a>

            <a href="{{ route('settings') }}" 
               class="flex items-center px-4 py-2 rounded-lg transition
               {{ request()->routeIs('settings') ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-blue-50 hover:text-blue-600' }}">
               <i data-feather="user" class="w-5 h-5 mr-3"></i>
               Profile
            </a>
        @endif
    </nav>

    <div class="p-6 border-t border-gray-200">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full px-4 py-2 text-red-600 font-semibold rounded-lg hover:bg-red-50 transition flex items-center justify-center gap-2">
                <i data-feather="log-out" class="w-5 h-5"></i>
                Logout
            </button>
        </form>
    </div>
</aside>





    <!-- Main content -->
    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- Header -->
        <header class="bg-white shadow-md flex justify-between items-center px-6 py-4 border-b border-gray-200">
            <h1 class="font-bold text-2xl text-gray-700">{{ $title ?? 'Dashboard' }}</h1>
            <div class="flex items-center gap-4">
                <span class="text-gray-600 font-medium">Hello, {{ auth()->user()->name ?? 'User' }}</span>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-auto p-6 bg-gray-50">
            <div class="max-w-7xl mx-auto">
                {{ $slot }}
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white shadow-inner py-4 text-center text-gray-500 border-t border-gray-200">
            &copy; {{ date('Y') }} JobPortal. All rights reserved.
        </footer>
    </div>
<!-- Include Feather JS at the bottom of the page -->
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace(); // Replace all <i data-feather> with SVG icons
</script>
</body>
</html>
