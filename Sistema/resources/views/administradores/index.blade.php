@extends('layouts.app')

@section('header_title', 'Administradores')

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
    <a href="{{ route('administradores.create') }}" class="px-4 py-2 bg-[#059669] border border-[#059669] text-white rounded-lg text-sm font-semibold hover:bg-[#047857] hover:border-[#047857] transition-colors shadow-sm flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Novo Administrador
    </a>
</div>

<div class="mb-6">
    <p class="text-sm text-gray-500">Gerencie os usuários com permissão total de acesso ao sistema.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden">
    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-purple-500"></div>
    
    <div class="overflow-x-auto pl-1.5">
        <!-- Desktop Table View -->
        <table class="w-full text-left border-collapse hidden md:table">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Administrador</th>
                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">CPF/CNPJ</th>
                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-right sticky right-0 bg-gray-50 z-10 shadow-[-12px_0_15px_-3px_rgba(0,0,0,0.05)]">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($administradores as $admin)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center font-bold text-sm border border-purple-200/50">
                                {{ strtoupper(substr($admin->nome, 0, 1)) }}
                            </div>
                            <div>
                                <div class="text-sm font-bold text-gray-900">{{ $admin->nome }}</div>
                                <div class="text-xs text-gray-500">{{ $admin->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-sm text-gray-600">
                        {{ $admin->cpf_cnpj }}
                    </td>
                    <td class="py-4 px-6">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-100">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            Admin
                        </span>
                    </td>
                    <td class="py-4 px-6 text-right sticky right-0 bg-white group-hover:bg-gray-50/50 z-10 shadow-[-12px_0_15px_-3px_rgba(0,0,0,0.05)]">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('administradores.edit', $admin->id) }}" class="p-2 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors shadow-sm" title="Editar">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('administradores.destroy', $admin->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este administrador?');">
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
                    <td colspan="4" class="py-8 px-6 text-center text-sm text-gray-500">
                        Nenhum administrador cadastrado.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Mobile Card View -->
        <div class="md:hidden flex flex-col p-4 gap-4 bg-gray-50/50">
            @forelse ($administradores as $admin)
            <div class="bg-white rounded-xl p-4 border border-gray-100 flex flex-col shadow-sm relative text-left">
                <!-- Ações Absolute Top Right -->
                <div class="absolute top-4 right-4 flex gap-2">
                    <a href="{{ route('administradores.edit', $admin->id) }}" class="p-1.5 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors" title="Editar">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </a>
                    <form action="{{ route('administradores.destroy', $admin->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este administrador?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1.5 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors" title="Excluir">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                </div>

                <div class="flex items-center gap-4 mb-4 pr-16">
                    <div class="w-12 h-12 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center font-bold text-lg border border-purple-100 shrink-0">
                        {{ strtoupper(substr($admin->nome, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <div class="text-base font-bold text-gray-900 truncate">{{ $admin->nome }}</div>
                        <div class="text-xs text-gray-500 truncate">{{ $admin->email }}</div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="text-[10px] text-gray-400 uppercase font-black block mb-0.5">Identificação</span>
                        <span class="text-xs font-medium text-gray-900">{{ $admin->cpf_cnpj }}</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-gray-400 uppercase font-black block mb-0.5">Status</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-100">
                            ADMIN
                        </span>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-8 text-center bg-white rounded-xl border border-dashed border-gray-200">
                <p class="text-sm font-medium text-gray-500">Nenhum administrador cadastrado.</p>
            </div>
            @endforelse
        </div>
        
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 text-sm text-gray-500 flex items-center justify-between">
            <span>Total de administradores: <span class="font-bold text-gray-900">{{ $administradores->total() }}</span></span>
        </div>
        <div class="px-6 py-4 bg-white border-t border-gray-100 rounded-b-xl">
            {{ $administradores->links() }}
        </div>
</div>

@endsection
