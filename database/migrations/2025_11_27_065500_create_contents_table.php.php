<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
Schema::create('contents', function (Blueprint $table) {
    $table->id(); 
    $table->string('nama_file');      // contoh: "Statistik Indonesia 2025"
    $table->string('file');           // contoh: "statistik2025.jpg"
    $table->string('tipe_file');      // contoh: "image/jpg" atau "video/mp4"
    $table->timestamps();
});

}


};
