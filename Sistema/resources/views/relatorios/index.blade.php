@extends('layouts.app')

@section('header_title', 'Painel de Relatórios Gerenciais')

@section('content')

<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
    <p class="text-sm text-gray-500 font-medium">Visualize o desempenho financeiro e operacional consolidado de suas safras.</p>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col min-w-[200px]">
        <div class="w-full h-1 bg-indigo-600"></div>
        <div class="p-3">
            <h3 class="text-gray-400 font-extrabold text-[10px] uppercase tracking-widest mb-0.5">Investimento Médio</h3>
            <div class="flex items-baseline gap-1">
                <span class="text-lg font-black text-gray-900 tracking-tight">R$ {{ number_format($custoPorHectare, 2, ',', '.') }}</span>
                <span class="text-gray-400 font-bold text-[10px]">/ ha</span>
            </div>
        </div>
    </div>
</div>

<!-- Lucratividade e Fluxo de Caixa -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Tabela/Card de Lucratividade -->
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden flex flex-col">
        <div class="w-full h-1.5 bg-emerald-500"></div>
        <div class="px-6 pt-6 pb-4 border-b border-gray-50 bg-gray-50/50">
            <h3 class="text-xs font-black text-gray-500 uppercase tracking-widest flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                Lucratividade por Safra
            </h3>
        </div>
        
        <!-- Table View -->
        <div class="overflow-x-auto overflow-y-auto w-full max-h-[300px]">
            <table class="w-full text-left border-collapse">
                <thead class="sticky top-0 bg-white shadow-sm z-10">
                    <tr class="bg-white border-b border-gray-100 text-[10px] uppercase tracking-tighter text-gray-400 font-black">
                        <th class="px-6 py-4">Safra</th>
                        <th class="px-6 py-4 text-right">Resultado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm bg-white">
                    @forelse ($relatorioLucroPorSafra as $safra)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <span class="text-gray-900 font-extrabold block text-sm">{{ $safra->cultura }}</span>
                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ \Carbon\Carbon::parse($safra->data_inicio)->format('d/m/y') }} @if($safra->data_fim) - {{ \Carbon\Carbon::parse($safra->data_fim)->format('d/m/y') }} @endif</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex flex-col items-end">
                                <span class="text-[15px] font-black {{ ($safra->lucro ?? 0) >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                    R$ {{ number_format($safra->lucro ?? 0, 2, ',', '.') }}
                                </span>
                                <span class="text-[10px] text-gray-500 font-semibold mt-0.5">Entradas: R$ {{ number_format($safra->receitas ?? 0, 2, ',', '.') }}</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="px-6 py-12 text-center text-gray-400 text-xs font-medium">Sem dados consolidados para safras.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Fluxo de Caixa -->
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden flex flex-col">
        <div class="w-full h-1.5 bg-indigo-500"></div>
        <div class="px-6 pt-6 pb-3 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
            <h3 class="text-xs font-black text-gray-500 uppercase tracking-widest">Fluxo de Caixa Mensal</h3>
        </div>
        <div class="px-6 pb-6 pt-0 min-h-[320px] flex items-center justify-center">
            @if($fluxoLabels->isEmpty())
                <p class="text-gray-400 font-medium text-sm italic text-center">Dados insuficientes para fluxo de caixa.</p>
            @else
                <canvas id="cashFlowChart" class="max-h-[320px] w-full"></canvas>
            @endif
        </div>
    </div>
</div>

