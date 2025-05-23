<x-guest-layout>

    <div class="columns-2 bg-primary">
        <div class="flex flex-col justify-center h-screen">
            <div class="grid grid-cols-1 gap-4 p-5">
                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <h1 style="font-size: 35px; font-weight: bold;">Log In</h1><br/>

                    <div>
                        <x-label for="username" value="{{ __('Username') }}" />
                        <x-input id="username" class="block mt-1 w-full" type="text" name="username"
                            :value="old('username')" required autofocus autocomplete="username" />
                            @error('username')
                                <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                            @enderror
                    </div>

                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Password') }}" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="current-password" />
                            @error('password')
                                <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                            @enderror
                    </div>

                    <div class="block mt-4">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" />
                            <span
                                class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                        </label>
                    </div>
                    <button type="submit"
                        class="my-5 w-full inline-flex items-center justify-center px-4 py-4 btn-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-50 transition ease-in-out duration-150">
                        {{ __('Login') }}
                    </button>
                    <div class="flex items-center justify-end mt-4">
                        @if(Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>
                    <a href="{{ url('/auth/google/redirect') }}" class="mt-4 w-full inline-flex items-center justify-center px-4 py-4 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-50 transition ease-in-out duration-150 gap-4">
                        <img src="{{ asset('images/google-logo2.png') }}" alt="Google logo" class="w-10 h-6 bg-transparent">
                        {{ __('Sign in with Google') }}
                    </a>
                </form>
                <div class="mt-4">
                    <hr class="border-gray-300 dark:border-gray-700" />
                    <div class="text-center mt-4">
                        <a href="{{ route('register') }}"
                            class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                            {{ __('Don\'t have an account? Register') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="h-screen flex hidden lg:block">
            <img class="h-screen w-screen object-cover"
                src="{{ asset('images/background/login-bg.png') }}" />
        </div>
    </div>

</x-guest-layout>
