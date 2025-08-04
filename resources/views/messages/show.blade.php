<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Συνομιλία με 
            @php
                $otherUser = auth()->id() === $conversation->sender_id
                    ? $conversation->receiver
                    : $conversation->sender;
            @endphp
            {{ $otherUser->name }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8 flex flex-col h-[600px]">

   <div class="overflow-y-auto flex-grow border rounded p-4 mb-4 bg-white shadow">
    @forelse($messages as $message)
        <div class="mb-4 flex {{ $message->user_id === auth()->id() ? 'justify-end' : 'justify-start' }} items-end space-x-2">
            @if ($message->user_id !== auth()->id())
                <img 
                    src="{{ $message->user->profile_photo_url ?? '/default-avatar.png' }}" 
                    alt="Profile Photo" 
                    class="w-12 h-12 rounded-full object-cover"
                />
            @else
                <div style="width:32px"></div> {{-- Αφήνω χώρο όταν το μήνυμα είναι δικό μας, για ομοιομορφία --}}
            @endif
            
            <div class="inline-block px-4 py-2 rounded 
                {{ $message->user_id === auth()->id() ? 'bg-indigo-500 text-white' : 'bg-gray-200 text-gray-800' }}">
                <p>{{ $message->body }}</p>
                <small class="block text-xs text-gray-600">{{ $message->created_at->format('d/m/Y H:i') }}</small>
            </div>
            
            @if ($message->user_id === auth()->id())
                <img 
                    src="{{ $message->user->profile_photo_url ?? '/default-avatar.png' }}" 
                    alt="Profile Photo" 
                    class="w-12 h-12 rounded-full object-cover"
                />
            @else
                <div style="width:32px"></div>
            @endif
        </div>
    @empty
        <p class="text-gray-500 text-center">Δεν υπάρχουν μηνύματα.</p>
    @endforelse
</div>


        <form action="{{ route('messages.store', $conversation) }}" method="POST" class="flex">
            @csrf
            <input type="text" name="body" placeholder="Γράψε μήνυμα..." required
                class="flex-grow border rounded-l px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-600">
            <button type="submit"
                class="bg-indigo-600 text-white px-6 py-2 rounded-r hover:bg-indigo-700 transition">Αποστολή</button>
        </form>

    </div>
</x-app-layout>
