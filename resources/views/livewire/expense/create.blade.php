<div class="container mx-auto mt-8">

    <div class="mt-8 mb-8">
        @if(!empty($remainingBudgets))
            <p class="text-white mt-4 mb-2">Remaining budget this month:</p>
        @endif
        <div class="gap-4 grid grid-cols-1 grid-cols-6">
            @foreach ($remainingBudgets as $budget)
                <div class="flex items-center justify-between" style="border-bottom: 1px solid white">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full" style="background-color: {{ $budget['color_code'] }}"></div>
                        <div>
                            <div class="font-medium text-white truncate" style="width: 80px" title="{{ $budget['category'] }}">{{ $budget['category'] }}</div>
                        </div>
                    </div>

                    <div class="text-right {{ number_format($budget['remaining'], 2) < 0 ? 'text-red-500' : 'text-white' }}">
                        RM {{ number_format($budget['remaining'], 2)  }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <form wire:submit.prevent="save">
        @foreach($expenses as $index => $expense)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg grid grid-cols-4 gap-2 w-1/2 mx-auto p-4 mt-3">
                <div class="col-span-1 flex items-center justify-center">
                    <p><b>Description :</b></p>
                </div>
                <div class="col-span-2 flex items-center justify-center">
                    <input type="text" id="description_{{ $index }}" wire:model="expenses.{{ $index }}.description" wire:change='onChangeDescription({{ $index }})' class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

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
                    <p><b>Category :</b></p>
                </div>
                <div class="col-span-2 flex items-center justify-center">
                    <select id="category_{{ $index }}" wire:model="expenses.{{ $index }}.expense_category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-4 flex justify-start">
                    @error("expenses.{$index}.expense_category_id")
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
