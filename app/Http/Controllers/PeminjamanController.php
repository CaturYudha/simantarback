<?php

namespace App\Http\Controllers;

use App\Models\Peminjamans;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjamans::all();
        return response()->json($peminjamans);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama_peminjam' => 'required|string',
            'tgl_peminjaman' => 'required|date',
            'tgl_pengembalian' => 'nullable|date',
            'keterangan' => 'nullable|string',
            'jumlah' => 'nullable|integer',
            'status_peminjaman' => 'nullable|in:dipinjam,dikembalikan',
            'status_pengajuan' => 'nullable|in:disetujui,tidak disetujui',
        ]);

        $peminjaman = Peminjamans::create($request->all());

        return response()->json(['message' => 'Peminjaman berhasil ditambahkan', 'data' => $peminjaman], 201);
    }

    public function show($id)
    {
        $peminjaman = Peminjamans::findOrFail($id);
        return response()->json($peminjaman);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama_peminjam' => 'sometimes|required|string',
            'tgl_peminjaman' => 'sometimes|required|date',
            'tgl_pengembalian' => 'sometimes|required|date',
            'keterangan' => 'nullable|string',
            'jumlah' => 'nullable|integer',
            'status_peminjaman' => 'nullable|required|in:dipinjam,dikembalikan',
            'status_pengajuan' => 'nullable|required|in:disetujui,tidak disetujui',
        ]);

        $peminjaman = Peminjamans::findOrFail($id);
        $peminjaman->update($request->all());

        return response()->json(['message' => 'Data peminjaman berhasil diperbarui', 'peminjaman' => $peminjaman], 200);
    }

    public function destroy($id)
    {
        $peminjaman = Peminjamans::findOrFail($id);
        $peminjaman->delete();

        return response()->json(['message' => 'Peminjaman berhasil dihapus'], 200);
    }
}
