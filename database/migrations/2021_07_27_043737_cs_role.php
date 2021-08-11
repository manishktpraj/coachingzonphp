<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CsRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('cs_role', function (Blueprint $table) {
            $table->id("role_id");
            $table->string('role_name');
            $table->integer('role_status');
            $table->integer('role_ins_id');
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
        //
      ////  Schema::dropIfExists('cs_role');

    }
}
