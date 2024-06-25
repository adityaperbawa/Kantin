<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggan');
            $table->foreignId('table_id')->constrained(); // Kolom untuk menyimpan ID meja tempat pelanggan duduk
            $table->foreignId('menu_id')->constrained('menu');
            $table->decimal('harga', 10, 0);
            $table->string('metode_pembayaran');
            $table->string('status')->default('pending'); // default status 'pending'
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

