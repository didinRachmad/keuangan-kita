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
        Schema::create('pengeluarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->unsignedBigInteger('id_keluarga')->nullable();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('set null');
            $table->foreign('id_keluarga')->references('id')->on('keluargas')->onDelete('set null');
            $table->text('keterangan')->nullable();
            $table->date('tgl_transaksi');
            $table->unsignedBigInteger('id_kategori')->nullable();
            $table->unsignedBigInteger('id_akun')->nullable();
            $table->unsignedBigInteger('id_pj')->nullable();
            $table->foreign('id_kategori')->references('id')->on('kategoris')->onDelete('set null');
            $table->foreign('id_akun')->references('id')->on('akuns')->onDelete('set null');
            $table->foreign('id_pj')->references('id')->on('users')->onDelete('set null');
            $table->decimal('total_transaksi', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluarans');
    }
};
