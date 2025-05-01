<?php

namespace App\Livewire\Report;

use Livewire\Component;
use Illuminate\Support\Carbon;

class ExpenseReport extends Component
{
    public $timeframe = 'month';
    public $expenses = [];
    public $chartData = [];

    public function mount()
    {
        $this->loadExpenses();
        $this->prepareChartData();
    }

    public function updatedTimeframe()
    {
        $this->loadExpenses();
        $this->prepareChartData();
    }

    private function loadExpenses()
    {
        // Sample data - replace with your actual data source
        $this->expenses = [
            [
                'name' => 'Gas Refill',
                'amount' => 500.00,
                'category' => 'Gas',
                'date' => now()->subDays(2)->format('Y-m-d')
            ],
            [
                'name' => 'Grocery Shopping',
                'amount' => 1000.00,
                'category' => 'Food & Beverage',
                'date' => now()->subDays(5)->format('Y-m-d')
            ],
            [
                'name' => 'Apartment Rent',
                'amount' => 12000.00,
                'category' => 'Rent',
                'date' => now()->subDays(1)->format('Y-m-d')
            ],
            [
                'name' => 'Movie Tickets',
                'amount' => 3000.00,
                'category' => 'Entertainment',
                'date' => now()->subDays(3)->format('Y-m-d')
            ]
        ];
    }

    private function prepareChartData()
    {
        $this->chartData = [
            'labels' => ['Gas', 'Food & Beverage', 'Rent', 'Entertainment'],
            'data' => [500, 1000, 12000, 3000],
            'colors' => ['#3B82F6', '#10B981', '#F59E0B', '#EF4444'],
            'total' => 16500 // Sum of all values
        ];
    
        $this->dispatch('chartUpdated', data: $this->chartData);
    }

    public function render()
    {
        return view('livewire.report.expensereport')
            ->layout('layouts.app');
    }
}