<div class="p-6 max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">My Expense Categories</h2>
            <p class="text-gray-500 mt-1">Track and manage your spending categories</p>
        </div>
        <a href="{{ route('category.create') }}" 
           class="btn-primary px-6 py-3 rounded-xl flex items-center gap-2 transition-all hover:scale-105 shadow-lg hover:shadow-xl bg-gradient-to-r from-blue-500 to-blue-600">
           <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
               <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
           </svg>
           Add Category
        </a>
    </div>

    <!-- Flash Messages -->
    <div class="space-y-3 mb-8">
        @foreach (['success', 'error', 'warning', 'info'] as $msg)
            @if(session($msg))
                <div class="alert-{{ $msg }} px-6 py-4 rounded-xl flex items-center border-l-4 animate-fade-in">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($msg == 'success')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        @elseif($msg == 'error')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        @elseif($msg == 'warning')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        @endif
                    </svg>
                    {{ session($msg) }}
                </div>
            @endif
        @endforeach
    </div>

    <!-- Categories Grid -->
    @if($categories->isEmpty())
        <div class="text-center py-12">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No categories yet</h3>
            <p class="mt-1 text-gray-500">Get started by creating your first expense category</p>
            <div class="mt-6">
                <a href="{{ route('category.create') }}" class="btn-primary inline-flex items-center px-4 py-2 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Create Category
                </a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($categories as $category)
                <a href="{{ route('category.view', $category->id) }}" class="group transform transition-all hover:-translate-y-1 hover:scale-102">
                    <div class="category-card h-full flex flex-col bg-white rounded-2xl overflow-hidden border border-gray-100 hover:border-blue-200 shadow-sm hover:shadow-md transition-all duration-300">
                        <div class="p-6 flex-1">
                            <div class="flex items-start justify-between">
                                <h3 class="text-xl font-semibold text-gray-900 group-hover:text-blue-600 mb-2 transition-colors">
                                    {{ $category->name }}
                                </h3>
                                <div class="w-8 h-8 rounded-full shadow-md ml-4 flex-shrink-0" 
                                     style="background-color: {{ $category->color_code }};"></div>
                            </div>
                            <p class="text-gray-600 line-clamp-2">{{ $category->description }}</p>
                        </div>
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-500 group-hover:text-blue-500 transition-colors">View Details</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-hover:text-blue-500 transition-colors" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>