<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Model\CsStaff;
use App\Http\Model\CsTheme;

use Illuminate\Support\Facades\View;
use Session;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
   
     public function __construct()
  {
      
        $this->middleware(function ($request, $next) {
            if(\Session::get("CS_ADMIN") != null) {
                $user = \Session::get("CS_ADMIN");
                $user_id=$user->staff_id;
                $resuserData = CsStaff::where('staff_id', $user_id)->first();
                $resthemeData = CsTheme::first();
               //print_r($rethemeData);die;
                
                    View::share( compact('resuserData','resthemeData'));

             }
            return $next($request);
        });
        
}
    
    
}
