@extends('layouts.app')

@section('content')
<div class="container my-3 py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-success text-white">
                    <h1 class="mb-0 h2 fw-bold">Painel de Gestão</h1>
                </div>
                <div class="card-body">
                    <p class="lead text-center text-muted">Bem-vindo ao seu painel. Aqui está um resumo rápido das suas finanças.</p>

                    <div class="row mt-1 g-4 justify-content-center">
                        <div class="col-lg-4 col-md-6">
                            <div class="card card-custom text-white card-success">
                                <div class="card-body p-4">
                                    <h5 class="card-title">Receitas Totais</h5>
                                    <p class="card-text h3">R$ {{ number_format($receitasTotais ?? 0, 2, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="card card-custom text-white card-danger">
                                <div class="card-body p-4">
                                    <h5 class="card-title">Despesas Totais</h5>
                                    <p class="card-text h3">R$ {{ number_format($despesasTotais ?? 0, 2, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="card card-custom text-white card-info">
                                <div class="card-body p-4">
                                    <h5 class="card-title">Saldo Atual</h5>
                                    <p class="card-text h3">R$ {{ number_format($saldoAtual ?? 0, 2, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-5">

                    <div>
                        <h4 class="mb-3 text-center">Safras Mais Recentes</h4>
                        <ul class="list-group list-group-flush">
                            @forelse ($safrasRecentes as $safra)
                                <li class="list-group-item">
                                    <strong>{{ $safra->cultura }}</strong> ({{ \Carbon\Carbon::parse($safra->data_inicio)->format('d/m/Y') }} até {{ $safra->data_fim ? \Carbon\Carbon::parse($safra->data_fim)->format('d/m/Y') : 'Em andamento' }})
                                </li>
                            @empty
                                <li class="list-group-item text-center text-muted">Nenhuma safra registrada ainda.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection