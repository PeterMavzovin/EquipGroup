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
        Schema::create('prices', function (Blueprint $table) {
            $table->increments('id'); // int(11) NOT NULL AUTO_INCREMENT
            $table->integer('id_product'); // int(11) NOT NULL
            $table->double('price', 10, 2); // double(10,2) NOT NULL
            $table->index('id_product'); // KEY `id_product` (`id_product`)
            // created_at и updated_at отсутствуют
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};