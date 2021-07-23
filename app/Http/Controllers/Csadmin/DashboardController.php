<?php namespace App\Http\Controllers\Csadmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Session;
use App\Http\Model\CsAdmin;
use Validator;

class DashboardController extends Controller
{
  public function index(Request $request)
  {
    $title='Dashboard';
    return view('Csadmin.dashboard')->with('title',$title);
  }
  public function notification(Request $request)
  {
    $title='Notification';
    return view('Csadmin.notification')->with('title',$title);
  }
 
}
