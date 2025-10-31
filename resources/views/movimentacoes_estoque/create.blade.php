@extends('layouts.app')

@section('content')
<div class="container my-3 py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-success text-white">
                    <h1 class="mb-0 h3 fw-bold">Registrar Movimentação de Estoque</h1>
                </div>
                <div class="card-body bg-light">
                    
                    {{-- CÓDIGO DE ALERTA ADICIONADO AQUI --}}
                    @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                    @endif

                    <form action="{{ route('movimentacoes-estoque.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="tipo_movimentacao" class="form-label">Tipo de Movimentação</label>
                            <select name="tipo_movimentacao" id="tipo_movimentacao" class="form-select @error('tipo_movimentacao') is-invalid @enderror" required>
                                <option value="" disabled {{ old('tipo_movimentacao') ? '' : 'selected' }}>Selecione o tipo</option>
                                <option value="entrada" {{ old('tipo_movimentacao') == 'entrada' ? 'selected' : '' }}>Entrada (Compra)</option>
                                <option value="saida" {{ old('tipo_movimentacao') == 'saida' ? 'selected' : '' }}>Saída (Uso na Safra)</option>
                            </select>
                            @error('tipo_movimentacao')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="insumo_id" class="form-label">Insumo</label>
                            <select name="insumo_id" id="insumo_id" class="form-select @error('insumo_id') is-invalid @enderror" required>
                                <option value="" disabled {{ old('insumo_id') ? '' : 'selected' }}>Selecione um Insumo</option>
                                @foreach($insumos as $insumo)
                                <option value="{{ $insumo->id }}" {{ old('insumo_id') == $insumo->id ? 'selected' : '' }}>
                                    {{-- Nomes de coluna corrigidos para bater com o Model --}}
                                    {{ $insumo->nome }} (Estoque: {{ $insumo->estoque_atual }})
                                </option>
                                @endforeach
                            </select>
                            @error('insumo_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="quantidade" class="form-label">Quantidade</label>
                            <input type="number" step="0.01" name="quantidade" id="quantidade" class="form-control @error('quantidade') is-invalid @enderror" value="{{ old('quantidade') }}" required placeholder="75">
                            @error('quantidade')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3" id="valor_unitario_wrapper" style="display: none;">
                            <label for="valor_unitario" class="form-label">Valor Unitário</label>
                            <input type="number" step="0.01" name="valor_unitario" id="valor_unitario" class="form-control @error('valor_unitario') is-invalid @enderror" value="{{ old('valor_unitario') }}" placeholder="120.00">
                            @error('valor_unitario')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3" id="safra_id_wrapper" style="display: none;">
                            <label for="safra_id" class="form-label">Safra de Destino</label>
                            <select name="safra_id" id="safra_id" class="form-select @error('safra_id') is-invalid @enderror">
                                <option value="" disabled selected>Selecione uma Safra</option>
                                @foreach($safras as $safra)
                                <option value="{{ $safra->id }}" {{ old('safra_id') == $safra->id ? 'selected' : '' }}>{{ $safra->cultura }}</option>
                                @endforeach
                            </select>
                            @error('safra_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="data_movimentacao" class="form-label">Data da Movimentação</label>
                            <input type="date" name="data_movimentacao" id="data_movimentacao" class="form-control @error('data_movimentacao') is-invalid @enderror" value="{{ old('data_movimentacao', date('Y-m-d')) }}" required>
                            @error('data_movimentacao')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Registrar</button>
                            <a href="{{ route('movimentacoes-estoque.index') }}" class="btn btn-secondary">Voltar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT PARA FORMULÁRIO DINÂMICO (JÁ ESTÁ CORRETO) --}}
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
                valorUnitarioInput.required = true;
                safraIdWrapper.style.display = 'none';
                safraIdInput.required = false;
            } else if (tipo === 'saida') {
                valorUnitarioWrapper.style.display = 'none';
                valorUnitarioInput.required = false;
                safraIdWrapper.style.display = 'block';
                safraIdInput.required = true;
            } else {
                valorUnitarioWrapper.style.display = 'none';
                valorUnitarioInput.required = false;
                safraIdWrapper.style.display = 'none';
                safraIdInput.required = false;
            }
        }
        tipoMovimentacao.addEventListener('change', toggleFields);
        toggleFields();
    });
</script>
@endsection