
<div class="container mx-auto mt-8">
    <style>
        :disabled {
            cursor: not-allowed;
            background-color: #f0f0f0;
        }
    </style>

    <form wire:submit.prevent="update">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg grid grid-cols-4 gap-2 w-1/2 mx-auto p-4 mt-3">
            <div class="col-span-1 flex items-center justify-center">
                <p><b>Description :</b></p>
            </div>
            <div class="col-span-2 flex items-center justify-center">
                <input type="text" id="description" wire:model="expense.description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" @if (!$isEdit) disabled @endif>
            </div>
            <div class="col-span-3 flex justify-start">
                @error("expense.description")
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-1 row-span-2 flex items-center justify-center">

            </div>
            <div class="col-span-1 flex items-center justify-center">
                <p><b>Amount (RM) :</b></p>
            </div>
            <div class="col-span-2 flex items-center justify-center">
                <input type="number" step=".01" id="amount" wire:model="expense.amount" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" @if (!$isEdit) disabled @endif>
            </div>
            <div class="col-span-4 flex justify-start">
                @error("expense.amount")
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-1 flex items-center justify-center">
                <p><b>Category :</b></p>
            </div>
            <div class="col-span-2 flex items-center justify-center">
                <select id="category" wire:model="expense.expense_category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" @if (!$isEdit) disabled @endif>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-4 flex justify-start">
                @error("expense.expense_category_id")
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-1 flex items-center justify-center">
                <p><b>Date :</b></p>
            </div>
            <div class="col-span-2 flex items-center justify-center">
                <input type="date" id="date" wire:model="expense.date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" @if (!$isEdit) disabled @endif>
            </div>
            <div class="col-span-3 flex justify-start">
                @error("expense.date")
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-1 flex items-center justify-center">
                <div class="mt-2">
                    <label for="is_recurring" class="inline-flex items-center">
                        <input type="checkbox" id="is_recurring" wire:model="expense.is_recurring" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" @if (!$isEdit) disabled @endif>
                        <span class="ml-2 text-sm text-gray-700">Recurring</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="flex w-1/2 mx-auto justify-end mt-3">

            @if ($isEdit)
                <button type="button" class="bg-gray-600 text-white py-2 px-4 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 mr-2" wire:click="resetForm">Cancel</button>
                <button type="button" class="bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 mr-2" onclick="confirm('Are you sure you want to delete this expense?') || event.stopImmediatePropagation()" wire:click="deleteExpense({{ $expense['id'] }})">Delete <i class="fa fa-trash"></i></button>
                <button type="submit" class="bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" onclick="return confirm('Are you sure you want to update this expense?')">Update <i class="fa fa-save"></i></button>
            @else
                <a href="{{ route('expense.show-by-date', $expense['date'])}} " class="bg-gray-600 text-white py-2 px-4 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 mr-2">Cancel</a>
                <button type="button" class="bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2" wire:click="$set('isEdit', true)">Edit <i class="fa fa-edit"></i></button>
            @endif
        </div>
    </form>
</div>
