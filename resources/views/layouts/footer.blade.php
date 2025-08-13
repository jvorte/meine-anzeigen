<!-- resources/views/layouts/partials/footer.blade.php -->

<footer class="bg-gray-900 text-gray-300 py-12 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 border-b border-gray-700 pb-8 mb-8">

            <!-- Column 1: Company Info -->
            <div class="col-span-1 md:col-span-1">
                <h3 class="text-xl font-bold text-white mb-4">My Ads</h3>
                 <p class="text-sm leading-relaxed">{{ __('footer.text_ad') }}</p>
            </div>



          <!-- Column 2: Categories -->
<div class="col-span-1 md:col-span-1">
    <h3 class="text-xl font-bold text-white mb-4">{{ __('footer.categories') }}</h3>
    <ul class="space-y-2">
        <li><a href="{{ route('categories.cars.index') }}" class="text-sm hover:text-blue-400 transition-colors">{{ __('footer.cars') }}</a></li>
        <li><a href="{{ route('categories.real-estate.index') }}" class="text-sm hover:text-blue-400 transition-colors">{{ __('footer.real_estate') }}</a></li>
        <li><a href="{{ route('categories.electronics.index') }}" class="text-sm hover:text-blue-400 transition-colors">{{ __('footer.electronic') }}</a></li>
        <li><a href="{{ route('categories.household.index') }}" class="text-sm hover:text-blue-400 transition-colors">{{ __('footer.household') }}</a></li>
        <li><a href="{{ route('categories.services.index') }}" class="text-sm hover:text-blue-400 transition-colors">{{ __('footer.services') }}</a></li>
        <li><a href="{{ route('categories.others.index') }}" class="text-sm hover:text-blue-400 transition-colors">{{ __('footer.others') }}</a></li>
    </ul>
</div>




         <!-- Column 3: Quick Links / Legal -->
<div class="col-span-1 md:col-span-1">
    <h3 class="text-xl font-bold text-white mb-4">{{ __('footer.legal') }}</h3>
    <ul class="space-y-2">
        <li><a href="{{ route('legal.data-protection') }}" class="text-sm hover:text-blue-400 transition-colors">{{ __('footer.privacy_policy') }}</a></li>
        <li><a href="{{ route('legal.terms-conditions') }}" class="text-sm hover:text-blue-400 transition-colors">{{ __('footer.terms_and_conditions') }}</a></li>
        <li><a href="{{ route('contact') }}" class="text-sm hover:text-blue-400 transition-colors">{{ __('footer.contact') }}</a></li>
    </ul>
</div>
         


<!-- Column 4: Newsletter Signup -->
<div class="col-span-1 md:col-span-1">
    <h3 class="text-xl font-bold text-white mb-4">{{ __('footer.newsletter') }}</h3>
    <p class="text-sm mb-4">{{ __('footer.newsletter_description') }}</p>
    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex flex-col sm:flex-row gap-2">
        @csrf
        <input type="email" name="email" placeholder="{{ __('footer.email_placeholder') }}" required
            class="flex-grow p-2 rounded-md bg-gray-800 border border-gray-700 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500">
        <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition-colors">
            {{ __('footer.subscribe_button') }}
        </button>
    </form>
</div>

        </div>

  <!-- Bottom Bar -->
<div class="flex flex-col sm:flex-row justify-between items-center text-center sm:text-left text-sm text-gray-400">
    <div class="mb-2 sm:mb-0">
        {!! __('footer.copyright') !!}
    </div>
    <div class="flex items-center gap-2">
        <span class="mr-2">{{ __('footer.language') }}</span>
        <select class="bg-gray-800 border border-gray-700 text-white rounded-md p-1 text-sm focus:outline-none focus:border-blue-500">
            <option value="de">{{ __('footer.german_option') }}</option>
            <option value="en">{{ __('footer.english_option') }}</option>
        </select>
    </div>
</div>

        
    </div>
</footer>