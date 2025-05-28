<x-app-layout>
<div style="font-family: 'Poppins', sans-serif; font-weight: bold; font-size: 50px; text-align: center;">
    <div style="display: inline-block; margin-right: auto; transform: translateX(-100%) translateY(25px);">
                 Hi, {{ Auth::user()->name }}
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-12 space-y-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
  
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <div class="text-gray-500 dark:text-gray-300 text-sm">Total Expenses</div>
                <div class="text-2xl font-bold text-gray-800 dark:text-white">
                    RM {{ number_format($totalExpenses, 2) }}
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <div class="text-gray-500 dark:text-gray-300 text-sm">Recurring This Month</div>
                <div class="text-2xl font-bold text-gray-800 dark:text-white">
                    RM {{ number_format($monthlyRecurring, 2) }}
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <div class="text-gray-500 dark:text-gray-300 text-sm">Top Category</div>
                <div class="text-2xl font-bold text-gray-800 dark:text-white">
                    {{ $topCategory ?? 'N/A' }}
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
 
            <div
                class="p-6 rounded-lg shadow-lg"
                style="
                    background: linear-gradient(135deg, #bfdbfe 0%, #eff6ff 100%);
                    box-shadow:
                        0 10px 15px -3px rgba(59, 130, 246, 0.3),
                        0 4px 6px -2px rgba(59, 130, 246, 0.15);
                ">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-900 mb-4">Your Monthly Budget</h3>
                <canvas id="monthlyBudgetChart" height="300"></canvas>
            </div>

        
            <div
                class="p-6 rounded-lg shadow-lg relative overflow-hidden"
                style="
                    background: linear-gradient(135deg, #d1fae5 0%, #ecfdf5 100%);
                    box-shadow:
                        0 10px 15px -3px rgba(16, 185, 129, 0.3),
                        0 4px 6px -2px rgba(16, 185, 129, 0.15);
                ">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-900 mb-4">Your Expenses by Category</h3>
                <canvas id="categoryExpenseChart" height="300"></canvas>

            
                <div
                    aria-hidden="true"
                    style="
                        position: absolute;
                        top: 0; left: 0; right: 0; bottom: 0;
                        background-image: repeating-linear-gradient(
                            45deg,
                            rgba(34, 197, 94, 0.1),
                            rgba(34, 197, 94, 0.1) 10px,
                            transparent 10px,
                            transparent 20px
                        );
                        pointer-events: none;
                        border-radius: 0.75rem;
                    ">
                </div>
            </div>
        </div>

        <!-- Category summary section -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Your Expenses by Category</h3>
            @foreach ($categorySummary as $category => $amount)
                <div class="flex justify-between py-1 text-gray-700 dark:text-gray-200">
                    <span>{{ $category }}</span>
                    <span>RM {{ number_format($amount, 2) }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <script>
   
        const monthlyBudgetCtx = document.getElementById('monthlyBudgetChart').getContext('2d');
        const monthlyBudgetGradient = monthlyBudgetCtx.createLinearGradient(0, 0, 0, 300);
        monthlyBudgetGradient.addColorStop(0, 'rgba(59, 130, 246, 0.8)');
        monthlyBudgetGradient.addColorStop(1, 'rgba(59, 130, 246, 0.4)');

        new Chart(monthlyBudgetCtx, {
            type: 'bar',
            data: {
                labels: @json($monthlyBudgetChart['labels']),
                datasets: [{
                    label: 'Budget (RM)',
                    data: @json($monthlyBudgetChart['data']),
                    backgroundColor: monthlyBudgetGradient,
                    borderRadius: 8,
                    borderSkipped: false,
                    barPercentage: 0.6,
                    maxBarThickness: 40,
                    hoverBackgroundColor: 'rgba(59, 130, 246, 1)'
                }]
            },
            options: {
                responsive: true,
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuart'
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#374151',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(55, 65, 81, 0.9)',
                        titleFont: {
                            weight: 'bold'
                        },
                        cornerRadius: 6,
                        padding: 10,
                        callbacks: {
                            label: ctx => `RM ${ctx.formattedValue}`
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#6B7280',
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#6B7280',
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            color: 'rgba(229, 231, 235, 0.6)',
                            borderDash: [5, 5]
                        }
                    }
                }
            }
        });

      
        const categoryExpenseCtx = document.getElementById('categoryExpenseChart').getContext('2d');
        const categoryExpenseGradient = categoryExpenseCtx.createLinearGradient(0, 0, 300, 0);
        categoryExpenseGradient.addColorStop(0, 'rgba(16, 185, 129, 0.8)');
        categoryExpenseGradient.addColorStop(1, 'rgba(16, 185, 129, 0.4)');

        new Chart(categoryExpenseCtx, {
            type: 'bar',
            data: {
                labels: @json($categoryExpenseChart['labels']),
                datasets: [{
                    label: 'Amount (RM)',
                    data: @json($categoryExpenseChart['data']),
                    backgroundColor: categoryExpenseGradient,
                    borderRadius: 8,
                    borderSkipped: false,
                    barPercentage: 0.6,
                    maxBarThickness: 40,
                    hoverBackgroundColor: 'rgba(16, 185, 129, 1)'
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuart'
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#374151',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(55, 65, 81, 0.9)',
                        titleFont: {
                            weight: 'bold'
                        },
                        cornerRadius: 6,
                        padding: 10,
                        callbacks: {
                            label: ctx => `RM ${ctx.formattedValue}`
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            color: '#6B7280',
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            color: 'rgba(229, 231, 235, 0.6)',
                            borderDash: [5, 5]
                        }
                    },
                    y: {
                        ticks: {
                            color: '#6B7280',
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>