<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQlibraryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qlibraries', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
            $table->boolean('title')->default(0);
            $table->boolean('subtitle')->default(0);
            $table->boolean('composer')->default(0);
            $table->boolean('arranger')->default(0);
            $table->boolean('publisher')->default(0);
            $table->boolean('arrangement')->default(0);
            $table->boolean('accompaniment')->default(0);
            $table->boolean('language')->default(0);
            $table->boolean('tempo')->default(0);
            $table->boolean('year')->default(0);
            $table->boolean('ensemble')->default(0);
            $table->boolean('concert')->default(0);
            $table->boolean('comments')->default(0);
            $table->longText('must-haves')->nullable();
            $table->longText('nice-haves')->nullable();
            $table->timestamps();
            $table->primary('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qlibraries');
    }
}
