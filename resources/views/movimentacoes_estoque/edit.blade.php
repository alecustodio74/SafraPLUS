@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-custom">
                <div class="card-header bg-success text-white text-center fw-bold fs-4">
                    Editar Movimentação de Estoque
                </div>

                <div class="card-body">

                    @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                    @endif

                    <form action="{{ route('movimentacoes-estoque.update', $movimentacao->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="tipo_movimentacao" class="form-label">Tipo de Movimentação</label>
                            <select name="tipo_movimentacao" id="tipo_movimentacao" class="form-select" required>
                                <option value="entrada" {{ $movimentacao->tipo_movimentacao == 'entrada' ? 'selected' : '' }}>Entrada por Compra</option>
                                <option value="saida" {{ $movimentacao->tipo_movimentacao == 'saida' ? 'selected' : '' }}>Saída para Uso</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="insumo_id" class="form-label">Insumo</label>
                            <select name="insumo_id" id="insumo_id" class="form-select" required>
                                <option value="">Selecione um insumo</option>
                                @foreach($insumos as $insumo)
                                <option value="{{ $insumo->id }}" {{ $movimentacao->insumo_id == $insumo->id ? 'selected' : '' }}>
                                    {{ $insumo->nome }} (Estoque: {{ $insumo->estoque_atual }})
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="quantidade" class="form-label">Quantidade</label>
                            <input type="number" step="0.01" name="quantidade" id="quantidade" class="form-control" value="{{ $movimentacao->quantidade }}" required>
                        </div>

                        <div class="mb-3" id="valor_unitario_wrapper" style="display: none;">
                            <label for="valor_unitario" class="form-label">Valor Unitário (Obrigatório p/ Entrada)</label>
                            <input type="number" step="0.01" name="valor_unitario" id="valor_unitario" class="form-control" value="{{ $movimentacao->valor_unitario }}">
                        </div>

                        <div class="mb-3" id="safra_id_wrapper" style="display: none;">
                            <label for="safra_id" class="form-label">Associar Saída à Safra (Obrigatório p/ Saída)</label>
                            <select name="safra_id" id="safra_id" class="form-select">
                                <option value="">Nenhuma</option>
                                @foreach($safras as $safra)
                                <option value="{{ $safra->id }}" {{ $movimentacao->safra_id == $safra->id ? 'selected' : '' }}>
                                    {{ $safra->cultura }} (Início: {{ $safra->data_inicio }})
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="data_movimentacao" class="form-label">Data da Movimentação</label>
                            <input type="date" name="data_movimentacao" id="data_movimentacao" class="form-control @error('data_movimentacao') is-invalid @enderror" value="{{ $movimentacao->data_movimentacao ?? date('Y-m-d') }}" required>
                            @error('data_movimentacao')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('movimentacoes-estoque.index') }}" class="btn btn-secondary">Voltar</a>
                            <button type="submit" class="btn btn-success">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const tipoMovimentacao = document.getElementById('tipo_movimentacao');
        const valorUnitarioWrapper = document.getElementById('valor_unitario_wrapper');
        const safraIdWrapper = document.getElementById('safra_id_wrapper');
        const valorUnitarioInput = document.getElementById('valor_unitario');
        const safraIdInput = document.getElementById('safra_id');

        function toggleFields() {
            const tipo = tipoMovimentacao.value;

            if (tipo === 'entrada') {
                valorUnitarioWrapper.style.display = 'block';
                safraIdWrapper.style.display = 'none';
                valorUnitarioInput.required = true;
                safraIdInput.required = false;
            } else if (tipo === 'saida') {
                valorUnitarioWrapper.style.display = 'none';
                safraIdWrapper.style.display = 'block';
                valorUnitarioInput.required = false;
                safraIdInput.required = true;
            } else {
                valorUnitarioWrapper.style.display = 'none';
                safraIdWrapper.style.display = 'none';
                valorUnitarioInput.required = false;
                safraIdInput.required = false;
            }
        }
        tipoMovimentacao.addEventListener('change', toggleFields);

        toggleFields();
    });
</script>
@endsection