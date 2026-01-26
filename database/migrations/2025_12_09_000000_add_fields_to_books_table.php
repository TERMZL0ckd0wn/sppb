<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('books')) {
            Schema::create('books', function (Blueprint $table) {
                $table->id();
                $table->string('barcode')->nullable()->unique();
                $table->string('title')->nullable();
                $table->string('author')->nullable();
                $table->integer('year')->nullable();
                $table->string('status')->default('tersedia');
                $table->timestamps();
            });
            return;
        }

        Schema::table('books', function (Blueprint $table) {
            if (!Schema::hasColumn('books', 'barcode')) $table->string('barcode')->nullable()->unique();
            if (!Schema::hasColumn('books', 'title'))   $table->string('title')->nullable();
            if (!Schema::hasColumn('books', 'author'))  $table->string('author')->nullable();
            if (!Schema::hasColumn('books', 'year'))    $table->integer('year')->nullable();
            if (!Schema::hasColumn('books', 'status'))  $table->string('status')->default('tersedia');
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $cols = ['barcode','title','author','year','status'];
            foreach ($cols as $c) {
                if (Schema::hasColumn('books', $c)) $table->dropColumn($c);
            }
        });
    }
};