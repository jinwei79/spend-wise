<!DOCTYPE html>
<html>
<head>
    <title>Expense Report - {{ ucfirst($timeframe) }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { font-size: 24px; margin-bottom: 5px; color: #2d3748; }
        .header p { font-size: 14px; color: #718096; }
        .summary-card { 
            background: #f8fafc; 
            border-radius: 8px; 
            padding: 20px; 
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #e2e8f0;
        }
        .total-amount { 
            font-size: 24px; 
            font-weight: bold;
            color: #3EB798;
        }
        .timeframe { font-size: 16px; color: #4a5568; }
        .chart-container { 
            display: flex; 
            margin-bottom: 30px;
            gap: 20px;
        }
        .chart-wrapper { 
            flex: 1;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }
        .chart-img {
            max-width: 100%;
            height: auto;
        }
        .breakdown { 
            flex: 1;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
        }
        .breakdown h3 { 
            margin-top: 0; 
            color: #2d3748;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 10px;
        }
        .category-item { 
            display: flex; 
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #f1f5f9;
        }
        .category-info { display: flex; align-items: center; }
        .color-box { 
            width: 12px; 
            height: 12px; 
            border-radius: 3px;
            margin-right: 10px;
        }
        .category-name { font-weight: 500; color: #4a5568; }
        .category-amount { text-align: right; }
        .amount { font-weight: 500; color: #2d3748; }
        .percentage { color: #718096; font-size: 13px; }
        .expense-list { margin-top: 30px; }
        .expense-list h3 { 
            margin-bottom: 15px; 
            color: #2d3748;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 10px;
        }
        .expense-item { 
            display: flex; 
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .expense-category { display: flex; align-items: center; }
        .expense-details { text-align: right; }
        .footer { 
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #a0aec0;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Expense Report</h1>
        <p>Generated on {{ now()->format('M d, Y \a\t h:i A') }}</p>
    </div>

    <div class="summary-card">
        <div>
            <div class="timeframe">{{ $timeLabel }}</div>
            <div style="color: #718096; font-size: 14px;">Time Period</div>
        </div>
        <div class="total-amount">RM{{ number_format($chartData['total'] ?? 0, 2) }}</div>
    </div>

    <div class="chart-container">
        <div class="chart-wrapper">
            <img src="{{ $chartImage }}" alt="Expense Distribution Chart" class="chart-img">
        </div>
        <div class="breakdown">
            <h3>Expense Breakdown</h3>
            @foreach($chartData['labels'] ?? [] as $index => $label)
                <div class="category-item">
                    <div class="category-info">
                        <div class="color-box" style="background-color: {{ $chartData['colors'][$index] ?? '#999' }}"></div>
                        <div class="category-name">{{ $label }}</div>
                    </div>
                    <div class="category-amount">
                        <div class="amount">RM{{ number_format($chartData['data'][$index] ?? 0, 2) }}</div>
                        <div class="percentage">
                            {{ round(($chartData['data'][$index] / $chartData['total']) * 100, 1) }}%
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if(count($expenses) > 0)
    <div class="expense-list">
        <h3>Recent Expenses</h3>
        @foreach($expenses as $expense)
            <div class="expense-item">
                <div class="expense-category">
                    <div style="width: 16px; height: 16px; background-color: {{ $expense->category->color_code }}; border-radius: 4px; margin-right: 10px;"></div>
                    <div>
                        <div style="font-weight: 500; color: #4a5568;">{{ $expense->category->name }}</div>
                        <div style="font-size: 12px; color: #718096;">{{ $expense->description }}</div>
                    </div>
                </div>
                <div class="expense-details">
                    <div style="font-weight: 500; color: #2d3748;">RM{{ number_format($expense->amount, 2) }}</div>
                    <div style="font-size: 12px; color: #718096;">
                        {{ \Carbon\Carbon::parse($expense->date)->format('M d, Y') }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @endif

    <div class="footer">
        Report generated by {{ config('app.name') }} | {{ now()->format('M d, Y') }}
    </div>
</body>
</html>