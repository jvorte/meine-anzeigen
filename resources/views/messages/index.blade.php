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
                            <div>
                                <strong>{{ $otherUser->name }}</strong><br>
                                <small class="text-gray-600">
                                    {{ $lastMessage ? \Illuminate\Support\Str::limit($lastMessage->body, 50) : 'Χωρίς μηνύματα' }}
                                </small>
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
