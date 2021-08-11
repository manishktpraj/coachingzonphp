<?php namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CsProductCategory extends Model
{
    protected $table="cs_product_category";
    protected $primaryKey = 'pr_cat_id ';
} 