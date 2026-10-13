<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Http\Resources\TagihanResource;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    public function index()
    {
        $tagihan = Tagihan::with(['warga', 'pencatatanMeter'])->latest()->get();
        return TagihanResource::collection($tagihan);
    }
 
    public function bayar($id)
    {
        $tagihan = Tagihan::findOrFail($id);
 
        if ($tagihan->status_pembayaran === 'lunas') {
            return response()->json(['message' => 'Tagihan sudah lunas sebelumnya.'], 400);
        }
 
        $tagihan->update([
            'status_pembayaran' => 'lunas',
            'tanggal_bayar'     => now(),
        ]);
 
        return response()->json([
            'message' => 'Pembayaran berhasil dikonfirmasi.',
            'data' => new TagihanResource($tagihan)
        ], 200);
    }

}
