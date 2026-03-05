@extends('layouts.app')

@section('header_title', 'Maquinários')

@section('content')

<div class="mb-6 flex justify-end">
    <a href="{{ route('maquinarios.create') }}" class="px-5 py-2.5 bg-amber-500 text-white font-semibold rounded-xl hover:bg-amber-600 transition-colors shadow-sm flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Novo Maquinário
    </a>
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
    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-amber-500"></div>
    <div class="overflow-x-auto pl-1.5">
        <!-- Desktop Table View -->
        <table class="w-full text-left border-collapse hidden md:table">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-bold">
                    <th class="px-6 py-4">Nome</th>
                    <th class="px-6 py-4">Série / Documento</th>
                    <th class="px-6 py-4">Modelo/Marca</th>
                    <th class="px-6 py-4">Ano</th>
                    <th class="px-6 py-4">Custo/Hora</th>
                    @can('is-admin')
                    <th class="px-6 py-4">Produtor</th>
                    @endcan
                    <th class="px-6 py-4 text-right sticky right-0 bg-gray-50 z-10 shadow-[-12px_0_15px_-3px_rgba(0,0,0,0.05)]">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse ($maquinarios as $maquinario)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="px-6 py-4 font-semibold text-gray-900">
                        {{ $maquinario->nome }}
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $maquinario->descricao_atividade ?: '-' }}
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                         {{ $maquinario->marca }} / {{ $maquinario->modelo }}
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $maquinario->ano }}
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100">
                            R$ {{ number_format($maquinario->custo_hora, 2, ',', '.') }}
                        </span>
                    </td>
                    @can('is-admin')
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @php
                                $nomeProd = $maquinario->produtor->nome ?? 'N/A';
                                $primeiraLetra = $nomeProd !== 'N/A' ? strtoupper(substr($nomeProd, 0, 1)) : '?';
                            @endphp
                            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-600 shrink-0">
                                {{ $primeiraLetra }}
                            </div>
                            <span class="text-gray-700 font-medium">{{ $nomeProd }}</span>
                        </div>
                    </td>
                    @endcan
                    <td class="px-6 py-4 text-right sticky right-0 bg-white group-hover:bg-gray-50/50 z-10 shadow-[-12px_0_15px_-3px_rgba(0,0,0,0.05)]">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('maquinarios.edit', $maquinario->id) }}" class="p-2 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors shadow-sm" title="Editar">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('maquinarios.destroy', $maquinario->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors shadow-sm" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este maquinário?')">
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
                            <span class="text-sm font-medium">Nenhum maquinário cadastrado.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Mobile Card View -->
        <div class="md:hidden flex flex-col p-4 gap-4 bg-gray-50/50">
            @forelse ($maquinarios as $maquinario)
            <div class="bg-white rounded-xl p-4 border border-gray-100 flex flex-col shadow-sm relative">
                <!-- Ações Absolute Top Right -->
                <div class="absolute top-4 right-4 flex gap-2">
                    <a href="{{ route('maquinarios.edit', $maquinario->id) }}" class="p-1.5 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors" title="Editar">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </a>
                    <form action="{{ route('maquinarios.destroy', $maquinario->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1.5 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este maquinário?')">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                </div>

                <div class="mb-3 pr-16">
                    <h4 class="font-bold text-gray-900 text-lg leading-tight">{{ $maquinario->nome }}</h4>
                    <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                        <span class="truncate">{{ $maquinario->marca }} / {{ $maquinario->modelo }} &bull; {{ $maquinario->ano }}</span>
                    </p>
                    <p class="text-[10px] text-gray-400 mt-0.5 truncate uppercase">{{ $maquinario->descricao_atividade ?: 'Registro sem doc' }}</p>
                </div>

                <div class="flex items-center gap-3 mb-2">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-100 uppercase tracking-wider">
                        Custo/Hora: R$ {{ number_format($maquinario->custo_hora, 2, ',', '.') }}
                    </span>
                </div>

                @can('is-admin')
                <div class="mt-2 pt-3 border-t border-gray-100 flex items-center gap-2">
                    @php
                        $nomeProd = $maquinario->produtor->nome ?? 'N/A';
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
                <p class="text-sm font-medium text-gray-500">Nenhum maquinário cadastrado.</p>
            </div>
            @endforelse
        </div>
        <div class="px-6 py-4 bg-white border-t border-gray-100 mt-4 rounded-b-xl">
            {{ $maquinarios->links() }}
        </div>
    </div>
</div>

@endsection
