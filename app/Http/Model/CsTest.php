<?php namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CsTest extends Model
{
    protected $table="cs_test";
    protected $primaryKey = 'test_id';
} 