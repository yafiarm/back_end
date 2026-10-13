<?php

namespace App\Http\Controllers;

use App\Models\PencatatanMeter;
use App\Models\Warga;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PencatatanMeterController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'warga_id'      => 'required|exists:warga,id',
            'bulan_tahun'   => 'required|string',
            'meter_awal'    => 'required|numeric|min:0',
            'meter_akhir'   => 'required|numeric|gte:meter_awal',
            'tanggal_catat' => 'required|date',
        ]);
 
        // 1. Hitung total pemakaian air
        $totalPemakaian = $validated['meter_akhir'] - $validated['meter_awal'];
        $validated['total_pemakaian'] = $totalPemakaian;
 
        // 2. Simpan pencatatan meter
        $pencatatan = PencatatanMeter::create($validated);
 
        // 3. Logika Otomatisasi Tagihan
        $warga = Warga::with('kategoriTarif')->findOrFail($validated['warga_id']);
        $tarifPerKubik = $warga->kategoriTarif->tarif_per_kubik;
        $biayaBeban = $warga->kategoriTarif->biaya_pemeliharaan;
 
        $totalBiaya = ($totalPemakaian * $tarifPerKubik) + $biayaBeban;
        $nomorTagihan = 'INV/' . str_replace('-', '', $validated['bulan_tahun']) . '/' . $warga->nomor_rumah;
 
        // 4. Terbitkan record tagihan otomatis
        $tagihan = Tagihan::create([
            'pencatatan_meter_id' => $pencatatan->id,
            'warga_id'            => $warga->id,
            'nomor_tagihan'       => $nomorTagihan,
            'total_tagihan'       => $totalBiaya,
            'status_pembayaran'   => 'belum_bayar',
            'tanggal_tenggat'     => now()->addDays(15)->format('Y-m-d'),
        ]);
 
        return response()->json([
            'message' => 'Pencatatan meter berhasil disimpandan tagihan otomatis diterbitkan.',
            'pencatatan' => $pencatatan,
            'tagihan' => $tagihan
        ], 201);
    }

}
