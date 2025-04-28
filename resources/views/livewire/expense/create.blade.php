<div class="container mx-auto mt-8">
    <form wire:submit.prevent="save">
        @foreach($expenses as $index => $expense)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg grid grid-cols-4 gap-2 w-1/2 mx-auto p-4 mt-3">
                <div class="col-span-1 flex items-center justify-center">
                    <p><b>Description :</b></p>
                </div>
                <div class="col-span-2 flex items-center justify-center">
                    <input type="text" id="description_{{ $index }}" wire:model="expenses.{{ $index }}.description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                </div>
                <div class="col-span-3 flex justify-start">
                    @error("expenses.{$index}.description")
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-1 row-span-2 flex items-center justify-center">
                    @if ($index > 0)
                        <button type="button" wire:click.prevent="removeExpenseRow({{ $index }})" class="bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            <i class="fa fa-trash"></i>
                        </button>
                    @else
                    <button type="button" wire:click.prevent="addExpenseRow" class="bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        <i class="fa fa-plus"></i>
                    </button>
                    @endif

                </div>
                <div class="col-span-1 flex items-center justify-center">
                    <p><b>Amount :</b></p>
                </div>
                <div class="col-span-2 flex items-center justify-center">
                    <input type="number" step=".01" id="amount_{{ $index }}" wire:model="expenses.{{ $index }}.amount" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="col-span-4 flex justify-start">
                    @error("expenses.{$index}.amount")
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-1 flex items-center justify-center">
                    <p><b>Date :</b></p>
                </div>
                <div class="col-span-2 flex items-center justify-center">
                    <input type="date" id="date_{{ $index }}" wire:model="expenses.{{ $index }}.date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="col-span-3 flex justify-start">
                    @error("expenses.{$index}.date")
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-1 flex items-center justify-center">
                    <div class="mt-2">
                        <label for="is_recurring_{{ $index }}" class="inline-flex items-center">
                            <input type="checkbox" id="is_recurring_{{ $index }}" wire:model="expenses.{{ $index }}.is_recurring" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-700">Recurring</span>
                        </label>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="flex w-1/2 mx-auto justify-end mt-3">
            <a href="{{ url()->previous() }}" class="bg-gray-600 text-white py-2 px-4 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 mr-2">Cancel</a>
            <button type="submit" class="bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">Submit</button>
        </div>
    </form>
</div>
