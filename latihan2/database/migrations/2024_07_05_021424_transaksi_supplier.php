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
            $table->id(); // This creates a bigserial primary key with auto increment
            $table->bigInteger('barang_id')->unsigned()->nullable(false);
            $table->bigInteger('satuan_id')->unsigned()->nullable(false);
            $table->bigInteger('company_id')->unsigned()->nullable(false);
            $table->date('transaction_date')->nullable(false);
            $table->decimal('amount', 16, 2)->nullable(false);
            $table->enum('transaction_type', ['REFUND', 'PURCHASE'])->nullable(false);
            $table->string('description', 255)->nullable(false);
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
