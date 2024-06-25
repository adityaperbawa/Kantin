<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Table;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;

class TableController extends Controller
{
    public function index()
{
    try {
        $tables = Table::all();
        return view('tables.index', compact('tables'));
    } catch (\Exception $e) {
        return back()->withError('Terjadi kesalahan: ' . $e->getMessage());
    }
}

    public function create()
    {
        return view('tables.create');
    }

    public function store(Request $request)
{
    // Validate data if needed
    $request->validate([
        'qr_code' => 'required',
    ]);

    // Inisialisasi objek Tabel dengan data yang benar
    $table = new Table();
    $table->qr_code = $request->input('qr_code'); // Ambil nilai qr_code dari permintaan
    $table->save();

    // Generate QR code

    return redirect()->route('tables.index')->with('success', 'Meja berhasil ditambahkan.');
}
  public function destroy($id)
    {
        // Cari meja berdasarkan ID
        $table = Table::findOrFail($id);

        // Hapus meja dari database
        $table->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('manager.tables.index')->with('success', 'Meja berhasil dihapus.');
    }
}

