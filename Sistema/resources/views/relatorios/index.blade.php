@extends('layouts.app')

@section('content')
<div class="container my-3 py-5">
    <div class="row justify-content-center">
        <div class="col-md-11">

            <div class="card shadow-sm mb-4">
                <div class="card-header text-center bg-success text-white">
                    <h1 class="mb-0 h3 fw-bold">Painel de Relatórios Gerenciais</h1>
                </div>
                <div class="card-body">
                    <p class="text-center text-muted">{{ Auth::user()->role == 'admin' ? 'Dados de todos os produtores.' : '' }}</p>

                    <h4 class="text-center mb-3 text-success fw-bold">Lucratividade Consolidada por Safra </h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Safra</th>
                                    <th>Receitas Totais</th>
                                    <th>Despesas Totais</th>
                                    <th>Lucro / Prejuízo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($relatorioLucroPorSafra as $safra)
                                <tr>
                                    <td>{{ $safra->cultura }} ({{ \Carbon\Carbon::parse($safra->data_inicio)->format('d/m/Y') }} - {{ $safra->data_fim ? \Carbon\Carbon::parse($safra->data_fim)->format('d/m/Y') : 'Em andamento' }})</td>
                                    <td class="text-success fw-bold">R$ {{ number_format($safra->receitas ?? 0, 2, ',', '.') }}</td>
                                    <td class="text-danger">R$ {{ number_format($safra->despesas ?? 0, 2, ',', '.') }}</td>
                                    <td class="fw-bold {{ ($safra->lucro ?? 0) >= 0 ? 'text-success' : 'text-danger' }}">
                                        R$ {{ number_format($safra->lucro ?? 0, 2, ',', '.') }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Nenhum dado financeiro encontrado para as safras.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <hr class="my-4">
                   
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-success fw-bold">Distribuição de Custos por Categoria</h5>
                            <div class="card p-3 shadow-sm">
                                @if($custosLabels->isEmpty())
                                    <p class="text-muted text-center">Não há custos registrados para gerar o gráfico.</p>
                                @else
                                    <canvas id="costDistributionChart" height="200"></canvas>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-success fw-bold">Análise de Custo por Hectare (KPI)</h5>
                            <div class="card p-3 shadow-sm text-center">
                                <h3 class="display-6 fw-bold text-info">R$ {{ number_format($custoPorHectare, 2, ',', '.') }} / ha</h3>
                                <p class="text-muted">Média de investimento por hectare plantado.</p>
                            </div>
                            
                            <h5 class="text-success fw-bold mt-3">Relatório de Fluxo de Caixa</h5>
                            <div class="card p-3 shadow-sm">
                                @if($fluxoLabels->isEmpty())
                                    <p class="text-muted text-center">Não há lançamentos para gerar o fluxo de caixa.</p>
                                @else
                                    <canvas id="cashFlowChart" height="150"></canvas>
                                @endif
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('painel') }}" class="btn btn-secondary mt-3">Voltar</a>
                </div>
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