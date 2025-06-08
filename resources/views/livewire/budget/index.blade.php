<div class="p-6 max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">My Budget</h2>
            <p class="text-gray-500 mt-1">Track and manage your budget</p>
        </div>
        <a href="{{ route('budget.create') }}" class="btn-primary text-white px-4 py-2 rounded">Add Budget</a>
    </div>

    @foreach (['success', 'error', 'warning', 'info'] as $msg)
        @if(session($msg))
            <div class="alert alert-{{ $msg }}">
                {{ session($msg) }}
            </div>
        @endif
    @endforeach

    <div class="mx-auto rounded mb-5">
        <div class="budget-main-card mb-12">
            <div class="budget-image">
                <img src="{{ asset('images/budget_wallet.png') }}" alt="Wallet Icon">
            </div>
            <div class="budget-info">
                <div class="budget-amount">
                    <i>{{ $salary ? 'RM ' . $salary : 'You have not setup salary in your profile.' }}</i></div>
                <div class="budget-label">Total Salary</div>
                <div class="budget-balance">Budget Balance (MYR) : <i>{{ number_format($remainingBudget, 2) }}</i></div>
            </div>
        </div>
    </div>


    <br/>
    <h2>Current Month Budgets</h2>
    <br/>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @if($budgets->isEmpty())
            <div class="w-1/2 mx-auto mt-5 text-center">
                <p class="text-lg font-semibold text-gray-600 dark:text-gray-300">You have not set any budget yet.</p>
            </div>
        @endif
        @foreach ($currentBudgets  as $currentBudget)
            <a href="{{ route('budget.edit', $currentBudget->id) }}" class="p-4 shadow border-l-8 budget-card"
               style="border-color: {{ $currentBudget->category->color_code ?? '#ffffff' }}">
                <div style="flex: 1">
                    <h3 class="text-md font-semibold">
                        {{ $currentBudget->category->name ?? 'All' }}
                    </h3>
                    <p class="text-sm text-gray-500">
                        {{ DateTime::createFromFormat('!m', $currentBudget->month)->format('F') }} {{ $currentBudget->year }}
                    </p>
                </div>
                <div style="flex: 1" class="text-right">
                    <span class="text-lg font-bold text-gray-800">
                        RM {{ number_format($currentBudget->amount, 2) }}
                    </span>
                </div>
                <div style="flex: 0 0 100%;border-top: 1px dashed black;" class="mt-2 pt-1">
                    <small>Spent: RM {{ number_format($currentBudget->spent, 2) }}</small>
                    <br/>
                    <small>Available: RM {{ number_format(($currentBudget->amount - $currentBudget->spent), 2) }}</small>
                </div>
            </a>
        @endforeach
    </div>

    <br/>
    <h2>Other Budgets</h2>
    <br/>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @if($budgets->isEmpty())
            <div class="w-1/2 mx-auto mt-5 text-center">
                <p class="text-lg font-semibold text-gray-600 dark:text-gray-300">You have not set any budget yet.</p>
            </div>
        @endif
        @foreach ($otherBudgets  as $budget)
            <a href="{{ route('budget.edit', $budget->id) }}" class="p-4 shadow border-l-8 budget-card"
               style="border-color: {{ $budget->category->color_code ?? '#ffffff' }}">
                <div>
                    <h3 class="text-md font-semibold">
                        {{ $budget->category->name ?? 'All' }}
                    </h3>
                    <p class="text-sm text-gray-500">
                        {{ DateTime::createFromFormat('!m', $budget->month)->format('F') }} {{ $budget->year }}
                    </p>
                </div>
                <div class="text-right">
                    <span class="text-lg font-bold text-gray-800">
                        RM {{ number_format($budget->amount, 2) }}
                    </span>
                </div>
            </a>
        @endforeach
    </div>
</div>
