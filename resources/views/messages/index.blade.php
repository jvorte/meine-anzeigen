<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Οι Συνομιλίες μου
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if($conversations->isEmpty())
                    <div class="p-6 text-gray-900">
                        <p>Δεν έχετε καμία συνομιλία ακόμα.</p>
                    </div>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach($conversations as $conversation)
                            @php
                                $otherUser = auth()->id() === $conversation->sender_id ? $conversation->receiver : $conversation->sender;
                                $lastMessage = $conversation->lastMessage; // Assuming you've eager loaded this.
                            @endphp
                            
                            <li class="p-4 hover:bg-gray-50 transition duration-150 ease-in-out">
                                <div class="flex items-start justify-between">
                                    {{-- Main clickable area --}}
                                    <a href="{{ route('messages.show', $conversation) }}" class="flex-1 flex space-x-4 min-w-0">
                                        <img src="{{ $otherUser->profile_photo_url ?? asset('storage/profile_photos/default-avatar.png') }}" 
                                             alt="{{ $otherUser->name }}"
                                             class="w-12 h-12 rounded-full object-cover flex-shrink-0">
                                        
                                        <div class="min-w-0 flex-1">
                                            <div class="flex items-center justify-between">
                                                <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $otherUser->name }}</h3>
                                                <div class="text-sm text-gray-500 flex-shrink-0 ml-4">
                                                    {{ $conversation->updated_at->diffForHumans() }}
                                                </div>
                                            </div>
                                            
                                            {{-- Conversation topic and last message preview --}}
                                            <p class="text-sm text-gray-700 mt-1 truncate">
                                                <span class="font-medium">{{ $conversation->ad_title ?? 'Χωρίς τίτλο' }}</span>
                                                <span class="text-gray-500 ml-1">· {{ $lastMessage ? \Illuminate\Support\Str::limit($lastMessage->body, 50) : 'Χωρίς μηνύματα' }}</span>
                                            </p>
                                        </div>
                                    </a>

                                    {{-- Delete button - now a separate form element --}}
                                    <div class="flex-shrink-0 ml-4 self-center">
                                        <form action="{{ route('conversations.delete', $conversation->id) }}" method="POST" onsubmit="return confirm('Είστε σίγουρος ότι θέλετε να διαγράψετε αυτή τη συνομιλία;');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium">
                                                Διαγραφή
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>