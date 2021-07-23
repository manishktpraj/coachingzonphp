<?php namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CsTcategory extends Model
{
    protected $table="cs_tcategory";
    protected $primaryKey = 'tc_id';
} 