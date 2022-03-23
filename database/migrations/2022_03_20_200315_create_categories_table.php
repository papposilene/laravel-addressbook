<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories__', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->string('slug', 255)->primary();
            $table->string('name', 255)->unique();
            $table->string('icon_image', 255);
            $table->string('icon_style', 255);
            $table->json('translations')->nullable();
            $table->json('descriptions')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories__');
    }
};