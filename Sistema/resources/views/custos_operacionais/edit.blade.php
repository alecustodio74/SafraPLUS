@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-custom">
                <div class="card-header bg-success text-white text-center fw-bold fs-4">
                    Editar Custo Operacional
                </div>

                <div class="card-body">
                    <form action="{{ route('custos-operacionais.update', $custo->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="safra_id" class="form-label">Associar Custo à Safra</label>
                            <select name="safra_id" id="safra_id" class="form-select" required>
                                <option value="">Selecione uma safra</option>
                                @foreach($safras as $safra)
                                    <option value="{{ $safra->id }}" {{ $custo->safra_id == $safra->id ? 'selected' : '' }}>
                                        {{ $safra->cultura }} (Início: {{ $safra->data_inicio }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <input type="text" name="descricao" id="descricao" class="form-control" value="{{ $custo->descricao }}" required placeholder="Combustível">
                        </div>
                        
                        <div class="mb-3">
                            <label for="data" class="form-label">Data</label>
                            <input type="date" name="data" id="data" class="form-control" value="{{ $custo->data }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="valor" class="form-label">Valor</label>
                            <input type="number" step="0.01" name="valor" id="valor" class="form-control" value="{{ $custo->valor }}" required placeholder="R$ 150,00">
                        </div>

                        <hr>
                        <p class="text-muted">Vincular a (Opcional):</p>

                        <div class="mb-3">
                            <label for="maquinario_id" class="form-label">Maquinário</label>
                            <select name="maquinario_id" id="maquinario_id" class="form-select">
                                <option value="">Nenhum</option>
                                @foreach($maquinarios as $maquinario)
                                    <option value="{{ $maquinario->id }}" {{ $custo->maquinario_id == $maquinario->id ? 'selected' : '' }}>
                                        {{ $maquinario->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="mao_de_obra_id" class="form-label">Mão de Obra</label>
                            <select name="mao_de_obra_id" id="mao_de_obra_id" class="form-select">
                                <option value="">Nenhum</option>
                                @foreach($maoDeObras as $item)
                                    <option value="{{ $item->id }}" {{ $custo->mao_de_obra_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->nome_ou_tipo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="d-flex justify-content-between">
                            <a href="{{ route('custos-operacionais.index') }}" class="btn btn-secondary">Voltar</a>
                            <button type="submit" class="btn btn-success">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection