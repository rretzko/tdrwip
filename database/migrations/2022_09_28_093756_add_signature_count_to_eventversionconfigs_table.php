<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSignatureCountToEventversionconfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eventversionconfigs', function (Blueprint $table) {
            $table->smallInteger('signature_count')->default(4)
            ->after('eapplication');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eventversionconfigs', function (Blueprint $table) {
            //
        });
    }
}
