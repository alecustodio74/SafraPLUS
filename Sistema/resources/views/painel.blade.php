@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-display font-bold text-slate-800">Visão Geral</h1>
            <p class="text-slate-500 mt-1">Acompanhe as principais métricas e finanças da sua propriedade.</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="bg-white px-4 py-2 text-sm font-medium text-slate-600 rounded-lg shadow-sm border border-slate-200 hover:bg-slate-50 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                Exportar
            </button>
            <a href="{{ route('lancamentos-financeiros.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 text-sm font-medium rounded-lg shadow-md shadow-primary-500/30 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Novo Lançamento
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Receitas -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col justify-between relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Receitas Totais</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-2">R$ {{ number_format($receitasTotais ?? 0, 2, ',', '.') }}</h3>
                </div>
                <div class="p-3 bg-green-100 text-green-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
            </div>
            <div class="flex items-center text-sm font-medium text-green-600 relative z-10">
                <span class="text-slate-400 font-normal">Baseado em todos os lançamentos</span>
            </div>
        </div>

        <!-- Despesas -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col justify-between relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-red-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Despesas Totais</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-2">R$ {{ number_format($despesasTotais ?? 0, 2, ',', '.') }}</h3>
                </div>
                <div class="p-3 bg-red-100 text-red-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                </div>
            </div>
            <div class="flex items-center text-sm font-medium text-red-600 relative z-10">
                <span class="text-slate-400 font-normal">Baseado em todos os lançamentos</span>
            </div>
        </div>

        <!-- Saldo -->
        <div class="bg-gradient-to-br from-primary-500 to-primary-700 rounded-2xl p-6 shadow-lg shadow-primary-500/30 text-white flex flex-col justify-between relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-20 group-hover:opacity-40 transition-opacity">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5H10.9v1.69c-1.51.32-2.72 1.3-2.72 2.81 0 1.79 1.49 2.69 3.66 3.21 1.95.46 2.34 1.15 2.34 1.87 0 .53-.39 1.64-2.25 1.64-1.74 0-2.1-.96-2.15-1.92H8.01c.06 1.7 1.15 2.82 2.89 3.26V19h2.33v-1.68c1.64-.32 2.76-1.32 2.76-2.92 0-2.06-1.64-2.78-3.68-3.26z"/></svg>
            </div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div>
                    <p class="text-sm font-medium text-primary-100 uppercase tracking-wide">Saldo Atual</p>
                    <h3 class="text-4xl font-bold mt-2">R$ {{ number_format($saldoAtual ?? 0, 2, ',', '.') }}</h3>
                </div>
            </div>
            <div class="text-sm font-medium text-primary-50 relative z-10 mt-auto pt-4">
                Total consolidado em caixa
            </div>
        </div>

    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Card Gráfico / Extrato -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col">
            <h3 class="text-lg font-bold text-slate-800 mb-4 h-header">Fluxo Financeiro Recente (Últimos 6 Meses)</h3>
            <div class="flex-1 w-full min-h-[300px]">
                @if($mesesLabels->isEmpty())
                    <div class="h-full flex items-center justify-center bg-slate-50 rounded-xl border border-slate-100">
                        <p class="text-slate-400 font-medium">Nenhum dado financeiro para exibir o gráfico.</p>
                    </div>
                @else
                    <canvas id="dashboardCashFlowChart"></canvas>
                @endif
            </div>
        </div>

        <!-- Safras Recentes -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-slate-800">Safras Recentes</h3>
                <a href="{{ route('safras.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-700">Ver todas</a>
            </div>
            
            <div class="space-y-4">
                @forelse ($safrasRecentes as $safra)
                    <div class="flex items-start gap-4 p-3 rounded-xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100">
                        <div class="w-10 h-10 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-800">{{ $safra->cultura }}</h4>
                            <p class="text-xs text-slate-500 mt-0.5">
                                {{ \Carbon\Carbon::parse($safra->data_inicio)->format('d/m/y') }} 
                                &rarr; 
                                {{ $safra->data_fim ? \Carbon\Carbon::parse($safra->data_fim)->format('d/m/y') : 'Em andamento' }}
                            </p>
                            @if(!$safra->data_fim)
                                <span class="inline-block mt-1.5 px-2 py-0.5 text-[10px] font-medium bg-green-100 text-green-700 rounded-full">Ativa</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        </div>
                        <p class="text-sm font-medium text-slate-600">Nenhuma safra registrada</p>
                        <p class="text-xs text-slate-500 mt-1">Comece cadastrando sua primeira safra.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(isset($mesesLabels) && $mesesLabels->isNotEmpty())
            const ctxDashboardFlow = document.getElementById('dashboardCashFlowChart').getContext('2d');
            
            new Chart(ctxDashboardFlow, {
                type: 'bar',
                data: {
                    labels: @json($mesesLabels),
                    datasets: [
                        {
                            label: 'Receitas',
                            data: @json($dadosReceitas),
                            backgroundColor: 'rgba(40, 167, 69, 0.8)',
                            borderRadius: 4,
                        },
                        {
                            label: 'Despesas',
                            data: @json($dadosDespesas),
                            backgroundColor: 'rgba(220, 53, 69, 0.8)',
                            borderRadius: 4,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
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