<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BorrowingController;

Route::get('/', [BorrowingController::class, 'index']);
Route::post('/borrow', [BorrowingController::class, 'store'])->name('borrowings.store');
Route::post('/ajukan-kembali/{id}', [BorrowingController::class, 'ajukanKembali']);
Route::get('/buku/{id}', [BorrowingController::class, 'showBuku']);

Route::get('/login', [BorrowingController::class, 'login']);
Route::post('/login', [BorrowingController::class, 'authenticate']);
Route::get('/logout', [BorrowingController::class, 'logout']);

Route::get('/admin', [BorrowingController::class, 'admin']);
Route::post('/kembalikan/{id}', [BorrowingController::class, 'kembalikan']);
Route::post('/tambah-buku', [BorrowingController::class, 'tambahBuku']);
Route::delete('/hapus-buku/{id}', [BorrowingController::class, 'hapusBuku']);
Route::delete('/hapus-riwayat/{id}', [BorrowingController::class, 'hapusRiwayat']);