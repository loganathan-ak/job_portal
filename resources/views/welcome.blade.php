<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobPortal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('welcome') }}" class="text-2xl font-bold text-blue-600"><img src="{{asset('images/Group-654-1.svg')}}" /> </a>
            <div class="space-x-6 hidden md:flex">
                <a href="#features" class="hover:text-blue-600 transition">Features</a>
                <a href="#about" class="hover:text-blue-600 transition">About</a>
                <a href="#contact" class="hover:text-blue-600 transition">Contact</a>
                <a href="{{ route('login') }}" class="px-4 py-2 border border-blue-600 text-blue-600 rounded hover:bg-blue-50 transition">Login</a>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Register</a>
            </div>
            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button id="mobile-menu-btn" class="focus:outline-none">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden px-4 pb-4 space-y-2">
            <a href="#features" class="block hover:text-blue-600 transition">Features</a>
            <a href="#about" class="block hover:text-blue-600 transition">About</a>
            <a href="#contact" class="block hover:text-blue-600 transition">Contact</a>
            <a href="{{ route('login') }}" class="block px-4 py-2 border border-blue-600 text-blue-600 rounded hover:bg-blue-50 transition">Login</a>
            <a href="{{ route('register') }}" class="block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Register</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="bg-gradient-to-r from-blue-600 to-blue-500 text-white py-28">
        <div class="container mx-auto text-center px-4">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Connecting Talent with Opportunity</h1>
            <p class="text-lg md:text-xl mb-8">Find your dream job or hire the best candidates effortlessly.</p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('register') }}" class="px-6 py-3 bg-white text-blue-600 font-semibold rounded shadow hover:bg-gray-100 transition">Get Started</a>
                <a href="#features" class="px-6 py-3 border border-white text-white rounded hover:bg-white hover:text-blue-600 transition">Learn More</a>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-12">Why Choose JobPortal?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-lg shadow hover:shadow-lg transition">
                    <h3 class="text-xl font-semibold mb-4">For Job Seekers</h3>
                    <p>Discover the latest job opportunities, apply with ease, and track your applications seamlessly.</p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow hover:shadow-lg transition">
                    <h3 class="text-xl font-semibold mb-4">For Employers</h3>
                    <p>Post jobs, review applications, and hire top talent efficiently with our intuitive platform.</p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow hover:shadow-lg transition">
                    <h3 class="text-xl font-semibold mb-4">Smart Matching</h3>
                    <p>Our AI-powered system recommends the best jobs to candidates and top candidates to employers.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">About JobPortal</h2>
            <p class="max-w-2xl mx-auto text-gray-600">JobPortal is dedicated to connecting job seekers with the right employers. Whether you are searching for your dream job or looking to hire the best talent, we provide a modern platform to make recruitment efficient and hassle-free.</p>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="bg-blue-600 text-white py-16 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Start Your Journey Today</h2>
        <p class="mb-6">Sign up now to explore opportunities or find top talent for your business.</p>
        <a href="{{ route('register') }}" class="px-6 py-3 bg-white text-blue-600 font-semibold rounded hover:bg-gray-100 transition">Get Started</a>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-100 text-gray-700 py-8 text-center">
        <p>&copy; {{ date('Y') }} JobPortal. All rights reserved.</p>
    </footer>

    <script>
        // Mobile menu toggle
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>

</body>
</html>
