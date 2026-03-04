@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-display font-bold text-slate-800">Painel de Relatórios Gerenciais</h1>
            <p class="text-slate-500 mt-1">
                Acompanhe o desempenho financeiro e os custos das suas operações.
                {{ Auth::user()->role == 'admin' ? '(Dados de todos os produtores)' : '' }}
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('painel') }}" class="text-sm font-medium text-slate-600 bg-white px-4 py-2 rounded-lg border border-slate-200 shadow-sm hover:bg-slate-50 transition-colors">
                Voltar ao Painel
            </a>
        </div>
    </div>

    <!-- Charts Layout (Top) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Cost Distribution -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col">
            <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                Distribuição de Custos por Categoria
            </h3>
            
            <div class="flex-1 flex items-center justify-center">
                @if($custosLabels->isEmpty())
                    <p class="text-slate-500 text-center py-10">Não há custos registrados para gerar o gráfico.</p>
                @else
                    <div class="w-full max-w-sm mx-auto">
                        <canvas id="costDistributionChart"></canvas>
                    </div>
                @endif
            </div>
        </div>

        <div class="flex flex-col gap-6">
            <!-- KPI -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex items-center gap-6 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-32 h-32 bg-blue-500/10 rounded-full blur-3xl -mr-10 -mt-10"></div>
                <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <div class="relative z-10">
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Custo Médio por Hectare</p>
                    <h3 class="text-3xl font-display font-bold text-slate-800">R$ {{ number_format($custoPorHectare, 2, ',', '.') }}</h3>
                </div>
            </div>

            <!-- Cash Flow Chart -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex-1 flex flex-col">
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                    Relatório de Fluxo de Caixa
                </h3>
                
                <div class="flex-1 w-full min-h-[200px]">
                    @if($fluxoLabels->isEmpty())
                        <p class="text-slate-500 text-center py-10">Não há lançamentos para gerar o fluxo de caixa.</p>
                    @else
                        <canvas id="cashFlowChart"></canvas>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <!-- Lucratividade por Safra (Bottom) -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden relative mt-6">
        <div class="absolute top-0 left-0 w-2 h-full bg-emerald-500"></div>
        <div class="p-6 border-b border-slate-100">
            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Lucratividade Consolidada por Safra
            </h3>
        </div>
        <div class="overflow-x-auto pl-2">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-slate-50 border-y border-slate-100 text-sm font-semibold text-slate-600">
                        <th class="py-4 px-6">Safra</th>
                        <th class="py-4 px-6 text-right">Receitas Totais</th>
                        <th class="py-4 px-6 text-right">Despesas Totais</th>
                        <th class="py-4 px-6 text-right">Lucro / Prejuízo</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($relatorioLucroPorSafra as $safra)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-4 px-6">
                            <div class="font-medium text-slate-800">{{ $safra->cultura }}</div>
                            <div class="text-xs text-slate-500 mt-1">
                                {{ \Carbon\Carbon::parse($safra->data_inicio)->format('d/m/Y') }} - {{ $safra->data_fim ? \Carbon\Carbon::parse($safra->data_fim)->format('d/m/Y') : 'Em andamento' }}
                            </div>
                        </td>
                        <td class="py-4 px-6 text-right font-medium text-emerald-600">
                            R$ {{ number_format($safra->receitas ?? 0, 2, ',', '.') }}
                        </td>
                        <td class="py-4 px-6 text-right text-slate-600">
                            R$ {{ number_format($safra->despesas ?? 0, 2, ',', '.') }}
                        </td>
                        <td class="py-4 px-6 text-right font-bold {{ ($safra->lucro ?? 0) >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                            <div class="flex items-center justify-end gap-1">
                                @if(($safra->lucro ?? 0) >= 0)
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                                @endif
                                R$ {{ number_format($safra->lucro ?? 0, 2, ',', '.') }}
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-slate-500">
                            Nenhum dado financeiro encontrado para as safras.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
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
                            'rgba(220, 53, 69, 0.8)',
                            'rgba(255, 193, 7, 0.8)',
                            'rgba(0, 123, 255, 0.8)',
                            'rgba(40, 167, 69, 0.8)',
                            'rgba(108, 117, 125, 0.8)',
                        ],
                        borderColor: '#fff',
                        borderWidth: 1
                    }]
                },
                options: { 
                    responsive: true, 
                    plugins: { 
                        legend: { position: 'top' },
                        datalabels: {
                            formatter: (value, ctx) => {
                                const numericValue = parseFloat(value);
                                const sum = ctx.chart.data.datasets[0].data.reduce((a, b) => parseFloat(a) + parseFloat(b), 0);
                                if (sum === 0) return '0%';
                                const percentage = (numericValue * 100 / sum).toFixed(1) + '%';
                                return percentage;
                            },
                            color: '#fff',
                            font: { weight: 'bold', size: 14 }
                        },
                        tooltip: {
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
                            borderColor: 'rgba(40, 167, 69, 1)',
                            backgroundColor: 'rgba(40, 167, 69, 0.2)',
                            fill: true,
                            tension: 0.1
                        },
                        {
                            label: 'Despesas',
                            data: @json($fluxoDespesas),
                            borderColor: 'rgba(220, 53, 69, 1)',
                            backgroundColor: 'rgba(220, 53, 69, 0.2)',
                            fill: true,
                            tension: 0.1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' },
                        
                        tooltip: {
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
                                return context.dataset.label === 'Despesas' ? 'rgba(220, 53, 69, 1)' : 'rgba(40, 167, 69, 1)';
                            },
                            font: {
                                weight: 'bold',
                                size: 12,
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        @endif

    });
</script>
@endsection