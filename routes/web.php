<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SafraController;
use App\Http\Controllers\LancamentoFinanceiroController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\InsumoController;
use App\Http\Controllers\MaquinarioController;
use App\Http\Controllers\MaoDeObraController;
use App\Http\Controllers\CustoOperacionalController;
use App\Http\Controllers\MovimentacaoEstoqueController;
use App\Http\Controllers\ProdutorController;
use App\Http\Controllers\AdministradorController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/painel', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('painel');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.edit_password');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update_password');

    Route::resource('produtores', ProdutorController::class)
         ->parameters(['produtores' => 'produtor'])
         ->middleware('can:is-admin'); 

    Route::resource('administradores', AdministradorController::class) 
         ->parameters(['administradores' => 'administrador'])
         ->except(['show'])
         ->middleware('can:is-admin');
         
    Route::resource('safras', SafraController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('insumos', InsumoController::class);
    Route::resource('maquinarios', MaquinarioController::class);
    Route::resource('mao-de-obra', MaoDeObraController::class)->parameters(['mao-de-obra' => 'mao_de_obra']);
    Route::resource('lancamentos-financeiros', LancamentoFinanceiroController::class)->parameters(['lancamentos-financeiros' => 'lancamento_financeiro']);
    Route::resource('custos-operacionais', CustoOperacionalController::class)->parameters(['custos-operacionais' => 'custoOperacional']);
    Route::resource('movimentacoes-estoque', MovimentacaoEstoqueController::class)->parameters(['movimentacoes-estoque' => 'movimentacaoEstoque']);;
    Route::get('relatorios', [RelatorioController::class, 'index'])->name('relatorios.index');
});

require __DIR__ . '/auth.php';