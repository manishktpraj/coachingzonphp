<?php namespace App\Http\Controllers\Csadmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Session;
use App\Http\Model\CsAdmin;
use Validator;
use App\Http\Model\CsTransactions;
use App\Http\Model\CsTransactionsDetail;


class CommissionController extends Controller
{
  public function index(Request $request)
  {
      $title='Commission';
    return view('Csadmin.Commission.index')->with('title',$title);
  }
 
} 
