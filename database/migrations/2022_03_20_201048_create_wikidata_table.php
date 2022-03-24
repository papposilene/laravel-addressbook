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
        Schema::create('addresses__wikipedia', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->uuid('address_uuid');
            $table->string('wikidata_id', 255);
            $table->string('wikipedia_url', 255);
            $table->json('wikipedia_text');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('address_uuid')
                ->references('uuid')->on('addresses__')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses__wikipedia');
    }
};
