<div class="p-4">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold">My Expense Categories</h2>
        <a href="{{ route('category.create') }}" class="btn-primary text-white px-4 py-2 rounded">Add Category</a>
    </div>

    @foreach (['success', 'error', 'warning', 'info'] as $msg)
        @if(session($msg))
            <div class="alert alert-{{ $msg }}">
                {{ session($msg) }}
            </div>
        @endif
    @endforeach

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">
        @foreach ($categories as $category)
            <a href="{{ route('category.view', $category->id) }}">
                <div class="flex items-center justify-between p-4 mb-4 border rounded shadow-sm bg-white">

                    <div style="flex: 50%;">
                        <h3 class="text-lg font-semibold">{{ $category->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $category->description }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full" style="background-color: {{ $category->color_code }};"></div>
                </div>
            </a>
        @endforeach
    </div>
</div>

