<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kategori', function (Blueprint $table) {
            $table->unsignedBigInteger('id_group')->nullable()->after('id_kategori');
        });

        // Isi otomatis kategori lama berdasarkan group toko dari produk yang memakainya.
        DB::statement('
            UPDATE kategori SET id_group = (
                SELECT t.id_group 
                FROM produk p 
                JOIN toko t ON p.id_toko = t.id_toko 
                WHERE p.id_kategori = kategori.id_kategori 
                LIMIT 1
            )
        ');
    }

    public function down(): void
    {
        Schema::table('kategori', function (Blueprint $table) {
            $table->dropColumn('id_group');
        });
    }
};