<?php

namespace App\Console\Commands;

use App\Models\Budget;
use App\Models\Expense;
use App\Notifications\BudgetThresholdAlert;
use Illuminate\Console\Command;

class CheckBudgetNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:budget-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To check all budget and fire email notification to user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $budgets = Budget::where('notified', false)->get();
        foreach ($budgets as $budget) {
            $spent = Expense::where('expense_category_id', $budget->category_id)
                ->whereMonth('created_at', $budget->month)
                ->whereYear('created_at', $budget->year)
                ->sum('amount');

            if ($spent >= $budget->amount * 0.9) { // 90% threshold
                $user = $budget->user;
                $user->notify(new BudgetThresholdAlert($budget));

                $budget->notified = true;
                $budget->save();
            }
        }
    }
}
