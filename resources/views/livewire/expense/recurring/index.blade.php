<div class="container mx-auto mt-8">
    <div class="w-1/2 mx-auto mt-5 text-center">
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-3" role="alert">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-3" role="alert">
                {{ session('error') }}
            </div>
        @endif
    </div>
    @if($recurringExpenses->isEmpty())
        <div class="w-1/2 mx-auto mt-5 text-center">
            <p class="text-lg font-semibold text-gray-600 dark:text-gray-300">No data available for this date.</p>
        </div>
    @endif
    <div class="w-1/2 mx-auto mt-5 text-end">
        <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" href="{{ route('recurring-expense.create') }}">
            Add Recurring Expense <i class="fa fa-plus"></i>
        </a>
    </div>

    @foreach($recurringExpenses as $index => $expense)
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg grid grid-cols-5 gap-2 w-1/2 mx-auto p-4 mt-3" wire:click="showExpense({{ $expense->id }})">
            <div class="col-span-1 flex items-center justify-start">
                <p><b class="mr-6">Frequency</b></p>
            </div>
            <div class="col-span-2 flex items-center justify-start">
                <p>: {{ $expense->frequency }}</p>
            </div>
            <div class="col-span-2 row-span-3 flex items-center justify-center">
                <b style="font-size: 35px">RM {{ number_format($expense->amount, 2) }}</b>
            </div>
            <div class="col-span-1 flex items-center justify-start">
                <p><b class="mr-6">Description</b></p>
            </div>
            <div class="col-span-2 flex items-center justify-start">
                <p>: {{ $expense->description }}</p>
            </div>
            <div class="col-span-1 flex items-center justify-start">
                <p><b class="mr-6">Next Payment Date</b></p>
            </div>
            <div class="col-span-1 flex items-center justify-start">
                <p>: {{ $expense->next_payment_date ? date('d/m/Y', strtotime($expense->next_payment_date)) : '-' }}</p>
            </div>
        </div>
    @endforeach
</div>
