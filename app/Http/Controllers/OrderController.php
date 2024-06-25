<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\Menu;
use App\Models\Table;

class OrderController extends Controller
{
    // Menyimpan pesanan baru
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_pelanggan' => 'required|string|max:255',
            'table_qr_code' => 'required|exists:tables,qr_code',
            'menu_ids' => 'required|string',
            'metode_pembayaran' => 'required|string|max:255',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Ambil data dari formulir
        $namaPelanggan = $request->input('nama_pelanggan');
        $tableQrCode = $request->input('table_qr_code');
        $menuIds = explode(',', $request->input('menu_ids'));
        $metodePembayaran = $request->input('metode_pembayaran');

        // Temukan meja berdasarkan qr_code
        $table = Table::where('qr_code', $tableQrCode)->first();

        // Pastikan meja ditemukan
        if (!$table) {
            return redirect()->back()->with('error', 'Meja tidak ditemukan.');
        }

        // Hitung total harga pesanan
        $totalPrice = 0;

        // Simpan setiap item pesanan ke dalam database dan hitung total harga
        foreach ($menuIds as $menuId) {
            $menu = Menu::find($menuId);

            // Pastikan menu ditemukan
            if (!$menu) {
                return redirect()->back()->with('error', 'Menu tidak ditemukan.');
            }

            // Pastikan stok mencukupi
            if ($menu->stok <= 0) {
                return redirect()->back()->with('error', 'Stok untuk ' . $menu->nama . ' sudah habis.');
            }

            // Kurangi stok menu
            $menu->stok--;
            $menu->save();

            // Tambahkan harga menu ke total harga
            $totalPrice += $menu->harga;

            // Simpan pesanan ke dalam database
            $order = new Order();
            $order->nama_pelanggan = $namaPelanggan;
            $order->table_id = $table->id;
            $order->menu_id = $menu->id;
            $order->harga = $menu->harga;
            $order->metode_pembayaran = $metodePembayaran;
            $order->status = 'Pending';

            // Tambahkan log untuk melacak operasi penyimpanan data
            if ($order->save()) {
                \Log::info('Pesanan baru disimpan: ' . $order->id);
            } else {
                \Log::error('Gagal menyimpan pesanan baru.');
                return redirect()->back()->with('error', 'Gagal menyimpan pesanan baru. Silakan coba lagi.');
            }
        }

        return redirect()->back()->with('success', 'Pesanan Anda telah berhasil diterima. Total harga pesanan: Rp ' . $totalPrice . '. Silakan lanjutkan pembayaran.');
    }

    public function kasir()
    {
        // Ambil data pesanan yang belum dibayar
        $orders = Order::where('status', 'Pending')->get();
        
        // Tampilkan halaman kasir dengan data pesanan
        return view('kasir.dashboard', compact('orders'));
    }
public function pay($id) {
    $order = Order::findOrFail($id);
    $order->status = 'Paid';
    $order->save();

    return redirect()->back()->with('success', 'Pesanan telah dibayar.');
}
public function payMultiple(Request $request)
{
    // Validasi request
    $request->validate([
        'order_ids' => 'required|array',
        'order_ids.*' => 'exists:orders,id',
    ]);

    // Ambil ID pesanan yang akan dibayar
    $orderIds = $request->input('order_ids');

    // Ubah status pesanan menjadi 'Paid'
    Order::whereIn('id', $orderIds)->update(['status' => 'Paid']);

    // Simpan notifikasi sukses
    session()->flash('success', 'Pesanan telah dibayar dan dikirim ke bagian dapur.');

    return redirect()->route('kasir.dashboard'); // Ganti dengan route yang sesuai
}

public function dapur()
{
    // Ambil data pesanan yang sudah dibayar
    $orders = Order::where('status', 'Paid')->get();
    
    // Tampilkan halaman dapur dengan data pesanan
    return view('dapur.dashboard', compact('orders'));
}

    // Mark order as completed
    public function completeOrder($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
        }

        $order->status = 'Completed';
        $order->save();

        return redirect()->back()->with('success', 'Pesanan telah selesai.');
    }
    public function orderHistory()
{
    // Fetch completed orders
    $completedOrders = Order::where('status', 'completed')->get();

    // Return the view with the completed orders data
    return view('riwayat_pesanan', compact('completedOrders'));
}
public function index()
    {
        // Logika untuk menampilkan riwayat pesanan
        $completedOrders = Order::where('status', 'completed')->get();
        return view('orders.index', compact('completedOrders'));
    }

    public function search(Request $request)
    {
        $query = Order::query();

        // Filter berdasarkan tanggal mulai jika disediakan
        if ($request->filled('tanggalMulai')) {
            $query->whereDate('created_at', '>=', $request->tanggalMulai);
        }

        // Filter berdasarkan tanggal selesai jika disediakan
        if ($request->filled('tanggalSelesai')) {
            $query->whereDate('created_at', '<=', $request->tanggalSelesai);
        }

        // Filter berdasarkan nama pelanggan jika disediakan
        if ($request->filled('namaPelanggan')) {
            $query->where('nama_pelanggan', 'like', '%' . $request->namaPelanggan . '%');
        }

        // Ambil pesanan yang sudah selesai
        $completedOrders = $query->where('status', 'completed')->get();

        // Kembalikan hasil pencarian ke halaman riwayat pesanan
        return view('riwayat_pesanan', compact('completedOrders'));
    }
public function destroy($id)
{
    // Temukan pesanan berdasarkan ID
    $order = Order::find($id);

    // Periksa apakah pesanan ditemukan
    if (!$order) {
        return redirect()->back()->with('error', 'Riwayat pesanan tidak ditemukan.');
    }

    // Hapus pesanan
    $order->delete();

    // Redirect kembali ke halaman yang sesuai dan sertakan pesan sukses
    return redirect()->route('order.history')->with('success', 'Riwayat pesanan berhasil dihapus.');
}
}
