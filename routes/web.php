<?php

use App\Livewire\Expense\Create;
use App\Livewire\Expense\Edit;
use App\Livewire\Expense\Index;
use App\Livewire\Expense\Category\Create as CategoryCreate;
use App\Livewire\Expense\Category\Edit as CategoryEdit;
use App\Livewire\Expense\Category\Index as CategoryIndex;
use App\Livewire\Expense\Category\View as CategoryView;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::prefix('expense')->group(function () {
        Route::get('', Index::class)->name('expense.index');
        Route::get('create', Create::class)->name('expense.create');
        Route::get('edit/{id}', Edit::class)->name('expense.edit');
    });

    Route::prefix('category')->group(function () {
        Route::get('', CategoryIndex::class)->name('category.index');
        Route::get('create', CategoryEdit::class)->name('category.create');
        Route::get('edit/{id}', CategoryEdit::class)->name('category.edit');
        Route::get('view/{id}', CategoryView::class)->name('category.view');
    });
});
