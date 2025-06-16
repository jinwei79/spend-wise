<x-guest-layout>

    <div class="columns-2 bg-primary">
        <div class="flex flex-col justify-center h-screen">
            <div class="grid grid-cols-1 gap-4 p-5">
                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <h1 style="font-size: 35px; font-weight: bold;">Sign Up</h1><br/>

                    <div class="flex space-x-4 bg-primary">
                        <div class="mt-4 flex-1">
                            <x-label for="first_name" value="{{ __('First Name') }}" />
                            <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="first_name" />
                        </div>
                        <div class="mt-4 flex-1">
                            <x-label for="last_name" value="{{ __('Last Name') }}" />
                            <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autocomplete="last_name" />
                        </div>
                    </div>
                    <div class="mt-4">
                        <x-label for="username" value="{{ __('Username') }}" />
                        <x-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autocomplete="username" />
                    </div>

                    <div class="mt-4">
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    </div>

                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Password') }}" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                        <p class="text-sm text-gray-500 mt-1">
                            {{ __('It must be a combination of minimum 8 letters, numbers and symbols') }}
                        </p>
                    </div>

                    <!-- <div class="mt-4">
                        <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                        <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    </div> -->

                    <div class="mt-4">
                        <x-label for="birthday" value="{{ __('Birthday') }}" />
                        <x-input id="birthday" class="block mt-1 w-full" type="date" name="birthday" :value="old('birthday')" required autocomplete="birthday" />
                    </div>

                    <button type="submit"
                        class="my-5 w-full inline-flex items-center justify-center px-4 py-4 btn-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-50 transition ease-in-out duration-150">
                        {{ __('Create Account') }}
                    </button>
                </form>
                <div class="mt-4">
                    <hr class="border-gray-300 dark:border-gray-700" />
                    <div class="text-center mt-4">
                        <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <div class="h-screen flex hidden lg:block">
            <img class="h-screen w-screen object-cover"
                src="{{ asset('images/background/register-bg.png') }}" />
        </div>
    </div>

</x-guest-layout>
