<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Mid;

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
    return view('welcome');
})->name('menu')->middleware('AccessLevel');

Route::resource('curso','CursoController');

Route::resource('professor','ProfessorController');

Route::resource('disciplina','DisciplinaController');

Route::resource('aluno','AlunoController');

Route::resource('matricula','MatriculaController');

Route::get('negado','NegadoController@index')->name('negado');


