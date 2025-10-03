<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Login/Register' }} - JobPortal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-r from-blue-50 to-indigo-50 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden md:flex border border-gray-100">

        <!-- Left Illustration (optional for larger screens) -->
        <div class="hidden md:flex md:w-1/2 bg-gradient-to-br from-blue-600 to-indigo-600 text-white flex-col justify-center items-center p-10">
            <img src="{{ asset('images/white-logo-2.png') }}" alt="JobPortal Logo" class="h-12 w-auto mb-8">
            <h2 class="text-4xl font-bold mb-4">{{ $illustrationTitle ?? 'Welcome to JobPortal' }}</h2>
            <p class="text-lg leading-relaxed text-center max-w-sm">{{ $illustrationSubtitle ?? 'Connecting job seekers and employers efficiently.' }}</p>
        </div>

        <!-- Right Slot for Forms -->
        <div class="w-full md:w-1/2 p-8 sm:p-10 m-5">
            <!-- Title & Subtitle -->
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold text-gray-900">{{ $title ?? 'Welcome' }}</h1>
                <p class="text-gray-500 mt-2">{{ $subtitle ?? '' }}</p>
            </div>

            {{ $slot }}

            <!-- Footer -->
            <div class="mt-6 text-center text-gray-400 text-sm">
                &copy; {{ date('Y') }} JobPortal. All rights reserved.
            </div>
        </div>
    </div>

</body>
</html>
