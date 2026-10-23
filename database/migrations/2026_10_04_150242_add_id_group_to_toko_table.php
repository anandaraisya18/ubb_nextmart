<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('toko', function (Blueprint $table) {

            // Samakan tipe dengan management_group.id_group
            $table->integer('id_group')
                ->nullable()
                ->change();

            // Buat foreign key
            $table->foreign('id_group')
                ->references('id_group')
                ->on('management_group')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('toko', function (Blueprint $table) {

            $table->dropForeign(['id_group']);

        });
    }
};