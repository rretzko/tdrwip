<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->primary();
            $table->text('address01', 255)->nullable();
            $table->text('address02', 255)->nullable();
            $table->text('city', 255)->nullable();
            $table->foreignId('geostate_id')->default(37)->constrained();
            $table->text('postalcode', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
