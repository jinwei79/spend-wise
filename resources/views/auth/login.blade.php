<x-guest-layout>
    <div class="columns-2 bg-primary h-screen">
        <!-- Left Section -->
        <div class="flex flex-col justify-center items-center h-full px-6">
            <div class="w-full max-w-md text-center">
                <h1 class="text-4xl font-bold text-black mb-6">Welcome Back</h1>
                <p class="text-black-200 mb-10">Sign in securely with your Google account</p>

                <!-- Google Sign-In Button -->
                <a href="{{ url('/auth/google/redirect') }}"
                    class="flex items-center justify-center w-full gap-3 py-3 px-6 rounded-lg bg-white text-gray-700 font-semibold text-base shadow-md hover:bg-gray-100 transition duration-150">
                    <img src="{{ asset('images/google-logo2.png') }}" alt="Google logo" class="w-6 h-6">
                    <span>Sign in with Google</span>
                </a>
            </div>
        </div>

        <!-- Right Section (Fixed Image) -->
        <div class="h-full hidden lg:block">
            <img src="{{ asset('images/background/login-bg.png') }}" alt="Login Background"
                class="h-full w-screen object-cover" />
        </div>
    </div>
</x-guest-layout>
