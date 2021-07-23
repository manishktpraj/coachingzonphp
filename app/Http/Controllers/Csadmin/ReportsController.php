<?php namespace App\Http\Controllers\Csadmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Session;
use App\Http\Model\Csdmin;
use Validator;

class ReportsController extends Controller
{
  public function index(Request $request)
  {
    $title='Reports';
    return view('Csadmin.Reports.index')->with('title',$title);
  }
  
}