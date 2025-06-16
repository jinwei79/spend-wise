<div class="p-4 mt-10">
    <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">
            {{ $budgetId ? 'Edit Budget' : 'Add New Budget' }}
        </h2>

        <form wire:submit.prevent="save">
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Category</label>
                <select id="category_id" wire:model="category_id" class="w-full border border-gray-300 rounded p-2"
                        required>
                    <option value="">Category</option>
                    <option value="0">All</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex gap-4 mb-4">
                <div class="w-1/2">
                    <label class="block text-gray-700 mb-1" for="month">Month</label>
                    <select id="month" wire:model="month" class="w-full border border-gray-300 rounded p-2" required>
                        <option value="">Month</option>
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}">{{ DateTime::createFromFormat('!m', $m)->format('F') }}</option>
                        @endforeach
                    </select>
                    @error('month') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="w-1/2">
                    <label class="block text-gray-700 mb-1" for="year">Year</label>
                    <input type="number" id="year" wire:model="year" class="w-full border border-gray-300 rounded p-2"
                           min="2000" max="2100" required>
                    @error('year') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Amount</label>
                <input type="number" step=".10" id="amount" wire:model="amount"
                       class="w-full border border-gray-300 rounded p-2">
                @error('amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="category-actions">
                @if($budgetId)
                    <button type="button" wire:click="confirmDelete({{ $budgetId }})"
                            class="bg-red-600 text-white px-4 py-2 rounded">Delete
                    </button>
                @endif
                <button type="submit"
                        class="btn-primary btn-edit text-white px-4 py-2 rounded ">{{ $budgetId ? 'Update' : 'Create' }}</button>
            </div>
        </form>
    </div>

    {{-- Confirmation Modal --}}
    @if($confirmingDelete)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded shadow-lg">
                <p class="mb-4">Are you sure you want to delete this budget?</p>
                <div class="flex justify-end space-x-3">
                    <button wire:click="$set('confirmingDelete', false)" class="bg-gray-300 px-4 py-2 rounded">Cancel
                    </button>
                    <button wire:click="deleteBudget" class="bg-red-600 text-white px-4 py-2 rounded">Delete</button>
                </div>
            </div>
        </div>
    @endif
</div>
