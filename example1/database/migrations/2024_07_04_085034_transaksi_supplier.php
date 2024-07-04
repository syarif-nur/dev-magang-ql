<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi_supplier', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('barang_id');
            $table->bigInteger('satuan_id');
            $table->bigInteger('company_id');
            $table->date('transaction_date');
            $table->decimal('amount');
            $table->string('transaction_type');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
