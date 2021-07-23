<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Model\CsadminView;
use App\Http\Model\CsTheme;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Session;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
   
     public function __construct()
  {
      
        $this->middleware(function ($request, $next) {
            if(\Session::get("CS_ADMIN") != null) {
                $resuserData = \Session::get("CS_ADMIN");
              /*  $user_id=$user->staff_id;
              
                $resuserData = CsadminView::where('user_id', '=',$user_id)->where('role_type','=', $user->role_type)->get();

                $users = DB::table('csadmin_view')
                ->where('user_id', '=', $user_id)
                ->where('role_type', '=',  $user->role_type)
                ->get();

                print_r( $user);
                */
          ///     print_r($users);die;
          $resthemeData = CsTheme::first();
      
                
                    View::share( compact('resuserData','resthemeData'));

             }
            return $next($request);
        });
        
}
    
    
}
