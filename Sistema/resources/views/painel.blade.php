@extends('layouts.app')

@section('header_title', 'Painel')

@section('content')

<!-- Header Section -->
<div class="mb-8">
    <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Visão Geral</h2>
    <p class="text-base text-gray-500 mt-2">Bem-vindo ao seu painel. Acompanhe as principais métricas e finanças da sua propriedade.</p>
</div>

<!-- Financial Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    
    <!-- Receitas Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden group hover:shadow-md transition-shadow">
        <div class="absolute right-0 top-0 w-24 h-24 bg-green-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
        <div class="relative z-10 flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Receitas Totais</p>
                <h3 class="text-3xl font-black text-gray-900">R$ {{ number_format($receitasTotais ?? 0, 2, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-green-100 text-green-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
        </div>
        <div class="relative z-10 mt-4 text-sm text-gray-500">
            Total arrecadado.
        </div>
    </div>

    <!-- Despesas Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden group hover:shadow-md transition-shadow">
        <div class="absolute right-0 top-0 w-24 h-24 bg-red-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
        <div class="relative z-10 flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Despesas Totais</p>
                <h3 class="text-3xl font-black text-gray-900">R$ {{ number_format($despesasTotais ?? 0, 2, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
            </div>
        </div>
        <div class="relative z-10 mt-4 text-sm text-gray-500">
            Total de custos e despesas.
        </div>
    </div>

    <!-- Saldo Card -->
    <div class="bg-[#059669] rounded-2xl shadow-md p-6 relative overflow-hidden text-white group hover:shadow-lg transition-shadow">
        <div class="absolute right-0 top-0 w-32 h-32 bg-white/10 rounded-full -mr-10 -mt-10 transition-transform group-hover:scale-110"></div>
        <div class="relative z-10 flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-green-100 uppercase tracking-wider mb-1">Saldo Atual</p>
                <h3 class="text-3xl font-black text-white">R$ {{ number_format($saldoAtual ?? 0, 2, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white/20 text-white flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        <div class="relative z-10 mt-4 text-sm text-green-50 font-medium">
            Total consolidado em caixa
        </div>
    </div>
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
            <div class="flex items-center gap-4">
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
            <div>
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