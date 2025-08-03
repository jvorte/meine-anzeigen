<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- !!! IMPORTANT: Add enctype="multipart/form-data" here !!! --}}
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- Profile Photo Section --}}
        {{-- You'll likely want to display the current photo and allow a new upload --}}
        <div>
            <x-input-label for="profile_photo" :value="__('Profile Photo')" />

            

            @if ($user->profile_photo_path)
                <div class="mt-2">
                    <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}'s profile photo"
                         class="rounded-full h-20 w-20 object-cover">
                </div>
            @else
                <div class="mt-2 text-gray-500 text-sm">
                    {{ __('No profile photo uploaded.') }}
                </div>
            @endif

            <input id="profile_photo"
                   name="profile_photo"
                   type="file"
                   class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                   accept="image/*" />
            <x-input-error :messages="$errors->get('profile_photo')" class="mt-2" />
            <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">
                {{ __('Accepted formats: JPG, PNG, GIF. Max size: 2MB.') }}
            </p>

            {{-- Optional: Add a button to remove the current photo if needed --}}
            @if ($user->profile_photo_path)
                <button type="button"
                        x-data="{}"
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-photo-deletion')"
                        class="mt-2 text-sm text-red-600 hover:text-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    {{ __('Remove Photo') }}
                </button>
            @endif
        </div>
        {{-- End Profile Photo Section --}}


        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="country" :value="__('Country')" />
            <x-text-input id="country" name="country" type="text" class="mt-1 block w-full" :value="old('country', $user->country)" autocomplete="country-name" />
            <x-input-error class="mt-2" :messages="$errors->get('country')" />
        </div>

        <div>
            <x-input-label for="city" :value="__('City')" />
            <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $user->city)" autocomplete="address-level2" />
            <x-input-error class="mt-2" :messages="$errors->get('city')" />
        </div>

        <div>
            <x-input-label for="postal_code" :value="__('Postal Code')" />
            <x-text-input id="postal_code" name="postal_code" type="text" class="mt-1 block w-full" :value="old('postal_code', $user->postal_code)" autocomplete="postal-code" />
            <x-input-error class="mt-2" :messages="$errors->get('postal_code')" />
        </div>

        <div>
            <x-input-label for="street_address" :value="__('Street Address')" />
            <x-text-input id="street_address" name="street_address" type="text" class="mt-1 block w-full" :value="old('street_address', $user->street_address)" autocomplete="street-address" />
            <x-input-error class="mt-2" :messages="$errors->get('street_address')" />
        </div>

        <div>
            <x-input-label for="mobile_phone" :value="__('Mobile Phone')" />
            <x-text-input id="mobile_phone" name="mobile_phone" type="text" class="mt-1 block w-full" :value="old('mobile_phone', $user->mobile_phone)" autocomplete="tel-national" />
            <x-input-error class="mt-2" :messages="$errors->get('mobile_phone')" />
        </div>

        <div>
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

{{-- Modal for photo deletion confirmation --}}
<x-modal name="confirm-photo-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route('profile.destroy-profile-photo') }}" class="p-6">
        @csrf
        @method('delete')

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Are you sure you want to delete your profile photo?') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once your profile photo is deleted, you will not be able to recover it. A default image will be used instead.') }}
        </p>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ms-3">
                {{ __('Delete Photo') }}
            </x-danger-button>
        </div>
    </form>
</x-modal>