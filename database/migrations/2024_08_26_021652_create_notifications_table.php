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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string("message")->nullable();
            $table->text("image")->nullable();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("produk_id")->nullable();
            $table->enum('tujuan', ['admin', 'reseller'])->default('reseller');
            $table->enum('action', ['product', 'store', 'data'])->default('product');
            $table->enum('submit', ['cancel', 'confirm'])->default('cancel');
            $table->timestamp('reat_at')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Menghapus notifikasi jika pengguna dihapus (opsional, sesuaikan dengan kebutuhan).
            $table->foreign('produk_id')->references('id')->on('produks')->onDelete('cascade'); // Mengatur produk_id menjadi NULL jika produk terkait dihapus (opsional, sesuaikan dengan kebutuhan).
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
