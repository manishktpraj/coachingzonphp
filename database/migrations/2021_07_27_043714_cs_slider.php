<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CsSlider extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('cs_slider', function (Blueprint $table) {
            $table->id("slider_id");
            $table->string('slider_title');
            $table->text('slider_des')->nullable();
            $table->text('slider_image')->nullable();
            $table->integer('slider_status');
            $table->integer('slider_order');
            $table->integer('slider_type');
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
       /// Schema::dropIfExists('cs_slider');

    }
}
