<x-app-layout>
    <div class="flex flex-col w-3/4 mx-auto my-5">
        <!-- Success Message -->
        @if (session()->has('message'))
            <div class="mt-4">
                <input type="text" value="{{ 'Your profile has been updated successfully' }}" readonly class="bg-green-100 text-green-500 p-2 border border-green-300 rounded-md w-full" />
            </div>
        @endif
    </div>
    <x-slot name="form">
        <!-- Centered Form Wrapper -->
        <div class="flex flex-col w-3/4 mx-auto my-5">
            <!-- Form Content Wrapper -->
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="w-full p-5 w-3/4 mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md">
                    <h2 style="font-size: 30px; font-weight: bold;">Profile</h2><br/>
                    <!-- Container for Profile Photo and Salary Side-by-Side -->
                    <div class="flex flex-wrap gap-6">
                        <!-- Profile Photo -->
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <div x-data="{photoName: null, photoPreview: null}" class="flex-1 min-w-[250px] border-r border-gray-300 pl-6 ml-6">
                                <x-label for="photo" value="{{ __('Photo') }}" />

                                <!-- Profile Photo File Input -->
                                <input type="file" id="photo" name="photo" class="hidden"
                                    wire:model.live="photo"
                                    x-ref="photo"
                                    x-on:change="
                                        photoName = $refs.photo.files[0].name;
                                        const reader = new FileReader();
                                        reader.onload = (e) => {
                                            photoPreview = e.target.result;
                                        };
                                        reader.readAsDataURL($refs.photo.files[0]);
                                    " />

                                <!-- Preview and Buttons Side-by-Side -->
                                <div class="mt-2 flex items-center space-x-4">
                                    <!-- Current Profile Photo -->
                                    <template x-if="!photoPreview">
                                        <img src="{{ $user->profile_photo_path
                                            ? (Str::startsWith($user->profile_photo_path, 'http')
                                                ? $user->profile_photo_path
                                                : asset('storage/' . $user->profile_photo_path))
                                            : $user->profile_photo_url }}"
                                            alt="{{ $user->name }}"
                                            class="rounded-full size-20 object-cover">
                                    </template>

                                    <!-- New Profile Photo Preview -->
                                    <template x-if="photoPreview">
                                        <span class="block rounded-full size-20 bg-cover bg-no-repeat bg-center"
                                            x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                                        </span>
                                    </template>

                                    <!-- Buttons next to photo -->
                                    <div class="flex flex-col gap-2">
                                        <x-secondary-button type="button" x-on:click.prevent="$refs.photo.click()">
                                            {{ __('Upload Photo') }}
                                        </x-secondary-button>
                                    </div>
                                </div>

                                <x-input-error for="photo" class="mt-2" />
                            </div>
                        @endif

                        <!-- Salary -->
                        <div class="flex-1 min-w-[250px] pl-6">
                            <x-label for="salary" value="{{ __('Salary') }}" />
                            <x-input id="salary" type="text" class="mt-1 block w-full" name="salary" value="{{ old('salary', $user->salary) }}" />
                            <x-input-error for="salary" class="mt-2" />
                        </div>
                    </div>
                    <x-section-border />

                    <!-- Name -->
                    <div class="flex space-x-4">
                        <!-- First Name -->
                        <div class="mt-4 flex-1">
                            <x-label for="firstname" value="{{ __('First Name') }}" />
                            <x-input id="firstname" type="text" class="mt-1 block w-full" name="first_name" value="{{ old('first_name', $user->first_name) }}" required />
                            <x-input-error for="first_name" class="mt-2" />
                        </div>

                        <!-- Last Name -->
                        <div class="mt-4 flex-1">
                            <x-label for="lastname" value="{{ __('Last Name') }}" />
                            <x-input id="lastname" type="text" class="mt-1 block w-full" name="last_name" value="{{ old('last_name', $user->last_name) }}" required />
                            <x-input-error for="last_name" class="mt-2" />
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mt-4">
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" type="email" class="mt-1 block w-full" name="email" value="{{ old('email', $user->email) }}" required />
                        <x-input-error for="email" class="mt-2" />
                    </div>

                    <!-- Username -->
                    <div class="mt-4">
                            <x-label for="username" value="{{ __('Username') }}" />
                            <x-input id="username" type="text" class="mt-1 block w-full" name="username" value="{{ old('username', $user->username) }}" required />
                            <x-input-error for="username" class="mt-2" />
                        </div>

                    <!-- Birthday -->
                    <div class="mt-4">
                        <x-label for="birthday" value="{{ __('Birthday') }}" />
                        <x-input id="birthday" type="date" class="mt-1 block w-full" name="birthday" value="{{ old('birthday', $user->birthday) }}" required />
                        <x-input-error for="birthday" class="mt-2" />
                    </div>
                    <x-section-border />

                    <button type="submit"
                        class="my-5 w-full inline-flex items-center justify-center px-4 py-4 btn-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-50 transition ease-in-out duration-150">
                        {{ __('Save Changes') }}
                    </button>
                </div>
            </form>
        </div>
    </x-slot>
</x-app-layout>