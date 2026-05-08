<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('subject')->nullable()->after('topik');
            $table->string('presensi')->nullable()->after('subject');
            $table->text('uraian')->nullable()->after('presensi');
        });

        // Change status enum to include 'Revisi'
        DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('Menunggu','Disetujui','Revisi','Ditolak','Selesai') DEFAULT 'Menunggu'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('Menunggu','Disetujui','Ditolak','Selesai') DEFAULT 'Menunggu'");

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['subject', 'presensi', 'uraian']);
        });
    }
};
