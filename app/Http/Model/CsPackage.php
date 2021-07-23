<?php namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CsPackage extends Model
{
    protected $table="cs_package";
    protected $primaryKey = 'package_id';
} 