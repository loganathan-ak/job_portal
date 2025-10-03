<x-auth-layout 
    title="Login" 
    subtitle="Enter your credentials to access your account"
    :illustrationTitle="'Welcome Back'"
    :illustrationSubtitle="'Login to continue your journey with JobPortal.'">

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div class="grid grid-cols-1 gap-4">
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required
                   class="w-full px-4 py-3 rounded-xl border @error('email') border-red-500 @else border-gray-300 @enderror focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
            @error('email')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror

            <input type="password" name="password" placeholder="Password" required
                   class="w-full px-4 py-3 rounded-xl border @error('password') border-red-500 @else border-gray-300 @enderror focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
            @error('password')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Optional Forgot Password Link --}}
        {{-- <div class="text-right text-sm">
            <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline font-medium">Forgot Password?</a>
        </div> --}}

        <button type="submit"
                class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-xl font-semibold hover:opacity-90 transition shadow-lg">
            Login
        </button>

        <p class="text-center text-gray-500 text-sm mt-2">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-medium">Register</a>
        </p>
    </form>
</x-auth-layout>
