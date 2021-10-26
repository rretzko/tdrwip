<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLibrarymediatypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('librarymediatypes', function (Blueprint $table) {
            $table->id();
            $table->string('descr',24);
            $table->tinyInteger('order_by')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->unique('descr');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('librarymediatypes');
    }
}
