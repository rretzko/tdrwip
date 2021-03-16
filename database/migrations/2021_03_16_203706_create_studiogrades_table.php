<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudiogradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studiogrades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('studio_id')->constrained();
            $table->foreignId('gradetype_id')->constrained();
            $table->timestamps();
            $table->unique('studio_id','gradetype_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('studiogrades');
    }
}
