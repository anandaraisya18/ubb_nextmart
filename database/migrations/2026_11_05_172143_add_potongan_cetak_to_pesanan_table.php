<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->decimal('total_awal', 12, 2)->nullable()->after('total');
            $table->decimal('potongan_cetak', 12, 2)->default(0)->after('total_awal');
            $table->boolean('selesai_otomatis')->default(false)->after('potongan_cetak');
        });
    }

    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropColumn(['total_awal', 'potongan_cetak', 'selesai_otomatis']);
        });
    }
};