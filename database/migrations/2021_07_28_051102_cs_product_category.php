<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CsProductCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('cs_product_category', function (Blueprint $table) {
            $table->id("pr_cat_id");
            $table->string('pr_cat_name');
            $table->string('pr_cat_slug');
            $table->integer('pr_cat_parent');
            $table->string('pr_cat_description')->nullable();
            $table->integer('pr_cat_status');
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
