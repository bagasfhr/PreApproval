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
$path = "report/global_func_report.php";
if (file_exists($path)) {
        include $path;
}

$condb = connectDB();

$v_agentid      = get_session("v_agentid");
$v_agentlevel   = get_session("v_agentlevel");

$iddet 						= get_param("iddet");
$modul 						= get_param("modul");
$max_limit_distribution 	= get_param("max_limit_distribution");
$status 					= get_param("status");
	
if($iddet!==''){
	 $sqlu = "UPDATE cc_parameter_assign SET
                modul = '$modul', 
                max_limit_distribution = '$max_limit_distribution', 
                status = '$status',
                ";
    $sqlu .= "  modif_by = '$v_agentid',
                modif_time 	= now()
			WHERE id='$iddet'"; 
	if($rec_u = mysqli_query($condb,$sqlu)) {
		
		$traildesc = "Update $reason_log Success";
		report_insert_trail_log($v_agentid,$traildesc,$condb);
		
        $result  = "Success";
	}else{
		$result = "Failed";
	}
		
}else{
	
	$sqli = "INSERT INTO cc_parameter_assign SET
                modul 					= '$modul', 
                max_limit_distribution  = '$max_limit_distribution', 
                status 					= '$status',
                ";
    $sqli .= "  created_by 		= '$v_agentid',
                insert_time 	= now()";
	if($rec_i = mysqli_query($condb,$sqli)) {
		
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