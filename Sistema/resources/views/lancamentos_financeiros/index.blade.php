@extends('layouts.app')

@section('header_title', 'Lançamentos Financeiros')

@section('content')

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <p class="text-sm text-gray-500 mt-1">Visão detalhada e controle de receitas e despesas vinculadas às safras.</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('lancamentos-financeiros.index', ['filtro' => 'saldo_atual', 'data_inicio' => $dataInicio, 'data_fim' => $dataFim, 'mes_filtro' => $mesFiltro, 'safra_id_filtro' => $safraFiltro]) }}" class="px-4 py-2 text-sm font-semibold rounded-lg border {{ $filtro == 'saldo_atual' ? 'bg-[#059669] text-white border-[#059669]' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50' }} transition-colors shadow-sm">
            Saldo Atual
        </a>
        <a href="{{ route('lancamentos-financeiros.index', ['filtro' => 'receitas', 'data_inicio' => $dataInicio, 'data_fim' => $dataFim, 'mes_filtro' => $mesFiltro, 'safra_id_filtro' => $safraFiltro]) }}" class="px-4 py-2 text-sm font-semibold rounded-lg border {{ $filtro == 'receitas' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50' }} transition-colors shadow-sm">
            Receitas Totais
        </a>
        <a href="{{ route('lancamentos-financeiros.index', ['filtro' => 'despesas', 'data_inicio' => $dataInicio, 'data_fim' => $dataFim, 'mes_filtro' => $mesFiltro, 'safra_id_filtro' => $safraFiltro]) }}" class="px-4 py-2 text-sm font-semibold rounded-lg border {{ $filtro == 'despesas' ? 'bg-red-600 text-white border-red-600' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50' }} transition-colors shadow-sm">
            Despesas Totais
        </a>
    </div>
</div>

<!-- Filtros de Data e Botão Novo -->
<div class="mb-6 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
    <div class="flex flex-col md:flex-row gap-4 items-end justify-between">
        <form method="GET" action="{{ route('lancamentos-financeiros.index') }}" class="flex flex-col md:flex-row gap-4 items-end flex-1">
            <input type="hidden" name="filtro" value="{{ $filtro }}">
            
            <div class="w-full md:w-auto">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Safra</label>
                <select name="safra_id_filtro" onchange="this.form.submit()" class="w-full rounded-lg border-gray-200 bg-gray-50 px-3 py-2 text-sm focus:border-[#059669] focus:ring-[#059669]">
                    <option value="">Todas as Safras</option>
                    @foreach($safras as $safra)
                        <option value="{{ $safra->id }}" {{ $safraFiltro == $safra->id ? 'selected' : '' }}>
                            {{ $safra->cultura }} (Início: {{ \Carbon\Carbon::parse($safra->data_inicio)->format('d/m/Y') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="w-full md:w-auto">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Data Início</label>
                <input type="date" name="data_inicio" value="{{ $dataInicio }}" class="w-full rounded-lg border-gray-200 bg-gray-50 px-3 py-2 text-sm focus:border-[#059669] focus:ring-[#059669]">
            </div>
            
            <div class="w-full md:w-auto">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Data Fim</label>
                <input type="date" name="data_fim" value="{{ $dataFim }}" class="w-full rounded-lg border-gray-200 bg-gray-50 px-3 py-2 text-sm focus:border-[#059669] focus:ring-[#059669]">
            </div>
            
            <div class="hidden md:flex items-center text-gray-400 font-bold mb-2 px-2">OU</div>

            <div class="w-full md:w-auto">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Por Mês</label>
                <input type="month" name="mes_filtro" value="{{ $mesFiltro }}" class="w-full rounded-lg border-gray-200 bg-gray-50 px-3 py-2 text-sm focus:border-[#059669] focus:ring-[#059669]">
            </div>

            <div class="w-full md:w-auto flex gap-2">
                <button type="submit" class="px-6 py-2 bg-[#059669] text-white font-semibold rounded-lg text-sm hover:bg-[#047857] transition-colors shadow-sm">
                    Filtrar
                </button>
                @if($dataInicio || $dataFim || $mesFiltro || $safraFiltro)
                <a href="{{ route('lancamentos-financeiros.index', ['filtro' => $filtro]) }}" class="px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg text-sm hover:bg-gray-200 transition-colors flex items-center">
                    Limpar
                </a>
                @endif
            </div>
        </form>

        <div>
            <a href="{{ route('lancamentos-financeiros.create') }}" class="px-5 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors shadow-sm flex items-center gap-2 h-[38px]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Novo Lançamento
            </a>
        </div>
    </div>
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

@if (session('error'))
<div class="mb-6 p-4 rounded-xl bg-red-50 text-red-700 border border-red-200 flex items-center gap-3">
    <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
    {{ session('error') }}
</div>
@endif

@if (session('success'))
<div class="mb-6 p-4 rounded-xl bg-green-50 text-green-700 border border-green-200 flex items-center gap-3">
    <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative">
    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-blue-500"></div>
    <div class="overflow-x-auto pl-1.5">
        
        <!-- Desktop Table View -->
        <table class="w-full text-left border-collapse hidden md:table">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-bold">
                    <th class="px-6 py-4">Data</th>
                    <th class="px-6 py-4">Descrição</th>
                    <th class="px-6 py-4">Safra</th>
                    <th class="px-6 py-4">Categoria</th>
                    <th class="px-6 py-4">Tipo</th>
                    <th class="px-6 py-4">QTD</th>
                    <th class="px-6 py-4">Valor</th>
                    @can('is-admin')
                    <th class="px-6 py-4">Produtor</th>
                    @endcan
                    <th class="px-6 py-4 text-right sticky right-0 bg-gray-50 z-10 shadow-[-12px_0_15px_-3px_rgba(0,0,0,0.05)]">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse ($lancamentos as $lancamento)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($lancamento->data_lancamento)->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900">
                        {{ $lancamento->descricao }}
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $lancamento->safra->cultura ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $lancamento->categoria->nome ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4">
                        @if ($lancamento->tipo_receita_custo == 'receita')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                Receita
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-100">
                                Despesa
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $lancamento->quantidade ? number_format($lancamento->quantidade, 2, ',', '.') : '-' }}
                    </td>
                    <td class="px-6 py-4 font-medium {{ $lancamento->tipo_receita_custo == 'receita' ? 'text-emerald-600' : 'text-rose-600' }}">
                        R$ {{ number_format($lancamento->valor_total, 2, ',', '.') }}
                    </td>
                    @can('is-admin')
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            @php
                                $nomeProd = (isset($lancamento->safra->produtor) ? $lancamento->safra->produtor->nome : null) ?? ($lancamento->produtor_nome ?? 'N/A');
                                $primeiraLetra = $nomeProd !== 'N/A' ? strtoupper(substr($nomeProd, 0, 1)) : '?';
                            @endphp
                            <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-[10px] font-bold text-gray-600 shrink-0">
                                {{ $primeiraLetra }}
                            </div>
                            <span class="text-gray-700 font-medium text-xs">{{ $nomeProd }}</span>
                        </div>
                    </td>
                    @endcan
                    <td class="px-6 py-4 text-right sticky right-0 bg-white group-hover:bg-gray-50/50 z-10 shadow-[-12px_0_15px_-3px_rgba(0,0,0,0.05)]">
                        <div class="flex items-center justify-end gap-2">
                            @if(isset($lancamento->is_lancamento) && $lancamento->is_lancamento)
                            <a href="{{ route('lancamentos-financeiros.edit', $lancamento->id) }}" class="p-2 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors shadow-sm" title="Editar">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('lancamentos-financeiros.destroy', $lancamento->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors shadow-sm" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este lançamento?')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                            @else
                            <span class="text-xs text-gray-400 font-medium bg-gray-100 px-2 py-1 rounded-md">Automático</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="@can('is-admin') 9 @else 8 @endcan" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-500">
                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            <span class="text-sm font-medium">Nenhum lançamento financeiro cadastrado.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Mobile Card View -->
        <div class="md:hidden flex flex-col p-4 gap-4 bg-gray-50/50">
            @forelse ($lancamentos as $lancamento)
            <div class="bg-white rounded-xl p-4 border border-gray-100 flex flex-col gap-3 shadow-sm relative">
                <!-- Ações Absolute Top Right -->
                <div class="absolute top-4 right-4 flex gap-2">
                    @if(isset($lancamento->is_lancamento) && $lancamento->is_lancamento)
                    <a href="{{ route('lancamentos-financeiros.edit', $lancamento->id) }}" class="p-1.5 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors" title="Editar">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </a>
                    <form action="{{ route('lancamentos-financeiros.destroy', $lancamento->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1.5 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors" title="Excluir" onclick="return confirm('Excluir este lançamento?')">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                    @else
                    <span class="text-[10px] text-gray-400 font-medium bg-gray-100 px-2 py-1 rounded-md">Automático</span>
                    @endif
                </div>

                <div class="flex items-center gap-2 mb-1">
                    @if ($lancamento->tipo_receita_custo == 'receita')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-100 text-emerald-700 uppercase tracking-wider">Receita</span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-rose-100 text-rose-700 uppercase tracking-wider">Despesa</span>
                    @endif
                    <span class="text-xs text-gray-500 font-medium">{{ \Carbon\Carbon::parse($lancamento->data_lancamento)->format('d/m/Y') }}</span>
                </div>
                
                <div>
                    <h4 class="font-bold text-gray-900 text-base leading-tight pr-16">{{ $lancamento->descricao }}</h4>
                    <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="truncate">{{ $lancamento->safra->cultura ?? 'N/A' }} &bull; {{ $lancamento->categoria->nome ?? 'Sem Categoria' }}</span>
                    </p>
                </div>
                
                <div class="mt-2 pt-3 border-t border-gray-100 flex justify-between items-center">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Qtd: {{ $lancamento->quantidade ? number_format($lancamento->quantidade, 2, ',', '.') : '-' }}</span>
                    <span class="font-black text-lg {{ $lancamento->tipo_receita_custo == 'receita' ? 'text-emerald-600' : 'text-rose-600' }}">
                        R$ {{ number_format($lancamento->valor_total, 2, ',', '.') }}
                    </span>
                </div>
            </div>
            @empty
            <div class="p-8 text-center bg-white rounded-xl border border-dashed border-gray-200">
                <p class="text-sm font-medium text-gray-500">Nenhum lançamento financeiro.</p>
            </div>
            @endforelse
        </div>
        <div class="px-6 py-4 bg-white border-t border-gray-100 mt-4 rounded-b-xl">
            {{ $lancamentos->links() }}
        </div>
    </div>
</div>

@endsection
