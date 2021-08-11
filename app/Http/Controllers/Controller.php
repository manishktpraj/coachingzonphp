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

                // if($resuserData->role_type!=0){
                // $resuserData1 = cs_institute::where('user_id', '=',$user_id)->where('role_type','=', $user->role_type)->get();
                // }
              /*  $user_id=$user->staff_id;
              
                $resuserData = CsadminView::where('user_id', '=',$user_id)->where('role_type','=', $user->role_type)->get();

                $users = DB::table('csadmin_view')
                ->where('user_id', '=', $user_id)
                ->where('role_type', '=',  $user->role_type)
                ->get();

                print_r( $user);
                */
               //print_r($resuserData);die;
               $user_role=$resuserData->role_type;
               $session_user_id= $resuserData->user_id;
               if($user_role==0){
                $session_user_data=CsStaff::first();
              }else{
               $session_user_data=CsInstitute::where('ins_id', $session_user_id)->first();
               }

               //print_r($resuserData);
               $permissions_data=CsRolePermissions::where('rp_role_id', $resuserData->staff_role)->get();
                            //  print_r($permissions_data);

//echo $user_role;
      $permission_data=array();
      $view_data=array();
      $delete_data=array();
      $edit_data=array();
      foreach($permissions_data as $p_data){
       // $permission_data[]=$p_data->rp_permission_id;
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
    // print_r($permission_data);
    // print_r($view_data);
    // print_r($delete_data);
    // print_r($edit_data);



          $resthemeData = CsTheme::first();
       
                
                    View::share( compact('resthemeData','session_user_data','user_role','view_data','delete_data','edit_data'));

             }
            return $next($request);
        });
        
}
    
    
}
