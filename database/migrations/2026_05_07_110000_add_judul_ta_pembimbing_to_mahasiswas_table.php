<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->string('judul_ta')->nullable()->after('foto_profil');
            $table->unsignedBigInteger('pembimbing1_id')->nullable()->after('judul_ta');
            $table->unsignedBigInteger('pembimbing2_id')->nullable()->after('pembimbing1_id');

            $table->foreign('pembimbing1_id')->references('id')->on('dosens')->onDelete('set null');
            $table->foreign('pembimbing2_id')->references('id')->on('dosens')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->dropForeign(['pembimbing1_id']);
            $table->dropForeign(['pembimbing2_id']);
            $table->dropColumn(['judul_ta', 'pembimbing1_id', 'pembimbing2_id']);
        });
    }
};
