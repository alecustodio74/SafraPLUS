@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-display font-bold text-slate-800">Lançamentos Financeiros</h1>
            <p class="text-slate-500 mt-1">Gerencie as receitas e despesas vinculadas às suas safras.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('painel') }}" class="text-sm font-medium text-slate-600 bg-white px-4 py-2 rounded-lg border border-slate-200 shadow-sm hover:bg-slate-50 transition-colors">
                Voltar ao Painel
            </a>
            <a href="{{ route('lancamentos-financeiros.create') }}" class="inline-flex items-center gap-2 text-sm font-bold text-white bg-primary-600 px-4 py-2 rounded-lg shadow-md shadow-primary-500/30 hover:bg-primary-700 hover:shadow-lg transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Novo Lançamento
            </a>
        </div>
    </div>

    @if (session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm mb-6">
            <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm mb-6">
            <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden relative">
        <div class="absolute top-0 left-0 w-2 h-full bg-primary-500"></div>
        <div class="overflow-x-auto pl-2">
            <table class="w-full text-left border-collapse min-w-[1000px]">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-sm font-semibold text-slate-600">
                        <th class="py-4 px-6">Data</th>
                        <th class="py-4 px-6">Descrição</th>
                        <th class="py-4 px-6">Safra</th>
                        <th class="py-4 px-6">Categoria</th>
                        <th class="py-4 px-6">Tipo</th>
                        <th class="py-4 px-6">Valor</th>
                        @can('is-admin')
                        <th class="py-4 px-6">Produtor</th>
                        @endcan
                        <th class="py-4 px-6 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($lancamentos as $lancamento)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="py-4 px-6 text-slate-800 font-medium whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($lancamento->data)->format('d/m/Y') }}
                        </td>
                        <td class="py-4 px-6">
                            <div class="font-medium text-slate-800 max-w-xs truncate" title="{{ $lancamento->descricao }}">{{ $lancamento->descricao }}</div>
                        </td>
                        <td class="py-4 px-6 text-sm text-slate-600">
                            {{ $lancamento->safra->cultura ?? 'N/A' }}
                        </td>
                        <td class="py-4 px-6 text-sm">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 text-xs font-medium border border-slate-200">
                                {{ $lancamento->categoria->nome ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            @if($lancamento->tipo_receita_custo == 'receita')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Receita
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                    Despesa
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 font-bold whitespace-nowrap {{ $lancamento->tipo_receita_custo == 'receita' ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $lancamento->tipo_receita_custo == 'receita' ? '+' : '-' }} R$ {{ number_format($lancamento->valor_total, 2, ',', '.') }}
                        </td>
                        @can('is-admin')
                        <td class="py-4 px-6 text-sm text-slate-600">
                            {{ $lancamento->safra->produtor->nome ?? 'N/A' }}
                        </td>
                        @endcan
                        <td class="py-4 px-6 text-right space-x-2 opacity-100 xl:opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                            <a href="{{ route('lancamentos-financeiros.edit', $lancamento->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-amber-600 hover:bg-amber-100 transition-colors" title="Editar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                            <form action="{{ route('lancamentos-financeiros.destroy', $lancamento->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este lançamento?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-red-600 hover:bg-red-100 transition-colors" title="Excluir">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="@can('is-admin') 8 @else 7 @endcan" class="py-8 px-6 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p>Nenhum lançamento financeiro cadastrado ainda.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($lancamentos->count() > 0)
        <div class="bg-slate-50 border-t border-slate-100 px-6 py-3 text-sm text-slate-500 flex justify-between items-center">
            <span>Total de lançamentos: <span class="font-medium text-slate-700">{{ $lancamentos->count() }}</span></span>
            <div class="flex gap-4">
                <span class="text-emerald-600 font-medium">
                    Receitas: {{ $lancamentos->where('tipo_receita_custo', 'receita')->count() }}
                </span>
                <span class="text-rose-600 font-medium">
                    Despesas: {{ $lancamentos->where('tipo_receita_custo', '!=', 'receita')->count() }}
                </span>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection