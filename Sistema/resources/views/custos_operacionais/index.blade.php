@extends('layouts.app')

@section('header_title', 'Custos Operacionais')

@section('content')

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Custos Operacionais</h2>
        <p class="text-sm text-gray-500 mt-1">Gerencie e monitore as despesas relacionadas às safras.</p>
    </div>
    <a href="{{ route('custos-operacionais.create') }}" class="px-5 py-2.5 bg-rose-600 text-white font-semibold rounded-xl hover:bg-rose-700 transition-colors shadow-sm flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        Novo Custo
    </a>
</div>

@if (session('success'))
<div class="mb-6 p-4 rounded-xl bg-green-50 text-green-700 border border-green-200 flex items-center gap-3">
    <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative">
    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-rose-500"></div>
    <div class="overflow-x-auto pl-1.5">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-bold">
                    <th class="px-6 py-4">Data</th>
                    <th class="px-6 py-4">Descrição</th>
                    <th class="px-6 py-4">Safra</th>
                    @can('is-admin')
                    <th class="px-6 py-4">Produtor</th>
                    @endcan
                    <th class="px-6 py-4">Valor</th>
                    <th class="px-6 py-4 text-center">Vínculo</th>
                    <th class="px-6 py-4 text-right sticky right-0 bg-gray-50 z-10 shadow-[-12px_0_15px_-3px_rgba(0,0,0,0.05)]">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse ($custos as $custo)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($custo->data)->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900">
                        {{ $custo->descricao }}
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $custo->safra->cultura ?? 'N/A' }}
                    </td>
                    @can('is-admin')
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            @php
                                $nomeProd = $custo->safra->produtor->nome ?? 'N/A';
                                $primeiraLetra = $nomeProd !== 'N/A' ? strtoupper(substr($nomeProd, 0, 1)) : '?';
                            @endphp
                            <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-[10px] font-bold text-gray-600 shrink-0">
                                {{ $primeiraLetra }}
                            </div>
                            <span class="text-gray-700 font-medium text-xs">{{ $nomeProd }}</span>
                        </div>
                    </td>
                    @endcan
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-100">
                            R$ {{ number_format($custo->valor, 2, ',', '.') }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600 text-center">
                        @php
                            $vinculos = [];
                            if ($custo->maquinario) {
                                $vinculos[] = $custo->maquinario->nome;
                            }
                            if ($custo->maoDeObra) {
                                $vinculos[] = $custo->maoDeObra->nome_ou_tipo;
                            }
                        @endphp
                        
                        @if (!empty($vinculos))
                            <span class="inline-flex items-center gap-1.5 text-xs font-medium text-gray-600 bg-gray-100 px-2.5 py-1 rounded-md">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                {{ implode(' / ', $vinculos) }}
                            </span>
                        @else
                            <span class="text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right sticky right-0 bg-white group-hover:bg-gray-50/50 z-10 shadow-[-12px_0_15px_-3px_rgba(0,0,0,0.05)]">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('custos-operacionais.edit', $custo->id) }}" class="p-2 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors shadow-sm" title="Editar">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('custos-operacionais.destroy', $custo->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors shadow-sm" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este custo?')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="@can('is-admin') 7 @else 6 @endcan" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-500">
                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            <span class="text-sm font-medium">Nenhum custo operacional cadastrado.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
