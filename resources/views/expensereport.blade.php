<div class="p-6 text-gray-900">
    <!-- Timeframe Selector -->
    <div class="flex flex-wrap gap-3 mb-6">
        @foreach(['week' => 'Week', 'month' => 'Month', 'year' => 'Year'] as $key => $label)
            <button wire:click="$set('timeframe', '{{ $key }}')"
                class="px-4 py-2 rounded-full text-sm
                    {{ $timeframe === $key ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }}">
                {{ $label }}
            </button>

            
        @endforeach
    </div>

    <!-- Combined Monthly Summary and Pie Chart -->
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-xl font-bold">Monthly Expenses</h2>
                <h3 class="text-lg text-gray-600">{{ now()->format('F Y') }}</h3>
            </div>
            
            <div class="text-2xl font-bold text-blue-500">
                Total: RM{{ number_format($chartData['total'] ?? 0, 2) }}
            </div>
            
        </div>
  
   
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Pie Chart -->
        <div class="h-64">
            <canvas id="pieChart" width="400" height="400"></canvas>
        </div>
        
        <!-- Expense Breakdown -->
        <div>
            <div class="mb-4">
                <h3 class="text-lg font-semibold">Expense Breakdown</h3>
            </div>
            <div class="space-y-4">
                @foreach($chartData['labels'] ?? [] as $index => $label)
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full mr-2" 
                             style="background-color: {{ $chartData['colors'][$index] ?? '#999' }}"></div>
                        <span>{{ $label }}</span>
                    </div>
                    <div class="text-right">
                        <span class="font-medium">RM{{ number_format($chartData['data'][$index] ?? 0, 2) }}</span>
                        <span class="text-sm text-gray-500 ml-2">
                            ({{ round(($chartData['data'][$index] / $chartData['total']) * 100, 1) }}%)
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
          
            <!-- Action Buttons Container -->
            <div class="mt-6 space-y-3 flex flex-col items-end">
                <button class="text-blue-500 font-medium hover:text-blue-700 transition">
                    View All Expenses
                </button>
                
                <button wire:click="exportPdf" 
                        class="px-5 py-2.5 text-white font-medium rounded-lg flex items-center gap-2 hover:opacity-90 transition-opacity"
                        style="background-color: #3EB798;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="text-center flex-1">Export PDF</span>
                </button>
            </div>
        </div>
    </div>
</div>

    <!-- Recent Transactions -->
    <div class="bg-white shadow-lg rounded-lg p-4">
        <h3 class="text-lg font-semibold mb-4">Recent Transactions</h3>
        <ul class="divide-y">
            @foreach($expenses as $expense)
                <li class="py-3">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 rounded-full bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium">{{ $expense['name'] }}</p>
                                <p class="text-sm text-gray-500">{{ $expense['category'] }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-red-500">-RM{{ number_format($expense['amount'], 2) }}</p>
                            <p class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($expense['date'])->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('livewire:init', () => {
    const ctx = document.getElementById('pieChart');
    const chart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: @json($chartData['labels'] ?? []),
            datasets: [{
                data: @json($chartData['data'] ?? []),
                backgroundColor: @json($chartData['colors'] ?? []),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                },
                tooltip: {
                    callbacks: {
                        label: (context) => {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((context.raw / total) * 100);
                            return `${context.label}: RM${context.raw.toLocaleString()} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush