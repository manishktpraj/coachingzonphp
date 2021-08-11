<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CsInstitute extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('cs_institute', function (Blueprint $table) {
            $table->id("ins_id");
            $table->string('ins_uniqueId');
            $table->string('ins_name');
            $table->string('ins_phone')->nullable();
            $table->string('ins_email');
            $table->string('ins_password');
            $table->integer('ins_status');
            $table->text('ins_address')->nullable();
            $table->text('ins_short_desc')->nullable();
            $table->text('ins_desc')->nullable();
            $table->text('ins_logo')->nullable();
            $table->text('ins_cover_image')->nullable();
            $table->text('ins_slug');
            $table->string('ins_state')->nullable();
            $table->string('ins_city')->nullable();
            $table->string('ins_postcode')->nullable();
            $table->string('ins_cat_id')->nullable();
            $table->text('ins_cat_name')->nullable();
            $table->timestamps();
 		
			
           /// $table->foreign('ins_cat_id')->references('icat_id')->on('cs_institute_category');


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
        Schema::dropIfExists('cs_institute');

    }
}
