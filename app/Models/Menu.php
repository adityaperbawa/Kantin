<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    // Define the table name if it's not the plural form of the model name
    protected $table = 'menu';

    // Specify which attributes are mass assignable
    protected $fillable = [
        'nama', 'gambar', 'deskripsi', 'harga', 'stok', 'qr_code',
    ];
}

