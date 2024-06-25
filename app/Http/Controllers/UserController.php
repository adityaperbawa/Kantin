<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Menu;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'manager')->get();
        return view('manager.users.index', ['users' => $users]);
    }

    public function create()
    {
        return view('manager.users.create');
    }

    public function store(Request $request)
    {
        // Validasi input pengguna baru
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8', // Password harus diisi dan minimal 8 karakter
            'role' => 'required|in:kasir,dapur',
        ]);
    
        // Hash password
        $hashedPassword = Hash::make($validatedData['password']);
    
        // Simpan pengguna baru ke dalam database
        User::create([
            'nama' => $validatedData['nama'],
            'email' => $validatedData['email'],
            'password' => $hashedPassword, // Simpan hash password
            'role' => $validatedData['role'],
        ]);
    
        return redirect()->route('manager.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }
    
    // Implementasikan fungsi edit, update, dan destroy sesuai kebutuhan

     public function edit(User $user)
    {
        return view('manager.users.edit', ['user' => $user]);
    }

    // Metode untuk memperbarui pengguna
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:kasir,dapur',
        ]);

        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($request->password);
        } else {
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        return redirect()->route('manager.users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Temukan pengguna berdasarkan ID
        $user = User::find($id);

        // Periksa apakah pengguna ditemukan
        if (!$user) {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan.');
        }

        // Hapus pengguna
        $user->delete();

        // Redirect ke halaman yang sesuai dan sertakan pesan sukses
        return redirect()->route('manager.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
