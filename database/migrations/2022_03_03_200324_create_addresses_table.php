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
        Schema::create('addresses__', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('place_name', 255);
            $table->boolean('place_status')->default(1);
            $table->string('address_number', 255)->nullable();
            $table->string('address_street', 255)->nullable();
            $table->string('address_postcode', 255)->nullable();
            $table->uuid('address_city');
            $table->string('address_country', 3);
            $table->float('address_lat');
            $table->float('address_lon');
            $table->text('descriptions')->nullable();
            $table->json('details')->nullable();
            $table->uuid('subcategory_slug');
            $table->integer('osm_id')->nullable();
            $table->integer('osm_place_id')->nullable();
            $table->string('gmap_pluscode', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('address_city')
                ->references('uuid')->on('geodata__cities')->onDelete('cascade');
            $table->foreign('address_country')
                ->references('cca3')->on('geodata__countries')->onDelete('cascade');
            $table->foreign('subcategory_slug')
                ->references('slug')->on('categories__subcategories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses__');
    }
};
