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
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->text("descripsi");
            $table->string("harga");
            $table->string("kondisi");
            $table->string("alamat");
            $table->integer('views')->default(0); // Set default ke 0
            $table->boolean("verified")->default(0);
            $table->boolean("revisi")->default(0);
            $table->unsignedBigInteger("image_id");
            $table->unsignedBigInteger("status_id")->default(1);
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("kategori_id");
            $table->foreign("image_id")->references("id")->on("images")->onDelete('cascade');
            $table->foreign("status_id")->references("id")->on("statuses");
            $table->foreign("user_id")->references("id")->on("users")->onDelete('cascade');
            $table->foreign("kategori_id")->references("id")->on("kategoris");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
