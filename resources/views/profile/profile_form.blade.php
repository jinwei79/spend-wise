<div class="flex flex-col w-3/4 mx-auto my-5">
    @if (session('message'))
        <div class="mt-4">
            <input type="text" value="{{ session('message') }}" readonly class="bg-green-100 text-green-500 p-2 border border-green-300 rounded-md w-full" />
        </div>
    @endif

    <div class="w-full p-5 w-3/4 mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <h2 class="text-[30px] font-bold">Profile</h2><br/>
        <form method="POST" action="{{ route('profile.save') }}" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-wrap gap-6">
                <!-- Profile Photo -->
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div x-data="{ photoPreview: null }" class="flex-1 min-w-[250px] border-r border-gray-300 pl-6 ml-6">
                        <x-label for="photo" value="{{ __('Photo') }}" />

                        <input type="file" id="photo" name="photo" class="hidden"
                            wire:model="photo"
                            x-ref="photo"
                            x-on:change="
                                const file = $refs.photo.files[0];
                                const reader = new FileReader();
                                reader.onload = (e) => { photoPreview = e.target.result; };
                                reader.readAsDataURL(file);
                            " />

                        <div class="mt-2 flex items-center space-x-4">
                            <template x-if="!photoPreview">
                                <img src="{{ $this->profilePhotoUrl }}" alt="{{ $this->name }}" class="rounded-full size-20 object-cover">
                            </template>

                            <template x-if="photoPreview">
                                <span class="block rounded-full size-20 bg-cover bg-no-repeat bg-center"
                                    x-bind:style="'background-image: url(' + photoPreview + ')'">
                                </span>
                            </template>

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
                    <x-input id="salary" type="text" name="salary" class="mt-1 block w-full" value="{{ old('salary', $salary) }}"/>
                    <x-input-error for="salary" class="mt-2" />
                </div>
            </div>

            <x-section-border />

            <div class="flex space-x-4">
                <div class="mt-4 flex-1">
                    <x-label for="firstname" value="{{ __('First Name') }}" />
                    <x-input id="firstname" type="text" name="first_name" class="mt-1 block w-full" value="{{ old('first_name', $first_name) }}" required />
                    <x-input-error for="first_name" class="mt-2" />
                </div>

                <div class="mt-4 flex-1">
                    <x-label for="lastname" value="{{ __('Last Name') }}" />
                    <x-input id="lastname" type="text" name="last_name" class="mt-1 block w-full" value="{{ old('last_name', $last_name) }}" required />
                    <x-input-error for="last_name" class="mt-2" />
                </div>
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" type="email" name="email" class="mt-1 block w-full" value="{{ old('email', $email) }}" required />
                <x-input-error for="email" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-label for="username" value="{{ __('Username') }}" />
                <x-input id="username" type="text" name="username" class="mt-1 block w-full" value="{{ old('username', $username) }}" required />
                <x-input-error for="username" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-label for="birthday" value="{{ __('Birthday') }}" />
                <x-input id="birthday" type="date" name="birthday" class="mt-1 block w-full" value="{{ old('birthday', $birthday) }}" required />
                <x-input-error for="birthday" class="mt-2" />
            </div>

            <x-section-border />

            <button type= "submit" class="my-5 w-full inline-flex items-center justify-center px-4 py-4 btn-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-50 transition ease-in-out duration-150">
                {{ __('Save Changes') }}
            </button>
        </form>
    </div>
</div>
