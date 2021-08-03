<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('organization_id')->constrained();
            $table->foreignId('membershiptype_id')->constrained();
            $table->string('membership_id')->nullable();
            $table->date('expiration')->nullable();
            $table->string('grade_levels')->nullable();
            $table->string('subjects')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['user_id','organization_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('memberships');
    }
}
