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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->unique(); // ID unik untuk imbasan
            $table->string('title');
            $table->string('author');
            $table->string('year')->nullable();
            $table->enum('status', ['available', 'borrowed', 'damaged', 'lost'])->default('available'); // Status semasa buku
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
