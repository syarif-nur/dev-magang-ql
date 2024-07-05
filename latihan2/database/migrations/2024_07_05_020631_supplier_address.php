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
        Schema::create('supplier_address', function (Blueprint $table) {
            $table->id(); // This creates a bigserial primary key with auto increment
            $table->bigInteger('supplier_id')->unsigned()->nullable(false);
            $table->string('address', 255)->nullable(false);
            $table->string('city', 255)->nullable(false);
            $table->string('state', 255)->nullable(false);
            $table->string('zipcode', 255)->nullable(false);
            $table->string('country', 255)->nullable(false);
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
