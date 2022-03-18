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
        Schema::create('categories__subcategories', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('slug', 255)->unique();
            $table->string('name', 255)->unique();
            $table->string('icon_image', 255);
            $table->string('icon_options', 255);
            $table->json('translation')->nullable();
            $table->json('description')->nullable();
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
        Schema::dropIfExists('categories__subcategories');
    }
};
