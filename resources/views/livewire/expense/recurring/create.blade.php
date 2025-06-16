
<div class="container mx-auto mt-8">
    <style>
        :disabled {
            cursor: not-allowed;
            background-color: #f0f0f0;
        }
    </style>

    <form wire:submit.prevent="save">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg grid grid-cols-4 gap-2 w-1/2 mx-auto p-4 mt-3">
            <div class="col-span-1 flex items-center justify-end">
                <p><b>Status :</b></p>
            </div>
            <div class="col-span-3 flex items-center justify-start">
                <select id="is_active" wire:model="expense.is_active" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <div class="col-span-1 flex items-center justify-end">
                <p><b>Frequency :</b></p>
            </div>
            <div class="col-span-3 flex items-center justify-center">
                <select id="frequency" wire:model="expense.frequency" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                    <option value="yearly">Yearly</option>
                </select>
            </div>
            <div class="col-span-4 flex justify-center">
                @error("expense.frequency")
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-1 flex items-center justify-end">
                <p><b>Amount (RM) :</b></p>
            </div>
            <div class="col-span-3 flex items-center justify-center">
                <input type="number" step=".01" id="amount" wire:model="expense.amount" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="col-span-4 flex justify-center">
                @error("expense.amount")
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-1 flex items-center justify-end">
                <p><b>Description :</b></p>
            </div>
            <div class="col-span-3 flex items-center justify-center">
                <input type="text" id="description" wire:model="expense.description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="col-span-4 flex justify-center">
                @error("expense.description")
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-1 flex items-center justify-end">
                <p><b>Start Date :</b></p>
            </div>
            <div class="col-span-3 flex items-center justify-center">
                <input type="date" id="start_date" wire:model="expense.start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="col-span-4 flex justify-center">
                @error("expense.start_date")
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-1 flex items-center justify-end">
                <p><b>End Date :</b></p>
            </div>
            <div class="col-span-3 flex items-center justify-center">
                <input type="date" id="end_date" wire:model="expense.end_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="col-span-4 flex justify-center">
                @error("expense.end_date")
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="flex w-1/2 mx-auto justify-end mt-3">
            <button type="button" class="bg-gray-600 text-white py-2 px-4 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 mr-2" wire:click="resetForm">Cancel</button>
            <button type="submit" class="bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" onclick="return confirm('Are you sure you want to save this recurring expense?')">Save</button>
        </div>
    </form>
</div>
