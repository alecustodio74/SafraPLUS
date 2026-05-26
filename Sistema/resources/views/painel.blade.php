@extends('layouts.app')

@section('header_title')
    Painel @if(Auth::user()->propriedade) <span class="text-gray-500 font-medium text-lg ml-2 hidden sm:inline-block"> {{ Auth::user()->propriedade }}</span> @endif
@endsection

@section('content')

<!-- Header Section Removida por redundância -->

<!-- Eye Icon Toggle -->
<div class="flex justify-end mb-4">
    <button id="toggle-values-btn" class="flex items-center gap-2 text-gray-500 hover:text-gray-700 transition-colors focus:outline-none" title="Ocultar/Exibir Valores">
        <svg id="eye-icon-open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
        <svg id="eye-icon-closed" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
    </button>
</div>

<!-- Financial Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    
    <!-- Saldo Card -->
    <a href="{{ route('lancamentos-financeiros.index', ['filtro' => 'saldo_atual']) }}" class="{{ $saldoAtual >= 0 ? 'bg-blue-600' : 'bg-red-600' }} rounded-2xl shadow-md p-6 relative overflow-hidden text-white group hover:shadow-lg transition-shadow block">
        <div class="absolute right-0 top-0 w-32 h-32 bg-white/10 rounded-full -mr-10 -mt-10 transition-transform group-hover:scale-110"></div>
        <div class="relative z-10 flex justify-between items-start">
            <div>
                <p class="text-xs font-bold {{ $saldoAtual >= 0 ? 'text-blue-100' : 'text-red-100' }} uppercase tracking-wider mb-1">Saldo Atual</p>
                <h3 class="text-3xl font-black text-white">R$ <span class="financial-value" data-value="{{ number_format($saldoAtual ?? 0, 2, ',', '.') }}">{{ number_format($saldoAtual ?? 0, 2, ',', '.') }}</span></h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white/20 text-white flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        <div class="relative z-10 mt-4 text-sm {{ $saldoAtual >= 0 ? 'text-blue-50' : 'text-red-50' }} font-medium">
            Total consolidado em caixa
        </div>
    </a>

    <!-- Receitas Card -->
    <a href="{{ route('lancamentos-financeiros.index', ['filtro' => 'receitas']) }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden group hover:shadow-md transition-shadow block">
        <div class="absolute right-0 top-0 w-24 h-24 bg-green-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
        <div class="relative z-10 flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Receitas Totais</p>
                <h3 class="text-3xl font-black text-gray-900">R$ <span class="financial-value" data-value="{{ number_format($receitasTotais ?? 0, 2, ',', '.') }}">{{ number_format($receitasTotais ?? 0, 2, ',', '.') }}</span></h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-green-100 text-green-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
        </div>
        <div class="relative z-10 mt-4 text-sm text-gray-500">
            Total arrecadado
        </div>
    </a>

    <!-- Despesas Card -->
    <a href="{{ route('lancamentos-financeiros.index', ['filtro' => 'despesas']) }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden group hover:shadow-md transition-shadow block">
        <div class="absolute right-0 top-0 w-24 h-24 bg-red-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
        <div class="relative z-10 flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Despesas Totais</p>
                <h3 class="text-3xl font-black text-gray-900">R$ <span class="financial-value" data-value="{{ number_format($despesasTotais ?? 0, 2, ',', '.') }}">{{ number_format($despesasTotais ?? 0, 2, ',', '.') }}</span></h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
            </div>
        </div>
        <div class="relative z-10 mt-4 text-sm text-gray-500">
            Total de custos e despesas
        </div>
    </a>

</div>

<!-- Safras Recentes -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mt-8">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-900 tracking-tight">Safras Mais Recentes</h3>
        <a href="{{ route('safras.index') }}" class="text-sm font-semibold text-[#059669] hover:text-[#047857] transition-colors">Ver todas</a>
    </div>
    
    <div class="divide-y divide-gray-50 max-h-[500px] overflow-y-auto">
        @forelse ($safrasRecentes as $safra)
        <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-gray-50/50 transition-colors">
            <div class="flex items-center gap-4 flex-1">
                <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h4 class="text-base font-bold text-gray-900">{{ $safra->cultura }}</h4>
                    <p class="text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($safra->data_inicio)->format('d/m/Y') }} → {{ $safra->data_fim ? \Carbon\Carbon::parse($safra->data_fim)->format('d/m/Y') : 'Em andamento' }}
                    </p>
                </div>
            </div>
            
            @if($safra->propriedade)
            <div class="flex-1 text-left sm:text-center">
                <span class="font-bold text-gray-800">{{ $safra->propriedade }}</span>
            </div>
            @endif

            <div class="flex-shrink-0 text-left sm:text-right">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $safra->data_fim ? 'bg-gray-100 text-gray-700' : 'bg-green-50 text-[#059669] border border-green-100' }}">
                    {{ $safra->data_fim ? 'Concluída' : 'Em Andamento' }}
                </span>
            </div>
        </div>
        @empty
        <div class="p-12 text-center flex flex-col items-center">
            <div class="w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
            </div>
            <p class="text-sm font-medium text-gray-900 mb-1">Nenhuma safra registrada.</p>
            <p class="text-xs text-gray-500 mb-4">Comece cadastrando sua primeira safra.</p>
            <a href="{{ route('safras.create') }}" class="px-4 py-2 bg-white text-gray-700 font-semibold rounded-lg text-sm border border-gray-200 hover:bg-gray-50 transition-colors shadow-sm">
                Nova Safra
            </a>
        </div>
        @endforelse
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('toggle-values-btn');
        const eyeOpen = document.getElementById('eye-icon-open');
        const eyeClosed = document.getElementById('eye-icon-closed');
        const financialValues = document.querySelectorAll('.financial-value');
        
        // Verifica se o estado estava oculto (salvo no localStorage)
        let isHidden = localStorage.getItem('hideFinancialValues') === 'true';

        // Função para atualizar a view
        function updateView() {
            if (isHidden) {
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
                financialValues.forEach(el => {
                    el.textContent = '***';
                });
            } else {
                eyeClosed.classList.add('hidden');
                eyeOpen.classList.remove('hidden');
                financialValues.forEach(el => {
                    el.textContent = el.getAttribute('data-value');
                });
            }
        }

        // Configuração inicial
        updateView();

        // Evento de clique
        toggleBtn.addEventListener('click', function() {
            isHidden = !isHidden;
            localStorage.setItem('hideFinancialValues', isHidden);
            updateView();
        });
    });
</script>
@endsection