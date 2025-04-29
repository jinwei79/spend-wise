<div class="container mx-auto mt-8">
    <div class="flex flex-col w-1/2 mx-auto my-5">
        <div class="grid grid-cols-3 gap-2">
            <div class="col-span-1 flex items-center justify-start">
                <a href="{{ route('expense.show-by-date', ['date' => \Carbon\Carbon::parse($date)->subDay()->toDateString()]) }}">
                    <i class="fa fa-chevron-left" style="font-size: 40px" aria-hidden="true"></i>
                </a>
            </div>
            <div class="col-span-1 flex items-center justify-center">
                <p class="text-xl font-semibold text-gray-800 dark:text-gray-200" style="font-size: 30px">
                    {{ date('d M Y', strtotime($date)) }}
                </p>
            </div>
            <div class="col-span-1 flex items-center justify-end">
                <a href="{{ route('expense.show-by-date', ['date' => \Carbon\Carbon::parse($date)->addDay()->toDateString()]) }}">
                    <i class="fa fa-chevron-right" style="font-size: 40px" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>

    @if($expenses->isEmpty())
        <div class="w-1/2 mx-auto mt-5 text-center">
            <p class="text-lg font-semibold text-gray-600 dark:text-gray-300">No data available for this date.</p>
        </div>
    @endif
    @foreach($expenses as $index => $expense)
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg grid grid-cols-5 gap-2 w-1/2 mx-auto p-4 mt-3" wire:click="showExpense({{ $expense->id }})">
            <div class="col-span-3 flex items-center justify-start">
                <p><small>{{ date('H:i A', strtotime($expense->created_at)) }}</small></p>
            </div>
            {{-- <div class="col-span-1 flex items-center justify-start">
            </div> --}}
            <div class="col-span-2 row-span-2 flex items-center justify-end">
                <b style="font-size: 35px">RM {{ number_format($expense->amount, 2) }}</b>
            </div>
            <div class="col-span-1 flex items-center justify-start">
                <p><b class="mr-6">Description</b></p>
            </div>
            <div class="col-span-2 flex items-center justify-start">
                <p>: {{ $expense->description }}</p>
            </div>
            <div class="col-span-1 flex items-center justify-start">
                <p><b class="mr-6">Category</b></p>
            </div>
            <div class="col-span-1 flex items-center justify-start">
                <p>: {{ $expense->expenseCategory ? $expense->expenseCategory->name : 'ini category' }}</p>
            </div>
            <div class="col-span-3 flex items-center justify-end">
                <div class="mt-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" @if ($expense->is_recurring) checked @endif disabled class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Recurring</span>
                    </label>
                </div>
            </div>
        </div>
    @endforeach
    <div class="flex w-1/2 mx-auto justify-end mt-5">
        <a href="{{ route('expense.index') }}" class="bg-gray-600 text-white py-2 px-4 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 mr-2">Back</a>
        <a href="{{ route('expense.index') }}" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 mr-2">Back to Calendar <i class="fa fa-calendar"></i></a>
    </div>
</div>
