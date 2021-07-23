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
            $table->id();
            $table->string('ins_uniqueId');
            $table->string('ins_name');
            $table->string('ins_phone');
            $table->string('ins_email');
            $table->string('ins_password');
            $table->integer('ins_status');
            $table->text('ins_address');
            $table->text('ins_short_desc');
            $table->text('ins_desc');
            $table->text('ins_logo');
            $table->text('ins_cover_image');
            $table->text('ins_slug');
            $table->integer('ins_cat_id');
            $table->text('ins_cat_name');
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
    }
}
