<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPesanan extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'menu_id', 'jumlah', 'total_harga', 'status'];
}
