
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_log', function (Blueprint $table) {
            $table->id();

            // Identitas aktor
            $table->string('actor_type', 30)->index();
            $table->unsignedBigInteger('actor_id')->nullable()->index();
            $table->string('actor_name')->nullable();

            // Aktivitas yang dilakukan
            $table->string('action', 50)->index();

            // Data yang menjadi target aktivitas
            $table->string('target_type')->nullable()->index();
            $table->string('target_id', 100)->nullable()->index();

            // Detail aktivitas
            $table->text('description');
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();

            // Informasi permintaan
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();

            // Status aktivitas
            $table->string('status', 20)->default('success')->index();

            // Hanya waktu pembuatan, tanpa updated_at
            $table->timestamp('created_at')->useCurrent()->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_log');
    }
};