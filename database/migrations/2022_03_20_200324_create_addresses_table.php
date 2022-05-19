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
            $table->uuid()->primary();
            $table->string('place_name', 255);
            $table->boolean('place_status')->default(1);
            $table->string('address_number', 255)->nullable();
            $table->string('address_street', 255)->nullable();
            $table->string('address_postcode', 255)->nullable();
            $table->string('address_city', 255)->nullable();
            $table->uuid('city_uuid')->nullable();
            $table->uuid('region_uuid')->nullable();
            $table->string('country_cca3', 3);
            $table->decimal('address_lat', 20, 16);
            $table->decimal('address_lon', 20, 16);
            $table->text('description')->nullable();
            $table->json('details')->nullable();
            $table->uuid('subcategory_slug');
            $table->string('osm_id', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('city_uuid')
                ->references('uuid')
                ->on('geodata__cities')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('region_uuid')
                ->references('uuid')
                ->on('geodata__regions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('country_cca3')
                ->references('cca3')
                ->on('geodata__countries')
                ->onDelete('cascade');
            $table->foreign('subcategory_slug')
                ->references('slug')
                ->on('categories__subcategories')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
