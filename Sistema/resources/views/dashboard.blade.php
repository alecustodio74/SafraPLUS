@extends('layouts.app')

@section('header_title', 'Dashboard')

@section('content')

<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Visão Geral</h2>
        <p class="text-sm text-gray-500 mt-1">Acompanhe as principais métricas e finanças da sua propriedade.</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('relatorios.index') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-50 transition-colors shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Exportar
        </a>
        <a href="{{ route('lancamentos-financeiros.index') }}" class="px-4 py-2 bg-[#059669] border border-[#059669] text-white rounded-lg text-sm font-semibold hover:bg-[#047857] hover:border-[#047857] transition-colors shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Novo Lançamento
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Receitas Totais -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between h-40 relative overflow-hidden group hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Receitas Totais</h3>
                <p class="text-3xl font-bold text-gray-900">R$ {{ number_format($totalReceitas, 2, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center text-green-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
            </div>
        </div>
        <p class="text-xs text-gray-400 font-medium z-10">Baseado em todos os lançamentos</p>
    </div>

    <!-- Despesas Totais -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between h-40 relative overflow-hidden group hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Despesas Totais</h3>
                <p class="text-3xl font-bold text-gray-900">R$ {{ number_format($totalDespesas, 2, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center text-red-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
            </div>
        </div>
        <p class="text-xs text-gray-400 font-medium z-10">Baseado em todos os lançamentos</p>
    </div>

    <!-- Saldo Atual -->
    <div class="bg-[#059669] rounded-2xl p-6 shadow-md border border-[#047857] flex flex-col justify-between h-40 relative overflow-hidden text-white group hover:bg-[#047857] transition-colors">
        <!-- background icon element -->
        <div class="absolute -right-4 -bottom-6 opacity-10 transform group-hover:scale-110 transition-transform duration-500">
            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-1.1c-1.28-.27-2.31-1.09-2.73-2.38l1.83-.76c.25.79.91 1.24 1.9 1.24 1.15 0 1.83-.62 1.83-1.42 0-1.07-.94-1.39-2.58-1.88-1.93-.57-3.14-1.63-3.14-3.41 0-1.52 1.11-2.72 2.72-3.08V4h2v1.16c1.13.26 2 .99 2.45 2.15l-1.8.77c-.24-.69-.79-1.12-1.65-1.12-1 0-1.64.57-1.64 1.34 0 1.05.97 1.32 2.68 1.86 1.96.6 3.09 1.7 3.09 3.44 0 1.63-1.23 2.76-2.91 3.11V17z"/></svg>
        </div>
        <div class="relative z-10 flex justify-between items-start">
            <div>
                <h3 class="text-xs font-bold text-emerald-100 uppercase tracking-wider mb-2">Saldo Atual</h3>
                <p class="text-3xl font-bold">R$ {{ number_format($saldoAtual, 2, ',', '.') }}</p>
            </div>
        </div>
        <p class="text-xs text-emerald-100 font-medium relative z-10">Total consolidado em caixa</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Componente provisório para o gráfico (Fluxo Financeiro Recente) -->
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-6">Fluxo Financeiro Recente (Últimos 6 Meses)</h3>
        <div class="flex-1 w-full flex items-end relative min-h-[250px] mt-4">
             <canvas id="financeChart" class="w-full h-full"></canvas>
        </div>
    </div>

    <!-- Safras Recentes -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-gray-900">Safras Recentes</h3>
            <a href="{{ route('safras.index') }}" class="text-sm font-semibold text-[#059669] hover:text-[#047857]">Ver todas</a>
        </div>
        
        <div class="flex-1 flex flex-col justify-center">
            @if ($safrasRecentes->count() > 0)
                <ul class="space-y-3">
                    @foreach ($safrasRecentes as $safra)
                        <li class="flex items-center gap-4 p-3 rounded-xl bg-gray-50 border border-gray-100 hover:border-gray-200 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-green-100 text-[#059669] flex items-center justify-center font-bold text-sm">
                                {{ substr($safra->cultura, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-bold text-gray-900">{{ $safra->cultura }}</h4>
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($safra->data_inicio)->format('d/m/Y') }} até {{ $safra->data_fim ? \Carbon\Carbon::parse($safra->data_fim)->format('d/m/Y') : 'Em andamento' }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="flex flex-col items-center justify-center text-center py-8">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-900 mb-1">Nenhuma safra registrada</p>
                    <p class="text-xs text-gray-500">Comece cadastrando sua primeira safra.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('financeChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Out/2025', 'Nov/2025', 'Dez/2025', 'Jan/2026', 'Fev/2026', 'Mar/2026'],
                    datasets: [
                        {
                            label: 'Receitas',
                            data: [0, 0, 0, 0, 0, 0],
                            backgroundColor: '#34d399',
                            borderRadius: 4,
                            barPercentage: 0.6,
                            categoryPercentage: 0.8
                        },
                        {
                            label: 'Despesas',
                            data: [0, 0, 0, 0, 0, 0],
                            backgroundColor: '#f87171',
                            borderRadius: 4,
                            barPercentage: 0.6,
                            categoryPercentage: 0.8
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                boxWidth: 8,
                                font: {
                                    family: "'figtree', sans-serif",
                                    size: 12
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
                                color: '#f3f4f6'
                            },
                            border: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    family: "'figtree', sans-serif",
                                    size: 11
                                },
                                color: '#9ca3af'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            border: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    family: "'figtree', sans-serif",
                                    size: 11
                                },
                                color: '#6b7280'
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endsection