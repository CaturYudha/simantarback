<?php

namespace App\Http\Controllers;

use App\Models\Barangs;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barangs::all();
        return response()->json($barang);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|string|unique:barangs',
            'nama_barang' => 'required|string',
            'merek_barang' => 'nullable|string',
            'tgl_pembelian' => 'nullable|date',
            'harga_barang' => 'nullable|integer',
            'jenis_barang' => 'required|in:barang sekolah,barang jurusan',
            'jumlah_barang' => 'nullable|integer',
            'deskripsi_barang' => 'nullable|string',
            'ketersediaan' => 'nullable|in:tersedia,terpakai',
            'kondisi_barang' => 'nullable|in:baik,rusak',
            'barcode' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('barcode')) {
            try {
                $file = $request->file('barcode');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = '/uploads/barcode/' . $fileName;
                $file->move(public_path('uploads/barcode'), $fileName);

                $data['barcode'] = $filePath;

            } catch (\Exception $e) {
                return response()->json(['message' => 'Gagal mengunggah file barcode'], 500);
            }
        }

        $barang = Barangs::create($data);

        return response()->json(['message' => 'Barang berhasil ditambahkan', 'data' => $barang], 201);
    }

    public function show($id)
    {
        $barang = Barangs::findOrFail($id);
        return response()->json($barang);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'sometimes|required|string',
            'merek_barang' => 'nullable|string',
            'tgl_pembelian' => 'nullable|date',
            'harga_barang' => 'nullable|integer',
            'jenis_barang' => 'sometimes|required|in:barang sekolah,barang jurusan',
            'jumlah_barang' => 'nullable|integer',
            'deskripsi_barang' => 'nullable|string',
            'ketersediaan' => 'nullable|in:tersedia,terpakai',
            'kondisi_barang' => 'nullable|in:baik,rusak',
            'barcode' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('barcode')) {
            try {
                $file = $request->file('barcode');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = '/uploads/barcode/' . $fileName;
                $file->move(public_path('uploads/barcode'), $fileName);

                $data['barcode'] = $filePath;

            } catch (\Exception $e) {
                return response()->json(['message' => 'Gagal mengunggah file barcode'], 500);
            }
        }

        $barang = Barangs::findOrFail($id);
        $barang->update($data);

        return response()->json(['message' => 'Data barang berhasil diperbarui', 'barang' => $barang], 200);
    }

    public function destroy($id)
    {
        $barang = Barangs::findOrFail($id);
        $barang->delete();

        return response()->json(['message' => 'Barang berhasil dihapus'], 200);
    }
}
