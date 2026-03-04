@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-display font-bold text-slate-800">Movimentações de Estoque</h1>
            <p class="text-slate-500 mt-1">Gerencie as entradas e saídas de insumos do seu estoque.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('painel') }}" class="text-sm font-medium text-slate-600 bg-white px-4 py-2 rounded-lg border border-slate-200 shadow-sm hover:bg-slate-50 transition-colors">
                Voltar ao Painel
            </a>
            <a href="{{ route('movimentacoes-estoque.create') }}" class="inline-flex items-center gap-2 text-sm font-bold text-white bg-primary-600 px-4 py-2 rounded-lg shadow-md shadow-primary-500/30 hover:bg-primary-700 hover:shadow-lg transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nova Movimentação
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
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-sm font-semibold text-slate-600">
                        <th class="py-4 px-6">Data</th>
                        <th class="py-4 px-6">Tipo</th>
                        <th class="py-4 px-6">Insumo</th>
                        <th class="py-4 px-6 text-center">Qtd.</th>
                        <th class="py-4 px-6">Safra (Destino)</th>
                        @can('is-admin')
                        <th class="py-4 px-6">Produtor</th>
                        @endcan
                        <th class="py-4 px-6 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($movimentacoes as $movimentacao)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="py-4 px-6 text-slate-800 font-medium">
                            {{ \Carbon\Carbon::parse($movimentacao->data_movimentacao ?? $movimentacao->created_at)->format('d/m/Y') }}
                        </td>
                        <td class="py-4 px-6">
                            @if($movimentacao->tipo_movimentacao == 'entrada')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                                    Entrada
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-100">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path></svg>
                                    Saída
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <div class="font-medium text-slate-800">{{ $movimentacao->insumo->nome ?? 'N/A' }}</div>
                        </td>
                        <td class="py-4 px-6 text-center text-slate-700 font-semibold bg-slate-50/50">
                            {{ $movimentacao->quantidade }}
                        </td>
                        <td class="py-4 px-6 text-sm text-slate-600">
                            {{ $movimentacao->safra->cultura ?? 'N/A' }}
                        </td>
                        @can('is-admin')
                        <td class="py-4 px-6 text-sm text-slate-600">
                            {{ $movimentacao->insumo->produtor->nome ?? 'N/A' }}
                        </td>
                        @endcan
                        <td class="py-4 px-6 text-right space-x-2 opacity-100 xl:opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                            <a href="{{ route('movimentacoes-estoque.edit', $movimentacao->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-amber-600 hover:bg-amber-100 transition-colors" title="Editar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                            <form action="{{ route('movimentacoes-estoque.destroy', $movimentacao->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir esta movimentação?');">
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
                        <td colspan="@can('is-admin') 7 @else 6 @endcan" class="py-8 px-6 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                <p>Nenhuma movimentação cadastrada ainda.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($movimentacoes->count() > 0)
        <div class="bg-slate-50 border-t border-slate-100 px-6 py-3 text-sm text-slate-500">
            Total de movimentações: <span class="font-medium text-slate-700">{{ $movimentacoes->count() }}</span>
        </div>
        @endif
    </div>
</div>
@endsection