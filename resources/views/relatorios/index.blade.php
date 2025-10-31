@extends('layouts.app')

@section('content')
<div class="container my-3">
    <div class="row justify-content-center">
        <div class="col-md-11">

            <div class="card shadow-sm mb-4">
                <div class="card-header text-center bg-success text-white">
                    <h1 class="mb-0 h3 fw-bold">Painel de Relatórios Gerenciais</h1>
                </div>
                <div class="card-body">
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-success fw-bold">Distribuição de Custos por Categoria</h5>
                            <div class="card p-3 shadow-sm">
                                @if($relatorioDistribuicaoCustos->isEmpty())
                                    <p class="text-muted text-center">Não há custos registrados para gerar o gráfico.</p>
                                @else
                                    <canvas id="costDistributionChart" height="200"></canvas>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-success fw-bold">Análise de Custo por Hectare (KPI)</h5>
                            <div class="card p-3 shadow-sm text-center">
                                {{-- Este dado precisa ser calculado no Controller --}}
                                <h3 class="display-6 fw-bold text-info">R$ {{ number_format(0, 2, ',', '.') }} / ha</h3>
                                <p class="text-muted">Custo Total / Área Plantada Total</p>
                            </div>
                            
                            <h5 class="text-success fw-bold mt-3">Relatório de Fluxo de Caixa (RF_S3)</h5>
                            <div class="card p-3 shadow-sm">
                                <p class="text-muted text-center">Filtros por data/safra viriam aqui.</p>
                                <canvas id="cashFlowChart" height="150"></canvas>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <h4 class="text-center mb-3 text-success fw-bold">Lucratividade Consolidada por Safra (RF_S1)</h4>
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
                                    <td>{{ $safra->cultura }} ({{ $safra->data_inicio }} - {{ $safra->data_fim ?? 'Em andamento' }})</td>
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
                        <a href="{{ route('painel') }}" class="btn btn-secondary mt-3">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection