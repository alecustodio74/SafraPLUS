@extends('layouts.app')

@section('header_title', 'Novo Custo Operacional')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <p class="text-sm text-gray-500 mt-1">Registre uma nova despesa ou custo associado a uma safra.</p>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden max-w-2xl">
    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-rose-500"></div>
    
    <div class="p-8 pl-10">
        <form action="{{ route('custos-operacionais.store') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label for="safra_id" class="block text-sm font-medium text-gray-700 mb-2">Associar Custo à Safra</label>
                <select name="safra_id" id="safra_id" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-rose-500 focus:border-rose-500 px-4 py-3 transition-colors outline-none" required>
                    <option value="">Selecione uma safra</option>
                    @foreach($safras as $safra)
                        <option value="{{ $safra->id }}">{{ $safra->cultura }} (Início: {{ \Carbon\Carbon::parse($safra->data_inicio)->format('d/m/Y') }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-5">
                <label for="categoria_custo" class="block text-sm font-medium text-gray-700 mb-2">Categoria</label>
                <select id="categoria_custo" name="categoria" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-rose-500 focus:border-rose-500 px-4 py-3 transition-colors outline-none">
                    <option value="geral">Geral / Outros</option>
                    <option value="combustivel">Combustível</option>
                    <option value="manutencao">Manutenção</option>
                    <option value="mao_de_obra">Mão de Obra</option>
                    <option value="maquinario">Maquinário</option>
                </select>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
                
                <input type="text" id="descricao_geral" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-rose-500 focus:border-rose-500 px-4 py-3 transition-colors outline-none" placeholder="Ex: Combustível, Manutenção">
                
                <select id="mao_de_obra_id_select" class="hidden w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-rose-500 focus:border-rose-500 px-4 py-3 transition-colors outline-none">
                    <option value="">Selecione a Mão de Obra</option>
                    @foreach($maoDeObras as $item)
                        <option value="{{ $item->id }}" data-custo="{{ $item->custo_diario_hora }}">{{ $item->nome_ou_tipo }}</option>
                    @endforeach
                </select>

                <select id="maquinario_id_select" class="hidden w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-rose-500 focus:border-rose-500 px-4 py-3 transition-colors outline-none">
                    <option value="">Selecione o Maquinário</option>
                    @foreach($maquinarios as $maquinario)
                        <option value="{{ $maquinario->id }}" data-custo="{{ $maquinario->custo_hora }}">{{ $maquinario->nome }}</option>
                    @endforeach
                </select>
                
                <input type="hidden" name="descricao" id="descricao">
                <input type="hidden" name="mao_de_obra_id" id="mao_de_obra_id">
                <input type="hidden" name="maquinario_id" id="maquinario_id">
            </div>

            <div class="flex flex-col md:flex-row gap-5 mb-5">
                <div class="flex-1">
                    <label for="data" class="block text-sm font-medium text-gray-700 mb-2">Data</label>
                    <input type="date" name="data" id="data" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-rose-500 focus:border-rose-500 px-4 py-3 transition-colors outline-none" required value="{{ date('Y-m-d') }}">
                </div>
                <div class="flex-1">
                    <label for="quantidade" id="label_quantidade" class="block text-sm font-medium text-gray-700 mb-2">Quantidade (QTD)</label>
                    <input type="number" step="0.01" name="quantidade" id="quantidade" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-rose-500 focus:border-rose-500 px-4 py-3 transition-colors outline-none" placeholder="Ex: 2.5" oninput="calcularValorTotal()">
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-5 mb-5">
                <div class="flex-1">
                    <label for="preco_unitario" id="label_preco" class="block text-sm font-medium text-gray-700 mb-2">Preço Unitário</label>
                    <input type="number" step="0.01" name="preco_unitario" id="preco_unitario" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-rose-500 focus:border-rose-500 px-4 py-3 transition-colors outline-none" placeholder="Ex: 150,00" oninput="calcularValorTotal()">
                </div>
                <div class="flex-1">
                    <label for="valor" class="block text-sm font-medium text-gray-700 mb-2">Valor Total</label>
                    <input type="number" step="0.01" name="valor" id="valor" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-rose-500 focus:border-rose-500 px-4 py-3 transition-colors outline-none" required placeholder="Ex: 500,00">
                </div>
            </div>

            <div class="pt-2 flex items-center gap-3">
                <button type="submit" class="px-6 py-2.5 bg-rose-600 text-white font-semibold rounded-xl hover:bg-rose-700 transition-colors shadow-sm">
                    Salvar Custo
                </button>
                <a href="{{ route('custos-operacionais.index') }}" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const catSelect = document.getElementById('categoria_custo');
        const descGeral = document.getElementById('descricao_geral');
        const selectMao = document.getElementById('mao_de_obra_id_select');
        const selectMaq = document.getElementById('maquinario_id_select');
        
        const hiddenDesc = document.getElementById('descricao');
        const hiddenMao = document.getElementById('mao_de_obra_id');
        const hiddenMaq = document.getElementById('maquinario_id');
        
        const lblQtd = document.getElementById('label_quantidade');
        const lblPreco = document.getElementById('label_preco');
        const inputPreco = document.getElementById('preco_unitario');
        const inputQtd = document.getElementById('quantidade');

        function updateFields() {
            let cat = catSelect.value;
            
            descGeral.classList.add('hidden');
            selectMao.classList.add('hidden');
            selectMaq.classList.add('hidden');
            
            lblQtd.innerText = 'Quantidade (QTD)';
            lblPreco.innerText = 'Preço Unitário';
            
            if (cat === 'geral' || cat === 'combustivel' || cat === 'manutencao') {
                descGeral.classList.remove('hidden');
                hiddenDesc.value = descGeral.value;
                hiddenMao.value = '';
                hiddenMaq.value = '';
            } else if (cat === 'mao_de_obra') {
                selectMao.classList.remove('hidden');
                hiddenMao.value = selectMao.value;
                hiddenMaq.value = '';
                if(selectMao.options[selectMao.selectedIndex] && selectMao.value !== "") {
                    hiddenDesc.value = selectMao.options[selectMao.selectedIndex].text;
                } else {
                    hiddenDesc.value = '';
                }
                lblQtd.innerText = 'Quantidade (HORAS)';
                lblPreco.innerText = 'Valor da Hora';
                
            } else if (cat === 'maquinario') {
                selectMaq.classList.remove('hidden');
                hiddenMaq.value = selectMaq.value;
                hiddenMao.value = '';
                if(selectMaq.options[selectMaq.selectedIndex] && selectMaq.value !== "") {
                    hiddenDesc.value = selectMaq.options[selectMaq.selectedIndex].text;
                } else {
                    hiddenDesc.value = '';
                }
                lblQtd.innerText = 'Quantidade (HORAS)';
                lblPreco.innerText = 'Valor da Hora';
            }
        }
        
        catSelect.addEventListener('change', function() {
            updateFields();
            if(this.value === 'mao_de_obra' && selectMao.value !== "") {
                inputPreco.value = selectMao.options[selectMao.selectedIndex].getAttribute('data-custo');
                calcularValorTotal();
            } else if(this.value === 'maquinario' && selectMaq.value !== "") {
                inputPreco.value = selectMaq.options[selectMaq.selectedIndex].getAttribute('data-custo');
                calcularValorTotal();
            } else if(this.value === 'geral' || this.value === 'combustivel' || this.value === 'manutencao') {
                hiddenDesc.value = descGeral.value;
            }
        });
        
        descGeral.addEventListener('input', function() { 
            if(['geral', 'combustivel', 'manutencao'].includes(catSelect.value)) hiddenDesc.value = this.value; 
        });
        
        selectMao.addEventListener('change', function() {
            if(catSelect.value === 'mao_de_obra') {
                hiddenMao.value = this.value;
                hiddenDesc.value = this.value !== "" ? this.options[this.selectedIndex].text : '';
                inputPreco.value = this.options[this.selectedIndex].getAttribute('data-custo') || '';
                calcularValorTotal();
            }
        });
        
        selectMaq.addEventListener('change', function() {
            if(catSelect.value === 'maquinario') {
                hiddenMaq.value = this.value;
                hiddenDesc.value = this.value !== "" ? this.options[this.selectedIndex].text : '';
                inputPreco.value = this.options[this.selectedIndex].getAttribute('data-custo') || '';
                calcularValorTotal();
            }
        });
        
        updateFields();
    });

    function calcularValorTotal() {
        let qtd = parseFloat(document.getElementById('quantidade').value);
        let preco = parseFloat(document.getElementById('preco_unitario').value);
        
        if (!isNaN(qtd) && !isNaN(preco)) {
            document.getElementById('valor').value = (qtd * preco).toFixed(2);
        } else {
            document.getElementById('valor').value = '';
        }
    }
</script>
@endsection
@endsection