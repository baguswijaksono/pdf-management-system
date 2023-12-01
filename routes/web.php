<?php
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\BookController;



Route::middleware(['auth'])->group(function(){
    
    Route::get('/', [HomeController::class, 'index'])->name('home');// Done Sepenuhnya

    Route::get('/books/{id}/details', [BookController::class, 'bookDetails'])->name('book.details');

    

    Route::get('/books', [BookController::class, 'index'])->name('book');
    Route::get('/books/add', [BookController::class, 'bookAdd'])->name('book.add');// Done Sepenuhnya
    Route::post('/books/add/save', [BookController::class, 'bookAddSave'])->name('book.add.save');
    Route::get('/books/{bookId}/edit', [BookController::class, 'bookEdit'])->name('book.edit');
    Route::post('/books/edit/save', [BookController::class, 'bookUpdateSave'])->name('book.edit.save');
    Route::post('/books/delete', [BookController::class, 'bookDelete'])->name('book.delete');// Done Sepenuhnya

    Route::get('/category', [CategoryController::class, 'index'])->name('category');
    Route::get('/category/add', function () {return view('user.category.add');})->name('category.add');// Done Sepenuhnya
    Route::post('/category/add/save', [CategoryController::class, 'categoryAddSave'])->name('category.add.save');
    Route::get('/category/{categoryId}/edit', [CategoryController::class, 'categoryEdit'])->name('category.edit');
    Route::post('/category/edit/save', [CategoryController::class, 'categoryUpdateSave'])->name('category.edit.save');
    Route::post('/category/delete', [CategoryController::class, 'categoryDelete'])->name('category.delete');

    Route::get('/category/{category}', [BookController::class, 'specifyCategory'])->name('category.specify');

    Route::get('/excelexport', [ExportController::class, 'exportToExcel'])->name('ex.export');

    Route::get('/private/img/{imageName}',  [FileController::class, 'showimage'])->name('img.show');
    Route::get('/private/pdf/{pdfName}',  [FileController::class, 'showpdf'])->name('pdf.show');

});


// admin
Route::middleware('admin')->group(function () {

    Route::get('/admin', [AdminController::class, 'index'])->name('admin');//Done Sepenuhnya

    Route::get('/user/{userId}/book', [AdminController::class, 'userBooks'])->name('user.books');//Done Sepenuhnya
    Route::get('/user/{userId}/category', [AdminController::class, 'userCategory'])->name('user.category');//Done Sepenuhnya
    Route::get('/user/{userId}/category/{category}', [AdminController::class, 'userSpecifyCategory'])->name('user.category.specify');



});

Auth::routes();
