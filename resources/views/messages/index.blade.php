<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl md:text-3xl font-extrabold text-gray-900 dark:text-gray-800">{{ __('my_messages') }}</h2>
        <p>{{ __('intro_text') }}</p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if($conversations->isEmpty())
                    <div class="p-6 text-gray-900">
                        <p>{{ __('no_conversations') }}</p>
                    </div>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach($conversations as $conversation)
                            @php
                                $otherUser = auth()->id() === $conversation->sender_id ? $conversation->receiver : $conversation->sender;
                                $lastMessage = $conversation->lastMessage;
                            @endphp
                            
                            <li class="p-4 hover:bg-gray-50 transition duration-150 ease-in-out">
                                <div class="flex items-start justify-between">
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
                                            
                                            <p class="text-sm text-gray-700 mt-1 truncate">
                                                <span class="font-medium">{{ $conversation->ad_title ?? __('no_title') }}</span>
                                                <span class="text-gray-500 ml-1">· {{ $lastMessage ? \Illuminate\Support\Str::limit($lastMessage->body, 50) : __('no_messages') }}</span>
                                            </p>
                                        </div>
                                    </a>

                                    <div class="flex-shrink-0 ml-4 self-center">
                                        <form action="{{ route('conversations.delete', $conversation->id) }}" method="POST" onsubmit="return confirm('{{ __('confirm_delete') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium">
                                                {{ __('delete') }}
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
