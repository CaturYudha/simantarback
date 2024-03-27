<?php

namespace App\Http\Controllers;

use App\Models\Ruangans;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangans = Ruangans::all();
        return response()->json($ruangans);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'jurusan_id' => 'required|exists:jurusans,id',
            'kode_ruangan' => 'required|string|unique:ruangans',
            'nama_ruangan' => 'required|string',
            'deskripsi_ruangan' => 'nullable|string',
        ]);

        $ruangan = Ruangans::create($request->all());

        return response()->json(['message' => 'Ruangan berhasil ditambahkan', 'data' => $ruangan], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ruangan = Ruangans::findOrFail($id);
        return response()->json($ruangan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'jurusan_id' => 'required|exists:jurusans,id',
            'kode_ruangan' => 'required|string|unique:ruangans,kode_ruangan,'.$id,
            'nama_ruangan' => 'required|string',
            'deskripsi_ruangan' => 'nullable|string',
        ]);

        $ruangan = Ruangans::findOrFail($id);
        $ruangan->update($request->all());

        return response()->json(['message' => 'Ruangan berhasil diperbarui', 'data' => $ruangan], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ruangan = Ruangans::findOrFail($id);
        $ruangan->delete();

        return response()->json(['message' => 'Ruangan berhasil dihapus'], 200);
    }
}
