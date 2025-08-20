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
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id'); // int(11) NOT NULL AUTO_INCREMENT
            $table->integer('id_parent')->default(0); // int(11) NOT NULL (DEFAULT 0 added for consistency with products)
            $table->string('name', 100); // varchar(100) CHARACTER SET utf8mb3 NOT NULL
            // Согласно test.sql, created_at и updated_at отсутствуют
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};