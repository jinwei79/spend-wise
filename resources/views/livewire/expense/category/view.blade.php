<div class="p-4 mt-10">
<div style="font-family: 'Poppins', sans-serif; font-weight: bold; font-size: 50px; text-align: center;">
    <div style="display: inline-block; margin-right: auto; transform: translateX(-100%) translateY(-35px);">
    Category Detail

    </div>
    </div>

    <div class="max-w-md mx-auto rounded">

        <div class="category-card">
            <div class="category-content">
                <div class="category-info">
                    <p><strong>Name</strong> : {{ $category->name }}</p>
                    <p><strong>Color</strong> : <span
                            style="padding: 5px;color: gray;background-color: {{ $category->color_code }};">{{ $category->color_code }}</span>
                    </p>
                    <p><strong>Description</strong> : {{ $category->description }}</p>
                </div>

                @if(!$category->is_default)
                    <div class="category-actions">
                        <button wire:click="confirmDelete({{ $category->id }})"
                                class="bg-red-600 text-white px-4 py-2 rounded">Delete
                        </button>
                        <a class=" btn-edit" href="{{ route('category.edit', $category->id) }}">Edit</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Confirmation Modal --}}
    @if($confirmingDelete)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded shadow-lg">
                <p class="mb-4">Are you sure you want to delete this category?</p>
                <div class="flex justify-end space-x-3">
                    <button wire:click="$set('confirmingDelete', false)" class="bg-gray-300 px-4 py-2 rounded">Cancel
                    </button>
                    <button wire:click="deleteCategory" class="bg-red-600 text-white px-4 py-2 rounded">Delete</button>
                </div>
            </div>
        </div>
    @endif
</div>
