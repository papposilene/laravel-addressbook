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
            $table->text('address_number', 255);
            $table->text('address_street', 255);
            $table->text('address_postcode', 255);
            $table->text('address_city', 255);
            $table->point('address_lat');
            $table->point('address_lon');
            $table->string('details_openinghours', 255)->nullable();
            $table->integer('details_phone', 255)->nullable();
            $table->string('details_website', 255)->nullable();
            $table->string('details_wikidata', 255)->nullable();
            $table->text('description')->nullable();
            $table->uuid('category_uuid');
            $table->foreign('category_uuid')
                ->references('uuid')->on('categories__')->onDelete('cascade');
            $table->uuid('country_uuid');
            $table->foreign('country_uuid')
                ->references('uuid')->on('countries__')->onDelete('cascade');
            $table->integer('osm_id')->nullable();
            $table->integer('osm_place_id')->nullable();
            $table->string('gmap_pluscode', 255)->nullable();
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
        Schema::dropIfExists('addresses__');
    }
};
