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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id'); // int(11) NOT NULL AUTO_INCREMENT
            $table->integer('id_group')->default(0); // int(11) NOT NULL DEFAULT 0
            $table->string('name', 250); // varchar(250) CHARACTER SET utf8mb3 NOT NULL
            $table->index('id_group'); // KEY `id_group` (`id_group`)
            // created_at и updated_at отсутствуют
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};