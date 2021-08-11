<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CsProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::dropIfExists('cs_product');
        Schema::create('cs_product', function (Blueprint $table) {
            $table->id("product_id");
            $table->string('product_title');
            $table->string('product_uniqueid');
            $table->string('product_description')->nullable();
            $table->string('product_shortdesc')->nullable();
            $table->string('product_author')->nullable();
            $table->string('product_category_name')->nullable();
            $table->string('product_category_id')->nullable();
            $table->integer('product_status');
            $table->decimal('product_msp', 8, 2);	
            $table->decimal('product_mrp', 8, 2);	
            $table->decimal('product_discount', 8, 2);	
            $table->text('product_image')->nullable();
            $table->text('product_demo_pdf')->nullable();
            $table->integer('product_ins_id')->nullable();
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
