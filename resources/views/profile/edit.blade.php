<x-app-layout>
    <x-slot name="header">
           <h2 class="text-3xl md:text-3xl font-extrabold text-gray-900 dark:text-gray-800">  {{ __('my_profile') }}</h2>
        <p>  {{ __('update_profile_intro') }}</p>
    </x-slot>

   <div class="min-h-screen flex items-center justify-center py-12 bg-gray-50 dark:bg-gray-100">
    <div class="max-w-5xl w-full sm:px-6 lg:px-8 space-y-6">
   
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl mx-auto">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl mx-auto">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl mx-auto">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>

</x-app-layout>