@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-display font-bold text-slate-800">Editar Produtor</h1>
        <p class="text-slate-500 mt-1">Atualize as informações do usuário <strong>{{ $produtor->nome }}</strong>.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden relative">
        <div class="absolute top-0 left-0 w-2 h-full bg-amber-500"></div>
        <div class="p-6 sm:p-8">
            <form action="{{ route('produtores.update', $produtor->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nome" class="block text-sm font-medium text-slate-700 mb-1">Nome Completo</label>
                        <input type="text" name="nome" id="nome" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-amber-500 focus:ring-amber-500 rounded-xl shadow-sm transition-colors px-4 py-2.5" value="{{ $produtor->nome }}" required placeholder="Henrique Cruz de Lima">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email (Usado para Login)</label>
                        <input type="email" name="email" id="email" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-amber-500 focus:ring-amber-500 rounded-xl shadow-sm transition-colors px-4 py-2.5" value="{{ $produtor->email }}" required autocomplete="username" placeholder="email@exemplo.com">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Nova Senha</label>
                        <input type="password" name="password" id="password" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-amber-500 focus:ring-amber-500 rounded-xl shadow-sm transition-colors px-4 py-2.5" autocomplete="new-password" placeholder="Deixe em branco para não alterar">
                        <p class="text-xs text-slate-500 mt-1">Só preencha se quiser mudar a senha do usuário.</p>
                    </div>
                    <div>
                        <label for="telefone" class="block text-sm font-medium text-slate-700 mb-1">Telefone / WhatsApp</label>
                        <input type="text" name="telefone" id="telefone" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-amber-500 focus:ring-amber-500 rounded-xl shadow-sm transition-colors px-4 py-2.5" value="{{ $produtor->telefone }}" placeholder="(18) 99999-9999">
                    </div>
                </div>
                
                <div>
                    <label for="cpf_cnpj" class="block text-sm font-medium text-slate-700 mb-1">CPF / CNPJ (apenas números)</label>
                    <input type="text" name="cpf_cnpj" id="cpf_cnpj" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-amber-500 focus:ring-amber-500 rounded-xl shadow-sm transition-colors px-4 py-2.5" value="{{ $produtor->cpf_cnpj }}" required placeholder="000.000.000-00">
                </div>

                <div class="p-5 bg-slate-50 border border-slate-100 rounded-xl space-y-4">
                    <h3 class="font-semibold text-slate-800 text-sm uppercase tracking-wider">Dados da Propriedade (Opcional)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="propriedade" class="block text-sm font-medium text-slate-700 mb-1">Nome da Propriedade</label>
                            <input type="text" name="propriedade" id="propriedade" class="w-full border-slate-300 bg-white text-slate-900 focus:border-amber-500 focus:ring-amber-500 rounded-lg shadow-sm transition-colors px-3 py-2" value="{{ $produtor->propriedade }}" placeholder="Ex: Fazenda Colorado">
                        </div>

                        <div>
                            <label for="cultura_principal" class="block text-sm font-medium text-slate-700 mb-1">Cultura Principal</label>
                            <input type="text" name="cultura_principal" id="cultura_principal" class="w-full border-slate-300 bg-white text-slate-900 focus:border-amber-500 focus:ring-amber-500 rounded-lg shadow-sm transition-colors px-3 py-2" value="{{ $produtor->cultura_principal }}" placeholder="Ex: Soja, Milho, Arroz">
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                    <button type="submit" class="inline-flex justify-center items-center px-6 py-2.5 bg-amber-600 border border-transparent rounded-xl font-bold text-sm text-white shadow-md shadow-amber-500/30 hover:bg-amber-700 hover:shadow-lg hover:shadow-amber-600/40 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition-all duration-200">
                        Salvar Alterações
                    </button>
                    <a href="{{ route('produtores.index') }}" class="text-sm font-medium text-slate-600 bg-white px-4 py-2.5 rounded-xl border border-slate-200 shadow-sm hover:bg-slate-50 transition-colors">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection