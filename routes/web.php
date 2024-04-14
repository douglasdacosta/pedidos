<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes(['register' => false, 'reset' => false]);

Route::get('admin/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings');
Route::post('admin/alterar-senha', [App\Http\Controllers\SettingsController::class, 'edit'])->name('alterar-senha');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::match(['get', 'post'],'/categorias', [App\Http\Controllers\CategoriasController::class, 'index'])->name('categorias');
Route::match(['get', 'post'],'/alterar-categorias', [App\Http\Controllers\CategoriasController::class, 'alterar'])->name('alterar-categorias');
Route::match(['get', 'post'],'/incluir-categorias', [App\Http\Controllers\CategoriasController::class, 'incluir'])->name('incluir-categorias');

Route::match(['get', 'post'],'/produtos', [App\Http\Controllers\ProdutosController::class, 'index'])->name('produtos');
Route::match(['get', 'post'],'/alterar-produtos', [App\Http\Controllers\ProdutosController::class, 'alterar'])->name('alterar-produtos');
Route::match(['get', 'post'],'/incluir-produtos', [App\Http\Controllers\ProdutosController::class, 'incluir'])->name('incluir-produtos');

Route::match(['get', 'post'],'/clientes', [App\Http\Controllers\ClientesController::class, 'index'])->name('clientes');
Route::match(['get', 'post'],'/alterar-clientes', [App\Http\Controllers\ClientesController::class, 'alterar'])->name('alterar-clientes');
Route::match(['get', 'post'],'/incluir-clientes', [App\Http\Controllers\ClientesController::class, 'incluir'])->name('incluir-clientes');

Route::match(['get', 'post'],'/status', [App\Http\Controllers\StatusController::class, 'index'])->name('status');
Route::match(['get', 'post'],'/alterar-status', [App\Http\Controllers\StatusController::class, 'alterar'])->name('alterar-status');
Route::match(['get', 'post'],'/incluir-status', [App\Http\Controllers\StatusController::class, 'incluir'])->name('incluir-status');

Route::match(['get', 'post'],'/pedidos', [App\Http\Controllers\PedidosController::class, 'index'])->name('pedidos');
Route::match(['get', 'post'],'/alterar-pedidos', [App\Http\Controllers\PedidosController::class, 'alterar'])->name('alterar-pedidos');
Route::match(['get', 'post'],'/incluir-pedidos', [App\Http\Controllers\PedidosController::class, 'incluir'])->name('incluir-pedidos');

Route::match(['get', 'post'],'/orcamentos', [App\Http\Controllers\OrcamentosController::class, 'index'])->name('orcamentos');
Route::match(['get', 'post'],'/incluir-orcamentos', [App\Http\Controllers\OrcamentosController::class, 'incluir'])->name('incluir-orcamentos');
Route::match(['get', 'post'],'/alterar-orcamentos', [App\Http\Controllers\OrcamentosController::class, 'alterar'])->name('alterar-orcamentos');
Route::match(['get',],'/imprimir-orcamentos', [App\Http\Controllers\OrcamentosController::class, 'imprimir'])->name('imprimir-orcamentos');

Route::match(['get', 'post'],'/teste', [App\Http\Controllers\TestesController::class, 'index'])->name('teste');
