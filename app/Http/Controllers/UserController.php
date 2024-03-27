<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
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
            'username' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
            'nama_user' => 'required|string',
            'no_hp' => 'required|string',
            'ttd' => 'nullable|image|mimes:png|max:2048', // Format PNG, maksimum ukuran 2MB
            'role' => 'required|string|in:admin,sarpras,ketua_program,kepsek,guru,siswa',
        ], [
            'username.required' => 'Username harus diisi.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal terdiri dari 6 karakter.',
            'nama_user.required' => 'Nama user harus diisi.',
            'ttd.image' => 'TTD harus berupa file gambar.',
            'ttd.mimes' => 'Format TTD harus PNG.',
            'ttd.max' => 'Ukuran TTD tidak boleh lebih dari 2MB.',
            'role.required' => 'Role harus dipilih.',
            'role.in' => 'Role yang dipilih tidak valid.',
        ]);

        $data = $request->all();

        // Jika ada file gambar yang diunggah
        if ($request->hasFile('ttd')) {
            // Simpan gambar ke direktori yang telah ditentukan
            $file = $request->file('ttd');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = '/uploads/ttd/' . $fileName;
            $file->move(public_path('uploads/ttd'), $fileName);

            // Simpan path penyimpanan gambar di dalam kolom 'ttd' di database
            $data['ttd'] = $filePath;

            // URL gambar untuk ditampilkan di frontend
            $imageUrl = url($filePath);

        }

        // Simpan data user ke dalam database
        $user = User::create($data);

        return response()->json(['message' => 'Data user berhasil ditambahkan', 'user' => $user, 'ttd_url' => $imageUrl],  201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
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
            'username' => 'sometimes|required|string|unique:users,username,'.$id, // Menjadikan username opsional
            // Tambahkan aturan validasi opsional untuk bidang-bidang lainnya
            'nama_user' => 'sometimes|required|string',
            'no_hp' => 'sometimes|required|string',
            'ttd' => 'nullable|image|mimes:png|max:2048',
            'role' => 'sometimes|required|string|in:admin,sarpras,ketua_program,kepsek,guru,siswa',
        ]);

        $user = User::findOrFail($id);
        if ($request->has('password')) {
            $request->validate([
                'password' => 'required|string|min:6',
            ]);
            // Enkripsi dan simpan password baru jika ada input password baru
            $user->password = bcrypt($request->password);
        } else {
            // Biarkan password tetap sama jika tidak ada input password baru
            $user->password = $user->password;
        }

        // Jika ada file gambar yang diunggah
        if ($request->hasFile('ttd')) {
            // Simpan gambar ke direktori yang telah ditentukan
            $file = $request->file('ttd');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = '/uploads/ttd/' . $fileName;
            $file->move(public_path('uploads/ttd'), $fileName);

            // Simpan path penyimpanan gambar di dalam kolom 'ttd' di database
            $user->ttd = $filePath;

            // URL gambar untuk ditampilkan di frontend
            $imageUrl = url($filePath);
        } else {
            // Jika tidak ada file gambar yang diunggah, gunakan gambar TTD yang lama
            $imageUrl = $user->ttd;
        }



        $user->username = $request->username;
        $user->nama_user = $request->nama_user;
        $user->no_hp = $request->no_hp;
        $user->role = $request->role;

        // Coba simpan perubahan data user
        if ($user->save()) {
            return response()->json(['message' => 'Data user berhasil diperbarui', 'user' => $user, 'ttd_url' => $imageUrl], 200);
        } else {
            return response()->json(['message' => 'Gagal memperbarui data user'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        if ($user) {
            return response()->json(['message' => 'Data user berhasil dihapus'], 200);
        } else {
            return response()->json(['message' => 'Gagal menghapus data user'], 400);
        }
    }
}
