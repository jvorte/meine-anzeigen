<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Οι Συνομιλίες μου</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @if($conversations->isEmpty())
            <p>Δεν έχετε καμία συνομιλία ακόμα.</p>
        @else
            <ul>
                @foreach($conversations as $conversation)
                    @php
                        $otherUser = auth()->id() === $conversation->sender_id
                            ? $conversation->receiver
                            : $conversation->sender;
                        $lastMessage = $conversation->messages->first();
                    @endphp
                 <li class="border-b py-2">
    <a href="{{ route('messages.show', $conversation) }}" class="flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <img src="{{ $otherUser->profile_photo_url ?? '/default-avatar.png' }}" alt="Profile Photo"
                class="w-10 h-10 rounded-full object-cover">
            <div>
                <strong>{{ $otherUser->name }}</strong><br>
                <small class="text-gray-600">
                    {{ $lastMessage ? \Illuminate\Support\Str::limit($lastMessage->body, 50) : 'Χωρίς μηνύματα' }}
                </small>
                <div class="text-sm text-gray-700 mt-1">
                    <span class="font-semibold">{{ $conversation->ad_title ?? 'Χωρίς τίτλο' }}</span>
                    <span class="ml-2 px-2 py-0.5 bg-gray-200 rounded text-xs uppercase">{{ $conversation->ad_category ?? '' }}</span>
                </div>

                <form action="{{ route('conversations.delete', $conversation->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit">Διαγραφή</button>
</form>
            </div>
        </div>

        <div class="text-gray-500 text-sm">
            {{ $conversation->updated_at->diffForHumans() }}
        </div>
    </a>
</li>

                @endforeach
            </ul>
        @endif
    </div>
</x-app-layout>