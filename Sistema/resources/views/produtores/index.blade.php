@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-display font-bold text-slate-800">Produtores</h1>
            <p class="text-slate-500 mt-1">Gerencie os usuários e proprietários rurais do sistema.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('painel') }}" class="text-sm font-medium text-slate-600 bg-white px-4 py-2 rounded-lg border border-slate-200 shadow-sm hover:bg-slate-50 transition-colors">
                Voltar
            </a>
            <a href="{{ route('produtores.create') }}" class="inline-flex items-center gap-2 text-sm font-bold text-white bg-primary-600 px-4 py-2 rounded-lg shadow-md shadow-primary-500/30 hover:bg-primary-700 hover:shadow-lg transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Novo Produtor
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
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-sm font-semibold text-slate-600">
                        <th class="py-4 px-6">Produtor</th>
                        <th class="py-4 px-6">Identificação</th>
                        <th class="py-4 px-6">Propriedade</th>
                        <th class="py-4 px-6 text-center">Tipo</th>
                        <th class="py-4 px-6 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($produtores as $produtor)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="py-4 px-6">
                            <div class="font-medium text-slate-800 text-sm flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold font-display shrink-0">
                                    {{ substr($produtor->nome, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold">{{ $produtor->nome }}</div>
                                    <div class="text-xs text-slate-500 font-normal mt-0.5">{{ $produtor->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-sm text-slate-600 font-mono text-xs">
                            {{ $produtor->cpf_cnpj ?: '-' }}
                        </td>
                        <td class="py-4 px-6 text-sm text-slate-600">
                            {{ $produtor->propriedade ?: 'Não informada' }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            @if($produtor->role == 'admin')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 border border-purple-200">
                                    Admin
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                    Produtor
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right space-x-2 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('produtores.edit', $produtor->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-amber-600 hover:bg-amber-100 transition-colors" title="Editar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                            @if(auth()->id() !== $produtor->id)
                            <form action="{{ route('produtores.destroy', $produtor->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este produtor? Isso não poderá ser desfeito.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-red-600 hover:bg-red-100 transition-colors" title="Excluir">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 px-6 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                <p>Nenhum produtor cadastrado ainda.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($produtores->count() > 0)
        <div class="bg-slate-50 border-t border-slate-100 px-6 py-3 text-sm text-slate-500 flex justify-between items-center">
            <span>Total de usuários registrados: <span class="font-bold text-slate-700">{{ $produtores->count() }}</span></span>
            <span class="text-xs">Apenas Administradores podem visualizar esta lista.</span>
        </div>
        @endif
    </div>
</div>
@endsection