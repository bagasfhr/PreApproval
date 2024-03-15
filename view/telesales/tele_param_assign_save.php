<?php
include "../../sysconf/global_func.php";
include "../../sysconf/session.php";
include "../../sysconf/db_config.php";
include "../report/global_func_report.php";

$condb = connectDB();

$v_agentid      = get_session("v_agentid");
$v_agentlevel   = get_session("v_agentlevel");

$iddet 						= get_param("iddet");
$modul 						= get_param("modul");
$max_limit_distribution 	= get_param("max_limit_distribution");
$status 					= get_param("status");
	
if($iddet!=''){
	//update
	 $sqlu = "UPDATE cc_parameter_assign SET
                modul = '$modul', 
                max_limit_distribution = '$max_limit_distribution', 
                status = '$status',
                ";
    $sqlu .= "  modif_by = '$v_agentid',
                modif_time 	= now()
			WHERE id='$iddet'"; //echo $sqlu;
	if($rec_u = mysqli_query($condb,$sqlu)) {
		//user trail log
		$traildesc = "Update $reason_log Success";
		report_insert_trail_log($v_agentid,$traildesc,$condb);
		
        $result  = "Success";
	}else{
		$result = "Failed";
	}
		
}else{
	//insert
	$sqli = "INSERT INTO cc_parameter_assign SET
                modul 					= '$modul', 
                max_limit_distribution  = '$max_limit_distribution', 
                status 					= '$status',
                ";
    $sqli .= "  created_by 		= '$v_agentid',
                insert_time 	= now()";
	if($rec_i = mysqli_query($condb,$sqli)) {
		//user trail log
		$traildesc = "Update $reason_log Success";
		report_insert_trail_log($v_agentid,$traildesc,$condb);
		
        $result  = "Success";
	}else{
		$result = "Failed";
	}
}

echo $result;
disconnectDB($condb);

?>