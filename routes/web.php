<?php

use App\Exports\TablesExportSheet;
use App\Livewire\Auth\Login;
use App\Livewire\Pages\Auditorias;
use App\Livewire\Pages\Bandeira;
use App\Livewire\Pages\Colaboradores;
use App\Livewire\Pages\Grupos;
use App\Livewire\Pages\Home;
use App\Livewire\Pages\Unidade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/login', Login::class)->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/', Home::class);
    Route::get('/home', Home::class)->name('home');
    Route::get('/grupos', Grupos::class)->name('grupos');
    Route::get('/grupos/{grupo}/bandeira/', Bandeira::class)->name('bandeira');
    Route::get('/grupos/{grupo}/bandeira/{bandeira}/unidade', Unidade::class)->name('unidade');
    Route::get('/grupos/{grupo}/bandeira/{bandeira}/unidade/{unidade}/colaborador', Colaboradores::class)->name('colaborador');
    Route::get('/auditorias', Auditorias::class)->name('auditorias');
    Route::get('/export-data', function () {
        return Excel::download(new TablesExportSheet, 'DADOS' . now()->format('YmdHis') . '.xlsx');
    })->name('export');
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');
