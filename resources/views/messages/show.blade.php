<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-center justify-between space-y-2 sm:space-y-0">
            <h2 class="text-xl text-gray-800 leading-tight text-center sm:text-left">
                <a href="#" class="font-semibold hover:underline">{{ $conversation->ad_title ?? 'Χωρίς τίτλο' }}</a>
            </h2>
            @php
                $otherUser = auth()->id() === $conversation->sender_id
                    ? $conversation->receiver
                    : $conversation->sender;
            @endphp
            <h3 class="text-lg text-gray-600">
                Συνομιλία με <span class="font-semibold text-gray-800">{{ $otherUser->name }}</span>
            </h3>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8 flex flex-col h-[calc(100vh-10rem)]">
        {{-- Message Container --}}
        <div id="message-container" class="overflow-y-auto flex-grow border rounded-lg p-4 mb-4 bg-white shadow-lg space-y-4">
            @forelse($messages as $message)
                @php
                    $isSender = $message->user_id === auth()->id();
                @endphp
                <div class="flex items-start space-x-3 sm:space-x-4 {{ $isSender ? 'flex-row-reverse' : 'flex-row' }}">
                    {{-- Avatar --}}
                    <div class="flex-shrink-0">
                        <img 
                            src="{{ $message->user->profile_photo_url ?? asset('storage/profile_photos/default-avatar.png') }}"
                            alt="Profile Photo" 
                            class="w-10 h-10 rounded-full object-cover">
                    </div>
                    
                    {{-- Message Bubble --}}
                    <div class="flex-1 min-w-0">
                        <div class="inline-block px-4 py-2 rounded-xl max-w-full sm:max-w-md break-words 
                            {{ $isSender ? 'bg-indigo-600 text-white rounded-tr-none' : 'bg-gray-200 text-gray-800 rounded-tl-none' }}">
                            <p class="text-sm sm:text-base">{{ $message->body }}</p>
                        </div>
                        <small class="block text-xs mt-1 {{ $isSender ? 'text-right' : 'text-left' }} {{ $isSender ? 'text-gray-500' : 'text-gray-500' }}">
                            {{ $message->created_at->format('d/m/Y H:i') }}
                        </small>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center text-lg mt-10">Δεν υπάρχουν μηνύματα.</p>
            @endforelse
        </div>

        {{-- Message Input Form --}}
        <form action="{{ route('messages.store', $conversation) }}" method="POST" class="flex items-center space-x-3 p-4 bg-gray-100 rounded-lg shadow-inner">
            @csrf
            <input type="text" name="body" placeholder="Γράψε μήνυμα..." required
                class="flex-grow border-0 rounded-full px-5 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-600 transition duration-150 ease-in-out">
            <button type="submit"
                class="bg-indigo-600 text-white p-3 rounded-full hover:bg-indigo-700 transition duration-150 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
            </button>
        </form>
    </div>
</x-app-layout>