<!-- Gráficos de Base -->
<div class="mb-8">
    <!-- Distribuição de Custos -->
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden flex flex-col">
        <div class="w-full h-1 bg-amber-500"></div>
        <div class="px-6 pt-6 pb-4 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
            <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Estrutura de Gastos</h3>
            @if(isset($custosData) && collect($custosData)->sum() > 0)
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total:</span>
                    <span class="text-lg font-black text-rose-500 bg-rose-50 px-4 py-1.5 rounded-lg shadow-sm border border-rose-100">
                        R$ {{ number_format(collect($custosData)->sum(), 2, ',', '.') }}
                    </span>
                </div>
            @endif
        </div>
        <div class="p-6 flex justify-center items-center overflow-x-auto w-full">
            @if($custosLabels->isEmpty())
                <p class="text-gray-400 font-medium text-sm italic text-center min-h-[300px] flex items-center">Nenhum custo registrado para análise.</p>
            @else
                <div class="w-full" style="min-height: {{ max(300, count($custosLabels) * 35) }}px; height: {{ count($custosLabels) * 35 }}px;">
                    <canvas id="costDistributionChart" class="w-full h-full"></canvas>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        Chart.register(ChartDataLabels); 

        @if(isset($custosLabels) && $custosLabels->isNotEmpty())
            const ctxCost = document.getElementById('costDistributionChart').getContext('2d');
            const labelsCost = @json($custosLabels);
            const dataCost = @json($custosData);

            new Chart(ctxCost, {
                type: 'bar',
                data: {
                    labels: labelsCost,
                    datasets: [{
                        label: 'Distribuição de Custos',
                        data: dataCost,
                        backgroundColor: [
                            'rgba(244, 63, 94, 0.85)',   // rose-500
                            'rgba(245, 158, 11, 0.85)',  // amber-500
                            'rgba(59, 130, 246, 0.85)',  // blue-500
                            'rgba(16, 185, 129, 0.85)',  // emerald-500
                            'rgba(217, 70, 239, 0.85)',  // fuchsia-500
                            'rgba(99, 102, 241, 0.85)',  // indigo-500
                            'rgba(14, 165, 233, 0.85)',  // sky-500
                            'rgba(236, 72, 153, 0.85)',  // pink-500
                            'rgba(139, 92, 246, 0.85)'   // violet-500
                        ],
                        borderRadius: 6, // slightly more rounded for thinner bars
                        barPercentage: 0.45, // Thinner bars
                        categoryPercentage: 0.6 // Tighter grouping
                    }]
                },
                options: { 
                    indexAxis: 'y',
                    responsive: true, 
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { 
                            display: false 
                        },
                        datalabels: {
                            labels: {
                                currency: {
                                    anchor: 'end',
                                    align: 'right',
                                    color: '#6b7280', // gray-500
                                    font: { weight: '800', size: 12, family: "'Inter', sans-serif" },
                                    formatter: (value) => {
                                        return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(parseFloat(value));
                                    },
                                    offset: 4,
                                    padding: { left: 4, right: 0 }
                                },
                                percentage: {
                                    anchor: 'end',
                                    align: 'right',
                                    color: '#f43f5e', // rose-500
                                    font: { weight: '800', size: 12, family: "'Inter', sans-serif" },
                                    formatter: (value, context) => {
                                        const sum = context.chart.data.datasets[0].data.reduce((a, b) => parseFloat(a) + parseFloat(b), 0);
                                        return sum === 0 ? '(0%)' : '(' + (parseFloat(value) * 100 / sum).toFixed(1) + '%)';
                                    },
                                    offset: (context) => {
                                        // Calculate exact pixel width of the currency text to perfectly position the percentage right after it
                                        const val = parseFloat(context.dataset.data[context.dataIndex]);
                                        const text = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(val);
                                        context.chart.ctx.font = "800 12px 'Inter', sans-serif";
                                        const textWidth = context.chart.ctx.measureText(text).width;
                                        // currency offset(4) + currency left padding(4) + textWidth + gap(4)
                                        return 4 + 4 + textWidth + 4;
                                    },
                                    padding: { left: 0 }
                                }
                            }
                        },
                        tooltip: {
                            titleFont: { family: "'Inter', sans-serif" },
                            bodyFont: { family: "'Inter', sans-serif" },
                            callbacks: {
                                label: function(context) {
                                    let label = 'Custo: ';
                                    if (context.parsed.x !== null) {
                                        label += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(context.parsed.x);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            display: false, // Hide X axis
                            grid: { display: false }
                        },
                        y: {
                            grid: { display: false, drawBorder: false },
                            ticks: {
                                font: { family: "'Inter', sans-serif", size: 12, weight: '500' },
                                color: '#4b5563'
                            }
                        }
                    },
                    layout: {
                        padding: { right: 140 } // Prevent cutoff of data labels
                    }
                }
            });
        @endif

        @if(isset($fluxoLabels) && $fluxoLabels->isNotEmpty())
            const ctxFlow = document.getElementById('cashFlowChart').getContext('2d');
            
            new Chart(ctxFlow, {
                type: 'line',
                data: {
                    labels: @json($fluxoLabels),
                    datasets: [
                        {
                            label: 'Receitas',
                            data: @json($fluxoReceitas),
                            borderColor: '#10b981', // emerald-500
                            backgroundColor: '#10b981',
                            fill: false,
                            tension: 0.45,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#10b981',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            borderWidth: 3
                        },
                        {
                            label: 'Despesas',
                            data: @json($fluxoDespesas),
                            borderColor: '#f43f5e', // rose-500
                            backgroundColor: '#f43f5e',
                            fill: false,
                            tension: 0.45,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#f43f5e',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            borderWidth: 3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: { 
                            position: 'top', 
                            align: 'center',
                            labels: { 
                                font: { family: "'Inter', sans-serif" }, 
                                usePointStyle: true,
                                boxWidth: 8,
                                padding: 10 // Pushes legend items UP by reducing vertical padding inside the legend box
                            },
                        },
                        
                        tooltip: {
                            titleFont: { family: "'Inter', sans-serif" },
                            bodyFont: { family: "'Inter', sans-serif" },
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) { label += ': '; }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        },

                        datalabels: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f3f4f6',
                                drawBorder: false,
                            },
                            ticks: {
                                font: { family: "'Inter', sans-serif", size: 11 },
                                color: '#6b7280'
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                font: { family: "'Inter', sans-serif", size: 11 },
                                color: '#6b7280'
                            }
                        }
                    },
                    layout: {
                        padding: {
                            top: 25 // Reduced from 40 to bring lines a bit up, while keeping enough gap from legend
                        }
                    }
                }
            });
        @endif

    });
</script>
@endsection
