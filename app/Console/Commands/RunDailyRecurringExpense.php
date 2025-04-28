<?php

namespace App\Console\Commands;

use App\Models\Expense;
use Illuminate\Console\Command;

class RunDailyRecurringExpense extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-daily-recurring-expense';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will run daily recurring expenses';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $recurringExpenses = \App\Models\RecurringExpense::where('next_payment_date', date('Y-m-d'))
            ->where('is_active', true)
            ->get();

        foreach ($recurringExpenses as $recurringExpense) {
            // Create a new expense for the user
            Expense::create([
                'user_id' => $recurringExpense->user_id,
                'amount' => $recurringExpense->amount,
                'description' => $recurringExpense->description,
                'date' => now(),
                'is_recurring' => false,
            ]);

            // Update the next payment date
            if ($recurringExpense->frequency == 'daily') {
                $recurringExpense->next_payment_date = now()->addDay();
            } elseif ($recurringExpense->frequency == 'weekly') {
                $recurringExpense->next_payment_date = now()->addWeek();
            } elseif ($recurringExpense->frequency == 'monthly') {
                $recurringExpense->next_payment_date = now()->addMonth();
            } else {
                $recurringExpense->next_payment_date = now()->addYear();
            }

            $recurringExpense->save();
        }

        $this->info('Daily recurring expenses have been processed successfully.');
    }
}
