<?php namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CsPackageDetail extends Model
{
    protected $table="cs_package_detail";
    protected $primaryKey = 'pkd_id';
} 