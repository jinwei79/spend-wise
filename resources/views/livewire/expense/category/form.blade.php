<div class="p-4 mt-10">
    <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">
            {{ $categoryId ? 'Edit Category' : 'Add New Category' }}
        </h2>

        <form wire:submit.prevent="save">
            <div class="mb-4">
                <label class="block text-gray-700">Name</label>
                <input type="text" wire:model="name" class="w-full border rounded px-3 py-2 mt-1">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Description</label>
                <textarea wire:model="description" class="w-full border rounded px-3 py-2 mt-1"></textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Color</label>
                <input type="color" wire:model="color_code" class="w-16 h-10 p-1 border rounded">
                @error('color_code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 ">
                {{ $categoryId ? 'Update' : 'Create' }}
            </button>
        </form>
    </div>
</div>
