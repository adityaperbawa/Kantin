<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;
use App\Models\Table;

class MenuController extends Controller
{
    public function showMenu(Request $request)
    {
        // Ambil nilai table dari query string
        $table = $request->query('table');
        
        // Mengambil data menu
        $menu = Menu::all();
        
        // Kembalikan tampilan menu dengan menyertakan nilai table
        return view('menu.show', compact('menu', 'table'));
    }
    public function showMenuPelanggan(Request $request)
    {
        // Ambil nilai table dari query string
        $table = $request->query('table');
        
        // Mengambil data menu
        $menu = Menu::all();
        
        // Kembalikan tampilan menu dengan menyertakan nilai table
        return view('menu.order', compact('menu', 'table'));
    }

    public function create()
    {
        return view('menu.create');
    }

    public function store(Request $request)
    {
        // Validasi data yang dikirimkan oleh formulir
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif', // Batasi jenis file gambar yang diizinkan dan ukuran maksimumnya
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        // Simpan gambar ke dalam direktori storage/app/public/images
        $gambarPath = $request->file('gambar')->store('images', 'public');

        // Buat entri baru di database untuk menu dengan informasi yang diterima dari formulir
        $menu = new Menu();
        $menu->nama = $validatedData['nama'];
        $menu->gambar = $gambarPath; // Simpan path gambar dalam database
        $menu->deskripsi = $validatedData['deskripsi'];
        $menu->harga = $validatedData['harga'];
        $menu->stok = $validatedData['stok'];
        $menu->save();

        // Redirect kembali ke halaman tambah menu dengan pesan sukses
        return redirect()->route('menu.create')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // Temukan menu berdasarkan ID
        $menu = Menu::findOrFail($id);
        return view('menu.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang dikirimkan oleh formulir
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif', // Mengizinkan gambar opsional
        ]);
    
        // Temukan menu berdasarkan ID
        $menu = Menu::findOrFail($id);
    
        // Update informasi menu dengan data yang diterima dari formulir
        $menu->nama = $validatedData['nama'];
        $menu->deskripsi = $validatedData['deskripsi'];
        $menu->harga = $validatedData['harga'];
        $menu->stok = $validatedData['stok'];
    
        // Jika ada gambar baru yang diunggah, perbarui gambar
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            Storage::delete('public/' . $menu->gambar);
            
            // Simpan gambar baru
            $gambarPath = $request->file('gambar')->store('images', 'public');
            $menu->gambar = $gambarPath;
        }
    
        // Simpan perubahan
        $menu->save();
    
        // Redirect kembali ke halaman edit menu dengan pesan sukses
        return redirect()->route('menu.edit', $menu->id)->with('success', 'Menu berhasil diperbarui.');
    }
    public function destroy($id)
{
    $table = Menu::findOrFail($id);

    // Hapus meja dari database
    $table->delete();

    // Redirect dengan pesan sukses
    return redirect()->back()->with('success', 'Menu berhasil dihapus.');
}

}
