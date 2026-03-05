@extends('layouts.app')

@section('header_title', 'Meu Perfil')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Meu Perfil</h2>
        <p class="text-sm text-gray-500 mt-1">Gerencie suas informações pessoais, senha e configuração da conta.</p>
    </div>
</div>

@if (session('success'))
<div class="mb-6 p-4 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center gap-3">
    <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
    {{ session('success') }}
</div>
@endif
@if (session('error'))
<div class="mb-6 p-4 rounded-xl bg-rose-50 text-rose-700 border border-rose-200 flex items-center gap-3">
    <svg class="w-5 h-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
    {{ session('error') }}
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
            <div class="absolute inset-x-0 top-0 h-24 bg-slate-800"></div>
            <div class="relative flex flex-col items-center mt-8">
                <div class="w-24 h-24 rounded-full bg-white flex items-center justify-center text-4xl font-black text-slate-800 mb-4 border-4 border-white shadow-sm ring-4 ring-slate-50/50">
                    {{ strtoupper(substr(Auth::user()->nome, 0, 1)) }}
                </div>
                <h3 class="text-xl font-bold text-gray-900">{{ Auth::user()->nome }}</h3>
                <p class="text-slate-500 text-sm mb-4">{{ Auth::user()->email }}</p>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ Auth::user()->role == 'admin' ? 'bg-fuchsia-50 text-fuchsia-700 border border-fuchsia-100' : 'bg-emerald-50 text-emerald-700 border border-emerald-100' }}">
                    {{ Auth::user()->role == 'admin' ? 'Administrador' : 'Produtor' }}
                </span>
            </div>
            <div class="mt-6 pt-6 border-t border-gray-50 space-y-4 text-sm">
                <div class="flex justify-between items-center">
                    <span class="text-gray-500 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Propriedade
                    </span>
                    <span class="font-semibold text-gray-900 truncate max-w-[150px]">{{ Auth::user()->propriedade ?: 'N/A' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        Telefone
                    </span>
                    <span class="font-semibold text-gray-900">{{ Auth::user()->telefone ?: 'N/A' }}</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="lg:col-span-2 space-y-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            @include('profile.partials.update-profile-information-form')
        </div>
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            @include('profile.partials.update-password-form')
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-rose-100 p-6 md:p-8 relative overflow-hidden">
            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-rose-500"></div>
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>

@endsection