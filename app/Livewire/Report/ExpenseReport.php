<?php

namespace App\Livewire\Report;

use Livewire\Component;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ExpenseReport extends Component
{
    public $timeframe = 'month';
    public $expenses = [];
    public $chartData = [];

    public function mount()
    {
        $this->loadExpenses();
        $this->prepareChartData();
        $this->dispatch('chartUpdated', chartData: $this->chartData);
    }
    
    public function setTimeframe($key)
{
    $this->timeframe = $key;
    $this->updatedTimeframe();
    
}

public function updatedTimeframe()
{
    $this->loadExpenses();
    $this->prepareChartData();

    
    $this->dispatch('chartUpdated', chartData: $this->chartData);
}


    
    private function loadExpenses()
    {
        $query = Expense::with('category')
            ->where('user_id', Auth::id());
    
        switch ($this->timeframe) {
            case 'month':
                $query->whereMonth('date', now()->month)
                      ->whereYear('date', now()->year);
                break;
            case '6months':
                $query->whereBetween('date', [now()->subMonths(6), now()]);
                break;
            case 'year':
                $query->whereYear('date', now()->year);
                break;
            case 'all_time':
              
                \Log::info("Fetching all time expenses.");
                $query->whereRaw('DATE(date) <= CURDATE()');
                break;
        }
    
        
        $expenses = $query->orderBy('date', 'desc')->get();
        \Log::info("SQL Query Executed: " . $query->toSql());
        \Log::info("Expenses count: " . $expenses->count());
    
        $this->expenses = $expenses;
    }
    
       

    private function prepareChartData()
    {
 
        \Log::info('Expenses: ' . json_encode($this->expenses));
    
     
        $grouped = $this->expenses->groupBy('category.name')->map(function ($items) {
            return $items->sum('amount');
        })->sortDesc();
    
      
        \Log::info('Grouped Data: ' . json_encode($grouped));
    
        $labels = $grouped->keys()->toArray();
        $data = $grouped->values()->toArray();
    
   
        \Log::info('Chart Data: ' . json_encode([
            'labels' => $labels,
            'data' => $data,
            'total' => array_sum($data)
        ]));
    
        // Generate colors
        $colors = [];
        foreach ($labels as $index => $label) {
            $color = $this->expenses->firstWhere('category.name', $label)?->category?->color_code 
                   ?? $this->generateRandomColor($index) 
                   ?? '#999999';
            $colors[] = $color;
        }

    
        $this->chartData = [
            'labels' => $labels,
            'data' => $data,
            'colors' => $colors,
            'total' => array_sum($data)
        ];
    }
    

    public function exportPdf()
    {
        try {
            $pdf = Pdf::loadView('livewire.report.expense-report-pdf', [
                'timeframe' => $this->timeframe,
                'chartData' => $this->chartData,
                'expenses' => $this->expenses,
                'timeLabel' => $this->getTimeLabel(),
                'chartImage' => $this->generateChartImage(),
            ]);
    
            return response()->streamDownload(
                fn () => print($pdf->output()),
                'expense-report-' . $this->timeframe . '-' . now()->format('Y-m-d') . '.pdf'
            );
        } catch (\Exception $e) {
            // Handle error gracefully
            session()->flash('error', 'Failed to generate PDF: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    private function generateChartImage()
    {
        try {
            $chartConfig = [
                'type' => 'pie',
                'data' => [
                    'labels' => $this->chartData['labels'],
                    'datasets' => [[
                        'data' => $this->chartData['data'],
                        'backgroundColor' => $this->chartData['colors'], 
                        'borderWidth' => 1,
                    ]]
                ],
                'options' => [
                    'responsive' => true,
                    'plugins' => [
                        'legend' => [
                            'position' => 'right',
                            'labels' => [
                                'boxWidth' => 12,
                                'padding' => 20
                            ]
                        ],
                        'title' => [
                            'display' => true,
                            'text' => 'Expense Distribution',
                            'font' => [
                                'size' => 16
                            ]
                        ]
                    ]
                ]
            ];
    
            
            \Log::info('Chart Config:', $chartConfig);
    
            $chartUrl = 'https://quickchart.io/chart?width=500&height=300&c=' . urlencode(json_encode($chartConfig));
            $imageContent = file_get_contents($chartUrl);
    
            if ($imageContent === false) {
                throw new \Exception("Failed to fetch chart image");
            }
    
            return 'data:image/png;base64,' . base64_encode($imageContent);
        } catch (\Exception $e) {
          
            return $this->generateFallbackChart();
        }
    }

    private function generateFallbackChart()
    {
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="500" height="300" viewBox="0 0 500 300">
            <rect width="100%" height="100%" fill="#f8fafc"/>
            <text x="50%" y="50%" font-family="Arial" font-size="16" text-anchor="middle" fill="#666">
                Chart could not be displayed
            </text>
        </svg>';
        
        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    private function getTimeLabel()
    {
        switch ($this->timeframe) {
            case 'month':
                return now()->format('F Y');
            case '6months':
                return now()->subMonths(6)->format('M Y') . ' - ' . now()->format('M Y');
            case 'year':
                return now()->year;
            default:
                return 'All Time';
        }
    }

    public function render()
    {
        return view('livewire.report.expensereport')
            ->layout('layouts.app');
    }
}