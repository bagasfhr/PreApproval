<?php

 $path = "global_func.php";
if (file_exists($path)) {
        include $path;
}
 $path = "session.php";
if (file_exists($path)) {
        include $path;
}
 $path = "db_config.php";
if (file_exists($path)) {
        include $path;
}
 
 $condb = connectDB();

$link_data_acc 	= "view/telesales/tele_param_assign_data.php";


$menu_linkdet	= "tele_param_assign_det";

$field_data 	= array(
						array("","ID"),
						array("","Modul"),
            			array("a.max_limit_distribution","Max Limit Assign Data")
				  );


$hiddencol 		= "1";

$s_time = 0;


  $action_visibility  = 1;

  $add_button  = 1;

  $action_arr   = array(
				  );
include 'sysconf/global_list.php';
?>