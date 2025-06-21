<div x-data="{ isOpen: @entangle('isOpen') }" class="fixed bottom-4 right-4 z-50">

    <!-- Toggle Button -->
    <button @click="isOpen = !isOpen"
            class="bg-blue-600 text-white p-3 rounded-full shadow-lg focus:outline-none">
        <template x-if="isOpen">
            <span>✖</span>
        </template>
        <template x-if="!isOpen">
            <span>💬</span>
        </template>
    </button>

    <!-- Chat Window -->
    <div x-show="isOpen" x-transition
         class="fixed bottom-20 right-4 w-96 bg-white shadow-xl rounded-xl border z-40 transition-all"
         style="display: none;">
        <div class="bg-blue-600 text-white px-4 py-2 rounded-t-xl font-semibold">
            Maya
        </div>

        <div class="p-4 h-80 overflow-y-auto space-y-2" id="chat-messages">
            @foreach($messages as $message)
                @if($message['role'] !== 'system')
                    <div class="@if($message['role'] === 'user') text-right @endif">
                        <div class="inline-block px-4 py-2 rounded-lg
                            @if($message['role'] === 'user') bg-blue-500 text-white
                            @else bg-gray-200
                            @endif">
                            {!! $message['content'] !!}
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="flex justify-end px-4 pb-2">
            <button wire:click="clearChat"
                    class="ml-auto text-xs bg-red-100 text-red-600 hover:bg-red-200 px-3 py-1 rounded-full transition duration-200">
                🗑️ Clear Chat
            </button>
        </div>

        <form wire:submit.prevent="sendMessage" class="flex p-2 border-t">
            <input wire:model.defer="input" type="text" placeholder="Ask something..."
                class="flex-grow px-4 py-2 border rounded-l-full focus:outline-none focus:ring" autocomplete="off">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r-full">
                ▶
            </button>
        </form>
    </div>
</div>
