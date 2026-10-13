<?php

use App\Http\Controllers\WargaController;
use App\Http\Controllers\PencatatanMeterController;
use App\Http\Controllers\TagihanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/warga', [WargaController::class, 'index']);
Route::post('/warga', [WargaController::class, 'store']);
 
Route::post('/pencatatan-meter', [PencatatanMeterController::class, 'store']);
 
Route::get('/tagihan', [TagihanController::class, 'index']);
Route::patch('/tagihan/{id}/bayar', [TagihanController::class, 'bayar']);