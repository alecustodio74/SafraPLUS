@extends('layouts.app')

@section('header_title', 'Categorias')

@section('content')

@if (session('error'))
<div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-700 font-medium text-sm flex items-center gap-2">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
    {{ session('error') }}
</div>
@endif

@if (session('success'))
<div class="mb-6 p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 font-medium text-sm flex items-center gap-2">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    {{ session('success') }}
</div>
@endif

<div class="mb-6 flex justify-end gap-3">
    <a href="{{ route('painel') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-50 transition-colors shadow-sm">
        Voltar
    </a>
    <a href="{{ route('categorias.create') }}" class="px-4 py-2 bg-[#059669] border border-[#059669] text-white rounded-lg text-sm font-semibold hover:bg-[#047857] hover:border-[#047857] transition-colors shadow-sm flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Nova Categoria
    </a>
</div>

<div class="mb-6">
    <p class="text-sm text-gray-500">Gerencie as categorias de receitas e despesas para suas safras.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden">
    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-[#059669]"></div>
    
    <div class="overflow-x-auto pl-1.5">
        <!-- Desktop Table View -->
        <table class="w-full text-left border-collapse hidden md:table">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Nome</th>
                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Tipo</th>
                    @can('is-admin')
                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Produtor</th>
                    @endcan
                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-right sticky right-0 bg-gray-50 z-10 shadow-[-12px_0_15px_-3px_rgba(0,0,0,0.05)]">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($categorias as $categoria)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="py-4 px-6 flex items-center gap-3">
                        @if($categoria->tipo_receita_despesa == 'receita')
                            <span class="text-emerald-500 font-bold text-lg leading-none">+</span>
                        @else
                            <span class="text-pink-500 font-bold text-lg leading-none">-</span>
                        @endif
                        <span class="text-sm font-semibold text-gray-900">{{ $categoria->nome }}</span>
                    </td>
                    <td class="py-4 px-6 text-sm text-gray-600">
                        {{ ucfirst($categoria->tipo_receita_despesa) }}
                    </td>
                    @can('is-admin')
                    <td class="py-4 px-6 text-sm text-gray-600">
                        {{ $categoria->produtor->nome ?? 'N/A' }}
                    </td>
                    @endcan
                    <td class="py-4 px-6 text-right sticky right-0 bg-white group-hover:bg-gray-50/50 z-10 shadow-[-12px_0_15px_-3px_rgba(0,0,0,0.05)]">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('categorias.edit', $categoria->id) }}" class="p-2 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors shadow-sm" title="Editar">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta categoria?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors shadow-sm" title="Excluir">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="@can('is-admin') 4 @else 3 @endcan" class="py-8 px-6 text-center text-sm text-gray-500">
                        Nenhuma categoria cadastrada.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Mobile Card View -->
        <div class="md:hidden flex flex-col p-4 gap-4 bg-gray-50/50">
            @forelse ($categorias as $categoria)
            <div class="bg-white rounded-xl p-4 border border-gray-100 flex flex-col shadow-sm relative">
                <!-- Ações Absolute Top Right -->
                <div class="absolute top-4 right-4 flex gap-2">
                    <a href="{{ route('categorias.edit', $categoria->id) }}" class="p-1.5 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors" title="Editar">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </a>
                    <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta categoria?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1.5 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors" title="Excluir">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                </div>

                <div class="flex items-center gap-2 pr-16 mb-2">
                    @if($categoria->tipo_receita_despesa == 'receita')
                        <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-500 font-bold text-lg flex items-center justify-center shrink-0">+</span>
                    @else
                        <span class="w-8 h-8 rounded-lg bg-pink-50 text-pink-500 font-bold text-lg flex items-center justify-center shrink-0">-</span>
                    @endif
                    <div>
                        <h4 class="font-bold text-gray-900 leading-tight">{{ $categoria->nome }}</h4>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-gray-500">{{ ucfirst($categoria->tipo_receita_despesa) }}</span>
                    </div>
                </div>

                @can('is-admin')
                <div class="mt-2 pt-3 border-t border-gray-100 flex items-center gap-2">
                    @php
                        $nomeProd = $categoria->produtor->nome ?? 'N/A';
                        $primeiraLetra = $nomeProd !== 'N/A' ? strtoupper(substr($nomeProd, 0, 1)) : '?';
                    @endphp
                    <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-[10px] font-bold text-gray-600 shrink-0">
                        {{ $primeiraLetra }}
                    </div>
                    <span class="text-xs text-gray-500 font-medium">{{ $nomeProd }}</span>
                </div>
                @endcan
            </div>
            @empty
            <div class="p-8 text-center bg-white rounded-xl border border-dashed border-gray-200">
                <p class="text-sm font-medium text-gray-500">Nenhuma categoria cadastrada.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

@endsection
