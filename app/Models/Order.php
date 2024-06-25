<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
    protected $fillable = ['nama_pelanggan', 'table_id' , 'menu_id', 'harga', 'metode_pembayaran', 'status'];

    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_COMPLETED = 'completed';
    
}
