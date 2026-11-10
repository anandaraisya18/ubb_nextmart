<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_prints', function (Blueprint $table) {
            $table->id();

            $table->integer('id_detail');

            $table->string('nama_file');
            $table->string('path_file');

            $table->integer('jumlah_halaman')->default(0);
            $table->text('halaman_dipilih')->nullable();

            $table->integer('halaman_hitam_putih')->default(0);
            $table->integer('halaman_warna')->default(0);

            $table->integer('jumlah_cetak')->default(1);
            $table->decimal('total_harga', 12, 2)->default(0);

            $table->enum('status_verifikasi', [
                'menunggu_verifikasi',
                'disetujui',
                'perlu_revisi',
            ])->default('menunggu_verifikasi');

            $table->text('catatan_admin')->nullable();

            $table->timestamps();

            $table->foreign('id_detail')
                ->references('id_detail')
                ->on('detail_pesanan')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_prints');
    }
};