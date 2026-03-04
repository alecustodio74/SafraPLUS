@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-display font-bold text-slate-800">Meu Perfil</h1>
            <p class="text-slate-500 mt-1">Gerencie suas informações, segurança e definições de conta.</p>
        </div>
        <a href="{{ route('painel') }}" class="text-sm font-medium text-slate-600 bg-white px-4 py-2 rounded-lg border border-slate-200 shadow-sm hover:bg-slate-50 transition-colors">
            Voltar ao Painel
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm mb-6">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm mb-6">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-8">
        <!-- Update Information Form -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-100 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-2 h-full bg-primary-500"></div>
            @include('profile.partials.update-profile-information-form')
        </div>

        <!-- Update Password Form -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-100 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-2 h-full bg-slate-800"></div>
            @include('profile.partials.update-password-form')
        </div>

        <!-- Delete User Form -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-100 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-2 h-full bg-red-500"></div>
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection