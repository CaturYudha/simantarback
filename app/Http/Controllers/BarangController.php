<?php

namespace App\Http\Controllers;

use App\Models\Barangs;
use App\Models\Ruangans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
            'ruangan_id' => 'required|exists:ruangans,id',
            'kode_barang' => 'required|string|unique:barangs',
            'nama_barang' => 'required|string',
            'spesifikasi' => 'nullable|string',
            'pengadaan' => 'nullable|date',
            'jenis_barang' => 'required|in:barang sekolah,barang jurusan',
            'kuantitas' => 'nullable|integer',
            'keterangan_barang' => 'nullable|string',
            'keadaan_barang' => 'nullable|in:baik,rusak ringan,rusak sedang,rusak barat',
            // 'status_ketersediaan' => 'nullable|in:tersedia,terpakai',
            'barcode' => 'nullable|image|mimes:png|max:2048',
        ]);
    
        // $user_id = Auth::id(); // Mendapatkan ID pengguna dari token JWT
        $ruangan_id = $request->ruangan_id; // Mendapatkan ID ruangan dari permintaan
    
        // Buat barang dengan data yang diberikan
        $barang = Barangs::create([
            'user_id' => $request->user_id,
            'ruangan_id' => $ruangan_id,
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'spesifikasi' => $request->spesifikasi,
            'pengadaan' => $request->pengadaan,
            'jenis_barang' => $request->jenis_barang,
            'kuantitas' => $request->kuantitas,
            'keterangan_barang' => $request->keterangan_barang,
            'keadaan_barang' => $request->keadaan_barang,
        ]);

        $barcodeContent = [
            'kode_barang' => $barang->kode_barang,
            'nama_barang' => $barang->nama_barang,
            'spesifikasi' => $barang->spesifikasi,
            'pengadaan' => $barang->pengadaan,
            'jenis_barang' => $barang->jenis_barang,
            'kuantitas' => $barang->kuantitas,
            'keterangan_barang' => $barang->keterangan_barang,
            'keadaan_barang' => $barang->keadaan_barang,
            
            
            // Add other relevant information
        ];
        
        // Generate barcode
        $barcode = QrCode::size(300)->generate(json_encode($barcodeContent));
    
        return response()->json(['message' => 'Barang berhasil ditambahkan', 'data' => $barang], 201);

        // $data = $request->all();


        // $barang = Barangs::create($data);

        // $barang = Barangs::create($request->all());

        // // Mengambil nama ruangan
        // $namaRuangan = Ruangans::find($request->ruangan_id)->nama_ruangan;

        // // Membuat konten QR code
        // $qrCodeContent = [
        //     'kode_barang' => $barang->kode_barang,
        //     'nama_barang' => $barang->nama_barang,
        //     'spesifikasi' => $barang->spesifikasi,
        //     'pengadaan' => $barang->pengadaan,
        //     'harga_barang' => $barang->harga_barang,
        //     'jenis_barang' => $barang->jenis_barang,
        //     'kuantitas' => $barang->kuantitas,
        //     'keterangan_barang' => $barang->keterangan_barang,
        //     'lokasi_ruangan' => $namaRuangan,
        // ];

        // // Menghasilkan QR code dari konten
        // $qrCode = QrCode::size(300)->generate(json_encode($qrCodeContent));

        // // Simpan QR code ke dalam file gambar atau tempat penyimpanan lainnya
        // // Misalnya, Anda dapat menyimpannya dalam direktori public
        // $filePath = 'uploads/qrcodes/' . $barang->kode_barang . '.png';
        // $qrCode->writeFile(public_path($filePath));

        // // Simpan path QR code ke dalam database
        // $barang->barcode = $filePath;

        // $barang->save();

        // return response()->json(['message' => 'Barang berhasil ditambahkan', 'data' => $barang], 201);
    }

    public function show($id)
    {
        $barang = Barangs::findOrFail($id);
        return response()->json($barang);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ruangan_id' => 'required|exists:ruangans,id',
            'user_id' => 'required|exists:users,id',
            'nama_barang' => 'sometimes|required|string',
            'spesifikasi' => 'nullable|string',
            'pengadaan' => 'nullable|date',
            'jenis_barang' => 'sometimes|required|in:barang sekolah,barang jurusan',
            'kuantitas' => 'nullable|integer',
            'keterangan_barang' => 'nullable|string',
            // 'status_ketersediaan' => 'nullable|in:tersedia,terpakai',
            'keadaan_barang' => 'nullable|in:baik,rusak ringan,rusak sedang,rusak berat',
            'barcode' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $barang = Barangs::findOrFail($id);
        $barang->update($request->all());

        // // Mengambil nama ruangan
        // $namaRuangan = Ruangans::find($request->ruangan_id)->nama_ruangan;

        // // Membuat konten QR code
        // $qrCodeContent = [
        //     'kode_barang' => $barang->kode_barang,
        //     'nama_barang' => $barang->nama_barang,
        //     'spesifikasi' => $barang->spesifikasi,
        //     'pengadaan' => $barang->pengadaan,
        //     'harga_barang' => $barang->harga_barang,
        //     'jenis_barang' => $barang->jenis_barang,
        //     'kuantitas' => $barang->kuantitas,
        //     'keterangan_barang' => $barang->keterangan_barang,
        //     'lokasi_ruangan' => $namaRuangan,
        // ];

        // // Menghasilkan QR code dari konten
        // $qrCode = QrCode::size(300)->generate(json_encode($qrCodeContent));

        // // Menghapus QR code lama jika ada
        // if (file_exists(public_path($barang->barcode))) {
        //     unlink(public_path($barang->barcode));
        // }

        // // Simpan QR code ke dalam file gambar atau tempat penyimpanan lainnya
        // $filePath = 'uploads/qrcodes/' . $barang->kode_barang . '.png';
        // $qrCode->writeFile(public_path($filePath));

        // // Simpan path QR code ke dalam database
        // $barang->barcode = $filePath;
        // $barang->save();

        return response()->json(['message' => 'Data barang berhasil diperbarui', 'barang' => $barang], 200);
    }

    public function destroy($id)
    {
        $barang = Barangs::findOrFail($id);
        $barang->delete();

        return response()->json(['message' => 'Barang berhasil dihapus'], 200);
    }
}
