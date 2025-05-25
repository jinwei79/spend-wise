<div>
    @if ($showBudgetAlert)
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 relative rounded shadow mt-4"
             wire:ignore.self>
            <div class="flex items-center justify-between">
                <div>
                    <strong class="font-semibold">Budget Alert:</strong> You’re close to exceeding your budget this
                    month for:
                    @foreach ($exceedCategories as $exceedCategory)
                        {{ $exceedCategory }}
                        @if(!$loop->last)
                            ,
                            @if($loop->remaining == 1)
                                and
                            @endif
                        @endif
                    @endforeach
                    ----- Spend Wisely!
                </div>

                <button wire:click="dismissBudgetAlert" title="Don't show for this month"
                        class="text-yellow-700 hover:text-yellow-900 transition p-1 ml-4">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif
</div>
