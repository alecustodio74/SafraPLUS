@extends('layouts.app')

@section('header_title', 'Resumo Financeiro')

@section('content')

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <p class="text-sm text-gray-500 mt-1">Visão detalhada de receitas e despesas.</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('saldo-resumo', ['filtro' => 'saldo_atual', 'data_inicio' => $dataInicio, 'data_fim' => $dataFim, 'mes_filtro' => $mesFiltro]) }}" class="px-4 py-2 text-sm font-semibold rounded-lg border {{ $filtro == 'saldo_atual' ? 'bg-[#059669] text-white border-[#059669]' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50' }} transition-colors shadow-sm">
            Saldo Atual
        </a>
        <a href="{{ route('saldo-resumo', ['filtro' => 'receitas', 'data_inicio' => $dataInicio, 'data_fim' => $dataFim, 'mes_filtro' => $mesFiltro]) }}" class="px-4 py-2 text-sm font-semibold rounded-lg border {{ $filtro == 'receitas' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50' }} transition-colors shadow-sm">
            Receitas Totais
        </a>
        <a href="{{ route('saldo-resumo', ['filtro' => 'despesas', 'data_inicio' => $dataInicio, 'data_fim' => $dataFim, 'mes_filtro' => $mesFiltro]) }}" class="px-4 py-2 text-sm font-semibold rounded-lg border {{ $filtro == 'despesas' ? 'bg-red-600 text-white border-red-600' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50' }} transition-colors shadow-sm">
            Despesas Totais
        </a>
    </div>
</div>

<!-- Filtros de Data -->
<div class="mb-6 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
    <form method="GET" action="{{ route('saldo-resumo') }}" class="flex flex-col md:flex-row gap-4 items-end">
        <input type="hidden" name="filtro" value="{{ $filtro }}">
        
        <div class="w-full md:w-auto flex-1">
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Data Início</label>
            <input type="date" name="data_inicio" value="{{ $dataInicio }}" class="w-full rounded-lg border-gray-200 bg-gray-50 px-3 py-2 text-sm focus:border-[#059669] focus:ring-[#059669]">
        </div>
        
        <div class="w-full md:w-auto flex-1">
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Data Fim</label>
            <input type="date" name="data_fim" value="{{ $dataFim }}" class="w-full rounded-lg border-gray-200 bg-gray-50 px-3 py-2 text-sm focus:border-[#059669] focus:ring-[#059669]">
        </div>
        
        <div class="hidden md:flex items-center text-gray-400 font-bold mb-2 px-2">OU</div>

        <div class="w-full md:w-auto flex-1">
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Por Mês</label>
            <input type="month" name="mes_filtro" value="{{ $mesFiltro }}" class="w-full rounded-lg border-gray-200 bg-gray-50 px-3 py-2 text-sm focus:border-[#059669] focus:ring-[#059669]">
        </div>

        <div class="w-full md:w-auto flex gap-2">
            <button type="submit" class="px-6 py-2 bg-[#059669] text-white font-semibold rounded-lg text-sm hover:bg-[#047857] transition-colors shadow-sm">
                Filtrar
            </button>
            @if($dataInicio || $dataFim || $mesFiltro)
            <a href="{{ route('saldo-resumo', ['filtro' => $filtro]) }}" class="px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg text-sm hover:bg-gray-200 transition-colors flex items-center">
                Limpar
            </a>
            @endif
        </div>
    </form>
</div>

<!-- Resumo Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    @if(in_array($filtro, ['saldo_atual', 'receitas']))
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
        <div class="absolute right-0 top-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4"></div>
        <div class="relative z-10 flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Receitas Filtradas</p>
                <h3 class="text-3xl font-black text-blue-600">R$ {{ number_format($totalReceitas, 2, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
        </div>
    </div>
    @endif

    @if(in_array($filtro, ['saldo_atual', 'despesas']))
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
        <div class="absolute right-0 top-0 w-24 h-24 bg-red-50 rounded-bl-full -mr-4 -mt-4"></div>
        <div class="relative z-10 flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Despesas Filtradas</p>
                <h3 class="text-3xl font-black text-red-600">R$ {{ number_format($totalDespesas, 2, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
            </div>
        </div>
    </div>
    @endif

    @if($filtro == 'saldo_atual')
    <div class="{{ $saldo >= 0 ? 'bg-blue-600' : 'bg-red-600' }} rounded-2xl shadow-sm p-6 relative overflow-hidden text-white">
        <div class="absolute right-0 top-0 w-24 h-24 bg-white/10 rounded-full -mr-10 -mt-10"></div>
        <div class="relative z-10 flex justify-between items-start">
            <div>
                <p class="text-xs font-bold {{ $saldo >= 0 ? 'text-blue-100' : 'text-red-100' }} uppercase tracking-wider mb-1">Saldo Líquido</p>
                <h3 class="text-3xl font-black text-white">R$ {{ number_format($saldo, 2, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white/20 text-white flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Tabela de Movimentações -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative">
    <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $filtro == 'receitas' ? 'bg-blue-500' : ($filtro == 'despesas' ? 'bg-red-500' : 'bg-emerald-500') }}"></div>
    <div class="overflow-x-auto pl-1.5">
        
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-bold">
                    <th class="px-6 py-4">Data</th>
                    <th class="px-6 py-4">Descrição</th>
                    <th class="px-6 py-4">Tipo</th>
                    <th class="px-6 py-4 text-right">Valor Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse ($movimentacoes as $mov)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($mov->data)->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900">
                        {{ $mov->descricao }}
                    </td>
                    <td class="px-6 py-4">
                        @if($mov->tipo == 'receita')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">Receita</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-100">Despesa</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-bold text-right {{ $mov->tipo == 'receita' ? 'text-blue-600' : 'text-red-600' }}">
                        {{ $mov->tipo == 'receita' ? '+' : '-' }} R$ {{ number_format($mov->valor, 2, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-500">
                            <span class="text-sm font-medium">Nenhuma movimentação encontrada para o filtro selecionado.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

@endsection
