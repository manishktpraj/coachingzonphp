<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CsInstituteCategory extends Model
{
    //
    protected $table="cs_institute_category";
    protected $primaryKey = 'icat_id';
}
