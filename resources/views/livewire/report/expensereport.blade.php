<div>
    <div class="flex justify-center">
        <div class="p-6 text-gray-900">
            <!-- Timeframe Selector -->
            <div class="flex flex-wrap gap-3 mb-6">
                @foreach(['month' => 'Month', '6months' => 'Last 6 Months', 'year' => 'This Year', 'all_time' => 'All Time'] as $key => $label)
                    <button wire:click="$set('timeframe', '{{ $key }}')"
                            class="px-4 py-2 rounded-full text-sm
                            {{ $timeframe === $key ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }}">
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            <!-- Report Summary -->
            <div class="p-6 rounded-lg shadow mb-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-xl font-bold">{{ ucfirst(str_replace('_', ' ', $timeframe)) }} Expenses</h2>
                        <h3 class="text-lg text-gray-600">{{ $this->getTimeLabel() }}</h3>
                    </div>
                    <div class="text-2xl font-bold text-blue-500">
                        Total: RM{{ number_format($chartData['total'] ?? 0, 2) }}
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Pie Chart -->
                    <div class="relative w-full max-w-xs mx-auto aspect-square">
                        <canvas id="pieChart" class="w-full h-full"></canvas>
                    </div>
                    
                    <!-- Expense Breakdown -->
                    <div class="bg-white shadow-lg rounded-lg p-4">
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
                    </div>
                </div>
                
                <!-- Export Button -->
                <div class="mt-4 flex justify-end">
                    <button wire:click="exportPdf"
                            class="px-5 py-2.5 text-white font-medium rounded-lg flex items-center gap-2 hover:opacity-90 transition-opacity"
                            style="background-color: #3EB798;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>Export PDF</span>
                    </button>
                </div>
            </div>

            <!-- Recent Expenses -->
            <div class="bg-white shadow-lg rounded-lg p-4 mt-6">
                <h3 class="text-lg font-semibold mb-4">Recent Expenses</h3>
                <ul class="divide-y">
                    @foreach($expenses as $expense)
                        <li class="py-3">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 rounded-full" style="background-color: {{ $expense->category->color_code }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium">{{ $expense->category->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $expense->description }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium text-gray-500">RM{{ number_format($expense->amount, 2) }}</p>
                                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($expense->date)->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    
    
  <!-- Icon line-->
    <div style="position: absolute; right: 135px; top: 450px;">

   
            <svg width="2" height="201" viewBox="0 0 2 201" fill="none" xmlns="http://www.w3.org/2000/svg">
                <line x1="1" y1="1" x2="0.999991" y2="200" stroke="#1A3237" stroke-width="2" stroke-linecap="round"/>
            </svg>



    </button>
    </div>
</div>

    <script>
    var pieChartInstance = null;
    var chartData = @json($chartData);

    function renderChart() {
        const ctx = document.getElementById('pieChart').getContext('2d');
        const chartData = @json($chartData);

        // Destroy previous chart if it exists
        if (pieChartInstance) {
            pieChartInstance.destroy();
        }

        pieChartInstance = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: chartData.labels,
                datasets: [{
                    data: chartData.data,
                    backgroundColor: chartData.colors,
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
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.formattedValue || '';
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((context.raw / total) * 100);
                                return `${label}: RM${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    }

    // Initial render
    document.addEventListener('DOMContentLoaded', function() {
        renderChart();
    });

    // Handle Livewire updates
    Livewire.on('chartUpdated', (chartData) => {
    if (chartData.labels && chartData.labels.length > 0) {
        if (pieChartInstance) {
            pieChartInstance.destroy();
        }

        const ctx = document.getElementById('pieChart').getContext('2d');
        pieChartInstance = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: chartData.labels,
                datasets: [{
                    data: chartData.data,
                    backgroundColor: chartData.colors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'right' },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.formattedValue || '';
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((context.raw / total) * 100);
                                return `${label}: RM${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    } else {
        console.warn('No chart data received');
    }
});
console.log(chartData);
</script>
</div>