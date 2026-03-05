@extends('layouts.app')

@section('header_title', 'Painel de Relatórios Gerenciais')

@section('content')

<div class="mb-8">
    <p class="text-sm text-gray-500 font-medium">Visualize o desempenho financeiro e operacional consolidado de suas safras.</p>
</div>

<!-- KPIs e Gráficos de Topo -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- KPI Custo por Hectare -->
    <div class="lg:col-span-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6 relative overflow-hidden group h-full">
        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-indigo-600"></div>
        <div class="relative z-10 flex flex-col h-full">
            <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center mb-4 backdrop-blur-md shadow-sm border border-indigo-100 group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-gray-400 font-black text-[9px] uppercase tracking-[0.2em] mb-1">Investimento Médio</h3>
            <div class="flex items-baseline flex-wrap gap-1">
                <span class="text-2xl md:text-3xl font-black text-gray-900 tracking-tight">R$ {{ number_format($custoPorHectare, 2, ',', '.') }}</span>
                <span class="text-gray-400 font-bold text-xs">/ ha</span>
            </div>
            <p class="text-gray-400 mt-4 text-[10px] font-semibold leading-tight">
                Custo total por área plantada.
            </p>
        </div>
    </div>

    <!-- Distribuição de Custos -->
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col relative">
        <div class="absolute inset-x-0 top-0 h-1 bg-amber-500"></div>
        <div class="p-5 border-b border-gray-50 flex items-center justify-between">
            <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest">Estrutura de Gastos</h3>
        </div>
        <div class="p-6 flex-1 flex justify-center items-center h-[220px]">
            @if($custosLabels->isEmpty())
                <p class="text-gray-400 font-medium text-sm italic text-center">Nenhum custo registrado para análise.</p>
            @else
                <canvas id="costDistributionChart" class="max-h-[220px]"></canvas>
            @endif
        </div>
    </div>
</div>

<!-- Lucratividade e Fluxo de Caixa -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Tabela/Card de Lucratividade -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative">
        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-emerald-500"></div>
        <div class="p-5 border-b border-gray-50 bg-gray-50/30">
            <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                Lucratividade por Safra
            </h3>
        </div>
        
        <!-- Desktop View -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100 text-[10px] uppercase tracking-tighter text-gray-500 font-black">
                        <th class="px-6 py-4">Safra</th>
                        <th class="px-6 py-4 text-right">Resultado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse ($relatorioLucroPorSafra as $safra)
                    <tr class="hover:bg-gray-50/30 transition-colors group">
                        <td class="px-6 py-4">
                            <span class="text-gray-900 font-bold block">{{ $safra->cultura }}</span>
                            <span class="text-[10px] text-gray-400 font-bold uppercase">{{ \Carbon\Carbon::parse($safra->data_inicio)->format('d/m/y') }} @if($safra->data_fim) - {{ \Carbon\Carbon::parse($safra->data_fim)->format('d/m/y') }} @endif</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex flex-col items-end">
                                <span class="font-black {{ ($safra->lucro ?? 0) >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                    R$ {{ number_format($safra->lucro ?? 0, 2, ',', '.') }}
                                </span>
                                <span class="text-[10px] text-gray-400">R$ {{ number_format($safra->receitas ?? 0, 2, ',', '.') }} rec.</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="px-6 py-12 text-center text-gray-400 text-xs italic font-medium">Sem dados consolidadores.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile View (Cards) -->
        <div class="md:hidden flex flex-col divide-y divide-gray-50">
            @forelse ($relatorioLucroPorSafra as $safra)
            <div class="p-4 flex flex-col gap-3">
                <div class="flex justify-between items-center mb-1">
                    <div>
                        <h4 class="font-black text-gray-900 text-xs tracking-tight leading-none mb-1">{{ $safra->cultura }}</h4>
                        <div class="flex items-center gap-2">
                            <span class="text-[9px] text-gray-400 font-bold uppercase">{{ \Carbon\Carbon::parse($safra->data_inicio)->year }}</span>
                            @if(!$safra->data_fim)
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            <span class="text-[8px] text-emerald-600 font-black uppercase tracking-tighter">Ativa</span>
                            @endif
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-[7px] text-gray-400 font-black uppercase mb-0.5 tracking-widest">Resultado</div>
                        <span class="text-[11px] font-black {{ ($safra->lucro ?? 0) >= 0 ? 'text-emerald-600 bg-emerald-50/50' : 'text-rose-600 bg-rose-50/50' }} px-3 py-1 rounded-full border border-current/5">
                            R$ {{ number_format($safra->lucro ?? 0, 2, ',', '.') }}
                        </span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div class="bg-gray-50/50 p-2.5 rounded-xl border border-gray-100/50 flex flex-col">
                        <span class="text-[7px] text-gray-400 font-black uppercase tracking-widest mb-1">Entradas</span>
                        <span class="text-[10px] font-bold text-gray-900">R$ {{ number_format($safra->receitas ?? 0, 2, ',', '.') }}</span>
                    </div>
                    <div class="bg-gray-50/50 p-2.5 rounded-xl border border-gray-100/50 flex flex-col">
                        <span class="text-[7px] text-gray-400 font-black uppercase tracking-widest mb-1">Saídas</span>
                        <span class="text-[10px] font-bold text-gray-900">R$ {{ number_format($safra->despesas ?? 0, 2, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-gray-400 text-xs italic font-medium">Sem dados consolidadores.</div>
            @endforelse
        </div>
    </div>

    <!-- Fluxo de Caixa -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col relative">
        <div class="absolute inset-x-0 top-0 h-1 bg-indigo-500"></div>
        <div class="p-5 border-b border-gray-50 flex items-center justify-between">
            <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest">Fluxo de Caixa Mensal</h3>
        </div>
        <div class="p-6 min-h-[300px] flex items-center justify-center">
            @if($fluxoLabels->isEmpty())
                <p class="text-gray-400 font-medium text-sm italic text-center">Dados insuficientes para fluxo de caixa.</p>
            @else
                <canvas id="cashFlowChart" class="max-h-[300px]"></canvas>
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
                        legend: { 
                            position: 'bottom', 
                            labels: { 
                                padding: 20,
                                font: { family: "'Inter', sans-serif", size: 11, weight: '600' },
                                usePointStyle: true,
                                boxWidth: 8
                            } 
                        },
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
