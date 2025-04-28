<div>

    <div class="flex flex-col w-3/4 mx-auto my-5">
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
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 my-2">
            <div class="flex items-center space-x-4">
                <label for="year" class="text-gray-700 dark:text-gray-300">{{ __('Year') }}</label>
                <select id="year" name="year" class="border-gray-300 dark:border-gray-700 rounded" wire:model.live="selectedYear">
                    @foreach (range(date('Y'), date('Y') - 10) as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>

                <label for="month" class="text-gray-700 dark:text-gray-300">{{ __('Month') }}</label>
                <select id="month" name="month" class="border-gray-300 dark:border-gray-700 rounded" wire:model.live="selectedMonth">
                    @foreach (range(1, 12) as $month)
                        <option value="{{ $month }}">{{ DateTime::createFromFormat('!m', $month)->format('F') }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-gray-800 dark:text-gray-200">
                    {{ __('My Expenses') }}
                </h2>
                <a href="{{ route('expense.create') }}" class="bg-blue-500 text-white p-3 rounded">
                    {{ __('Add Expense') }} <i class="fa fa-plus"></i>
                </a>
            </div>
            <div class="p-4">
                <livewire:expense.calendar
                initialYear="{{ $selectedYear }}"
                initialMonth="{{ $selectedMonth }}"
                :key="$selectedYear.$selectedMonth"/>
            </div>
        </div>
    </div>
</div>
