@extends('layouts.app')

@section('header_title', 'Painel de Relatórios Gerenciais')

@section('content')

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Painel de Relatórios Gerenciais</h2>
        <p class="text-sm text-gray-500 mt-1">
            {{ Auth::user()->role == 'admin' ? 'Dados consolidados de todos os produtores.' : 'Visão detalhada do seu desempenho financeiro.' }}
        </p>
    </div>
</div>

<div class="mb-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative">
        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-fuchsia-500"></div>
        <div class="p-6 border-b border-gray-50 flex items-center justify-between gap-4">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-fuchsia-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                Lucratividade Consolidada por Safra
            </h3>
        </div>
        <div class="overflow-x-auto pl-1.5">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-bold">
                        <th class="px-6 py-4">Safra</th>
                        <th class="px-6 py-4 text-right">Receitas Totais</th>
                        <th class="px-6 py-4 text-right">Despesas Totais</th>
                        <th class="px-6 py-4 text-right">Lucro / Prejuízo</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse ($relatorioLucroPorSafra as $safra)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4 text-gray-900 font-medium">
                            {{ $safra->cultura }}
                            <span class="block text-xs text-gray-500 mt-0.5 font-normal">
                                {{ \Carbon\Carbon::parse($safra->data_inicio)->format('d/m/Y') }} - {{ $safra->data_fim ? \Carbon\Carbon::parse($safra->data_fim)->format('d/m/Y') : 'Em andamento' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right font-semibold text-emerald-600">
                            R$ {{ number_format($safra->receitas ?? 0, 2, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-right font-semibold text-rose-600">
                            R$ {{ number_format($safra->despesas ?? 0, 2, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-sm font-bold {{ ($safra->lucro ?? 0) >= 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                                R$ {{ number_format($safra->lucro ?? 0, 2, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <span class="text-sm font-medium">Nenhum dado financeiro encontrado para as safras.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Distribuição de Custos -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col relative">
        <div class="absolute inset-x-0 top-0 h-1 bg-amber-500"></div>
        <div class="p-6 border-b border-gray-50">
            <h3 class="text-lg font-bold text-gray-900">Distribuição de Custos por Categoria</h3>
        </div>
        <div class="p-6 flex-1 flex justify-center items-center min-h-[300px]">
            @if($custosLabels->isEmpty())
                <p class="text-gray-500 text-sm text-center">Não há custos registrados para gerar o gráfico.</p>
            @else
                <canvas id="costDistributionChart" class="max-h-[300px]"></canvas>
            @endif
        </div>
    </div>

    <div class="flex flex-col gap-6">
        <!-- KPI Custo por Hectare -->
        <div class="bg-gradient-to-br from-fuchsia-600 to-indigo-700 rounded-2xl shadow-sm border border-fuchsia-700 p-6 md:p-8 text-white relative overflow-hidden">
            <div class="relative z-10 flex flex-col justify-center items-center h-full text-center">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-4 backdrop-blur-sm shadow-sm border border-white/10">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-fuchsia-100 font-medium mb-1">Análise de Custo por Hectare (KPI)</h3>
                <h2 class="text-4xl md:text-5xl font-black tracking-tight drop-shadow-sm">R$ {{ number_format($custoPorHectare, 2, ',', '.') }}</h2>
                <span class="text-fuchsia-200 mt-1 font-semibold text-lg">/ ha</span>
                <p class="text-fuchsia-200 mt-4 text-sm font-medium">Média centralizada de investimento por hectare plantado.</p>
            </div>
            <!-- Decorative circle -->
            <div class="absolute -bottom-16 -right-16 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -top-16 -left-16 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
        </div>

        <!-- Fluxo de Caixa -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex-1 relative">
            <div class="absolute inset-x-0 top-0 h-1 bg-emerald-500"></div>
            <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900">Relatório de Fluxo de Caixa</h3>
            </div>
            <div class="p-6 min-h-[250px] flex items-center justify-center">
                @if($fluxoLabels->isEmpty())
                    <p class="text-gray-500 text-sm text-center">Não há lançamentos para gerar o fluxo de caixa.</p>
                @else
                    <canvas id="cashFlowChart" class="max-h-[250px]"></canvas>
                @endif
            </div>
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
                type: 'pie',
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
                        ],
                        borderColor: '#ffffff',
                        borderWidth: 2,
                        hoverOffset: 4
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { position: 'bottom', labels: { font: { family: "'Inter', sans-serif" } } },
                        datalabels: {
                            formatter: (value, ctx) => {
                                const numericValue = parseFloat(value);
                                const sum = ctx.chart.data.datasets[0].data.reduce((a, b) => parseFloat(a) + parseFloat(b), 0);
                                if (sum === 0) return '0%';
                                const percentage = (numericValue * 100 / sum).toFixed(1) + '%';
                                return percentage;
                            },
                            color: '#fff',
                            font: { weight: 'bold', size: 13, family: "'Inter', sans-serif" }
                        },
                        tooltip: {
                            titleFont: { family: "'Inter', sans-serif" },
                            bodyFont: { family: "'Inter', sans-serif" },
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed !== null) {
                                        label += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(context.parsed);
                                    }
                                    return label;
                                }
                            }
                        }
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
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            fill: true,
                            tension: 0.3,
                            pointBackgroundColor: '#10b981',
                            borderWidth: 3
                        },
                        {
                            label: 'Despesas',
                            data: @json($fluxoDespesas),
                            borderColor: '#f43f5e', // rose-500
                            backgroundColor: 'rgba(244, 63, 94, 0.1)',
                            fill: true,
                            tension: 0.3,
                            pointBackgroundColor: '#f43f5e',
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
                        legend: { position: 'top', labels: { font: { family: "'Inter', sans-serif" }, usePointStyle: true, boxWidth: 8 } },
                        
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
                            align: 'end',
                            anchor: 'end',
                            formatter: (value, ctx) => {
                                const numericValue = parseFloat(value);
                                if (numericValue === 0) {
                                    return '';
                                }
                                return new Intl.NumberFormat('pt-BR', { 
                                    notation: 'compact', 
                                    maximumFractionDigits: 1 
                                }).format(numericValue);
                            },
                            color: (context) => {
                                return context.dataset.label === 'Despesas' ? '#e11d48' : '#059669';
                            },
                            font: {
                                weight: '600',
                                size: 11,
                                family: "'Inter', sans-serif"
                            }
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
                    }
                }
            });
        @endif

    });
</script>
@endsection
