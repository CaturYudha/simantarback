<?php

namespace App\Http\Controllers;

use App\Models\Jurusans;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusans = Jurusans::all();
        return response()->json($jurusans);
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
            'kode_jurusan' => 'required|string|unique:jurusans',
            'nama_jurusan' => 'required|string',
            'deskripsi_jurusan' => 'nullable|string',
        ]);

        $jurusan = Jurusans::create($request->all());

        return response()->json(['message' => 'Jurusan berhasil ditambahkan', 'data' => $jurusan], 201);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jurusan = Jurusans::findOrFail($id);
        return response()->json($jurusan);
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
            'nama_jurusan' => 'sometimes|required|string',
            'deskripsi_jurusan' => 'nullable|string',
        ]);
    
        $jurusan = Jurusans::findOrFail($id);
    
        $jurusan->nama_jurusan = $request->nama_jurusan ?? $jurusan->nama_jurusan;
        $jurusan->deskripsi_jurusan = $request->deskripsi_jurusan ?? $jurusan->deskripsi_jurusan;
    
        if ($jurusan->save()) {
            return response()->json(['message' => 'Data jurusan berhasil diperbarui', 'jurusan' => $jurusan], 200);
        }
    
        return response()->json(['message' => 'Gagal memperbarui data jurusan'], 500);
    }
    


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jurusan = Jurusans::findOrFail($id);
        $jurusan->delete();

        return response()->json(['message' => 'Jurusan berhasil dihapus'], 200);
    }
}
