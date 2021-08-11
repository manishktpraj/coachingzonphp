<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InstituteCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('cs_institute_category', function (Blueprint $table) {
            $table->id("icat_id");
            $table->string('icat_name');
            $table->string('icat_slug');
            $table->integer('icat_parent');
            $table->string('icat_description')->nullable();
            $table->integer('icat_status');
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
      ////  Schema::dropIfExists('cs_institute_category');
    }
}
