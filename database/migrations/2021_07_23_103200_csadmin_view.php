<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CsadminView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::statement("
        CREATE VIEW csadmin_view AS
        
          SELECT er.staff_id as user_id, er.staff_name AS staff_name, 
              er.staff_email AS staff_email, er.staff_mobile AS staff_mobile,er.staff_default_status as staff_default_status,0 as role_type,er.staff_role as staff_role,er.staff_password as staff_password,
              er.staff_status as staff_status
  
          FROM `cs_staff` as er
            UNION 
            SELECT ind.ins_id  as user_id, ind.ins_name AS staff_name, 
            ind.ins_email AS staff_email, ind.ins_phone AS ins_phone,0 as staff_default_status,1 as role_type,0 as staff_role,ind.ins_password as staff_password,ind.ins_status as staff_status
            FROM `cs_institute` as ind
         
      ");
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::statement('DROP VIEW IF EXISTS csadmin_view');

    }
}
