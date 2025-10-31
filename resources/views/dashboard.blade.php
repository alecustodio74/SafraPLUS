@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class="mb-4">Olá, {{ Auth::user()->name }}!</h1>
            <p class="lead">Bem-vindo(a) ao seu painel de gestão. Aqui está um resumo rápido das suas finanças.</p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Receitas Totais</h5>
                    <p class="card-text h3">R$ {{ number_format($totalReceitas, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Despesas Totais</h5>
                    <p class="card-text h3">R$ {{ number_format($totalDespesas, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Saldo Atual</h5>
                    <p class="card-text h3">R$ {{ number_format($saldoAtual, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4>Safras Mais Recentes</h4>
                </div>
                <div class="card-body">
                    @if ($safrasRecentes->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach ($safrasRecentes as $safra)
                                <li class="list-group-item">
                                    <strong>{{ $safra->cultura }}</strong> ({{ \Carbon\Carbon::parse($safra->data_inicio)->format('d/m/Y') }} até {{ $safra->data_fim ? \Carbon\Carbon::parse($safra->data_fim)->format('d/m/Y') : 'Em andamento' }})
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-center">Nenhuma safra registrada ainda.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection