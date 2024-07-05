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
        Schema::create('company', function (Blueprint $table) {
            $table->id(); // This creates a bigserial primary key with auto increment
            $table->bigInteger('supplier_id')->unsigned()->nullable(false);
            $table->string('company_name', 255)->nullable(false);
            $table->string('address', 255)->nullable(false);
            $table->string('city', 255)->nullable(false);
            $table->string('state', 255)->nullable(false);
            $table->string('postal_code', 255)->nullable(false);
            $table->string('country', 255)->nullable(false);
            $table->string('phone_number', 255)->nullable(false);
            $table->string('website', 255)->nullable();
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
