<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Model\CsadminView;
use App\Http\Model\CsStaff;

use App\Http\Model\CsRolePermissions;


use App\Http\Model\CsInstitute;

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

                 $user_role=$resuserData->role_type;
               $session_user_id= $resuserData->user_id;
               if($user_role==0){
                $session_user_data=CsStaff::first();
              }else{
               $session_user_data=CsInstitute::where('ins_id', $session_user_id)->first();
               }

               $permissions_data=CsRolePermissions::where('rp_role_id', $resuserData->staff_role)->get();
                           
      $permission_data=array();
      $view_data=array();
      $delete_data=array();
      $edit_data=array();
      foreach($permissions_data as $p_data){
        if($p_data->rp_view_status==1){
        $view_data[]=$p_data->rp_permission_id;
        }
        if($p_data->rp_delete_status==1){
        $delete_data[]=$p_data->rp_permission_id;
        }
        if($p_data->rp_entry_status==1){
        $edit_data[]=$p_data->rp_permission_id;
        }
        
     // $permissions_data=$p_data->rp_permission_id;
      }
    



          $resthemeData = CsTheme::first();
       
                
                    View::share( compact('resthemeData','session_user_data','user_role','view_data','delete_data','edit_data'));

             }
            return $next($request);
        });
        
}
    
    
}
