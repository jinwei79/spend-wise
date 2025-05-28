<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\User;
use App\Models\Budget;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Get all expenses for the current user
        $expenses = Expense::where('user_id', $userId)->get();

        // Calculate summary stats
        $totalExpenses = $expenses->sum('amount');
        
        $monthlyRecurring = $expenses
            ->where('is_recurring', true)
            ->whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('amount');

        // Category summary
        $categorySummary = $expenses->groupBy('expense_category_id')->map(function ($group) {
            return $group->sum('amount');
        });

        $categoryNames = ExpenseCategory::whereIn('id', $categorySummary->keys())->pluck('name', 'id');

        $categorySummaryFormatted = $categorySummary->mapWithKeys(function ($amount, $id) use ($categoryNames) {
            return [$categoryNames[$id] ?? 'Unknown' => $amount];
        });

        $topCategory = $categorySummaryFormatted->sortDesc()->keys()->first();

        // Recent expenses
        $recentExpenses = Expense::with('category')
            ->where('user_id', $userId)
            ->orderByDesc('date')
            ->take(5)
            ->get();

        // --- Charts for CURRENT USER ---
        
        // 1. Current user's budgets by category (vertical bar chart)
        $userBudgetsByCategory = Budget::where('user_id', $userId)
            ->selectRaw('category_id, SUM(amount) as total')
            ->groupBy('category_id')
            ->with('category')
            ->get();

        $monthlyBudgetChart = [
            'labels' => $userBudgetsByCategory->pluck('category.name'),
            'data' => $userBudgetsByCategory->pluck('total'),
        ];

        // 2. Current user's expenses by category (horizontal bar chart)
        $userCategorySummary = Expense::where('user_id', $userId)
            ->selectRaw('expense_category_id, SUM(amount) as total')
            ->groupBy('expense_category_id')
            ->with('category')
            ->get();

        $categoryExpenseChart = [
            'labels' => $userCategorySummary->pluck('category.name'),
            'data' => $userCategorySummary->pluck('total'),
        ];

        return view('dashboard', [
            'totalExpenses' => $totalExpenses,
            'monthlyRecurring' => $monthlyRecurring,
            'topCategory' => $topCategory,
            'categorySummary' => $categorySummaryFormatted,
            'recentExpenses' => $recentExpenses,
            'monthlyBudgetChart' => $monthlyBudgetChart,      
            'categoryExpenseChart' => $categoryExpenseChart,    
        ]);
    }
}