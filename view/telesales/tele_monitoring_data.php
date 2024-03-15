<?php
 ###############################################################################################################
#																												#
#                   `---:/.     																				#			
#               .--.    `+h.   																					#
#            `--`         om   																					#
#          `:-   `-:-`    :M.  		___________.__                .__                  _____  __   				#
#         .:#` :ydy++y    +M`  		\_   _____/|  | ___.__.______ |  |__   ___________/ ____\/  |_ 				#
#        :.  #hm+.   /`   mh   		 |    __)_ |  |<   |  |\____ \|  |  \ /  ___/  _ \   __\\   __\				#
#       :`  +Ns`     /   oN-   		 |        \|  |_\___  ||  |_> >   Y  \\___ (  <_> )  |   |  | 				#
#      /`  +N+      ::.-oN+    		/_______  /|____/ ____||   __/|___|  /____  >____/|__|   |__|				#
#     :.  .No     `:`# /No     		        \/      \/     |__|        \/     \/  								#
#    `/   +M`   `--`##sN+      		   _____            _             _      _____           _            		#
#    :`   .m/..--`  -dd-       		 / ____|          | |           | |    / ____|         | |           		#
#    +    .:.``   .ymo`        		| |     ___  _ __ | |_ __ _  ___| |_  | |     ___ _ __ | |_ ___ _ __ 		#
#   /:  --     :yms.          		| |    / _ \| '_ \| __/ _` |/ __| __| | |    / _ \ '_ \| __/ _ \ '__|		#
#     s+/.  ./smh+`            		| |___| (_) | | | | || (_| | (__| |_  | |___|  __/ | | | ||  __/ |   		#
#      -oyhhyo:`               		 \_____\___/|_| |_|\__\__,_|\___|\__|  \_____\___|_| |_|\__\___|_|			#
#																												#
#	-------------------------																					#
#																												#
 ###############################################################################################################


 
######################################### C O N F I G U R A T I O N   F I L E ###################################
include "../../sysconf/global_func.php";
include "../../sysconf/session.php";
include "../../sysconf/db_config.php";

$condb = connectDB();

	# DATA FIELD
	$aColumns = array(  
		'a.id', 'b.campaign_name', 'a.customer_id_ro', 'a.agrmnt_no', 'a.customer_name', 
		'a.spv_id', 'a.assign_to', 'a.modif_time', 'a.call_status', 
		'a.call_status_sub1', 'a.last_followup_by', 'a.opsi_penanganan');
	
	# INDEX ID				
	$sIndexColumn = "a.id";
   
	
	# START TIME & END TIME 
	$start_date_field = "a.create_time";
	$end_date_field	  = "a.create_time";

	# FROM QUERY
	$sFromTable = "FROM cc_ts_penawaran a, 
	cc_ts_penawaran_campaign b WHERE b.id=a.campaign_id ";

	# VIEW TRACE
	  // 0 = Disable     1 = Enable
	  // If you enable this Trace, so your data may be broke, but you can trace it in network data :D :P 
	  $viewTrace = 0;


####################################  E N D   O F  C O N F I G U R A T I O N   F I L E #  ########################
/*
$v_agentid      = get_param("v_agentid");
$v_agentlevel   = get_param("v_agentlevel");
*/
$v_agentid      = get_session("v_agentid");
$v_agentlevel   = get_session("v_agentlevel");

$s_time			= get_param("s_time");
$s_status		= inj3($condb,get_param("s_status"));
$s_time			= get_param("s_time");

$cmb_key[0]		= inj3($condb,get_param("cmb_key_0"));
$cmb_key[1]		= inj3($condb,get_param("cmb_key_1"));
$cmb_key[2]		= inj3($condb,get_param("cmb_key_2"));
$cmb_key[3]		= inj3($condb,get_param("cmb_key_3"));
$cmb_key[4]		= inj3($condb,get_param("cmb_key_4"));
$cmb_search[0]	= inj3($condb,get_param("cmb_search_0"));
$cmb_search[1]	= inj3($condb,get_param("cmb_search_1"));
$cmb_search[2]	= inj3($condb,get_param("cmb_search_2"));
$cmb_search[3]	= inj3($condb,get_param("cmb_search_3"));
$cmb_search[4]	= inj3($condb,get_param("cmb_search_4"));
$date_period	= inj3($condb,get_param("date_period"));
$val_status		= inj3($condb,get_param("val_status"));
$filterActive	= inj3($condb,get_param("filterActive"));

$starttime = date('Y')."-".$cmbperiode."-01 00:00:00";
$endtime = date('Y')."-".$cmbperiode."-31 23:59:59";

$bucket_id	= get_param("bucket_id");
$spv_id     = get_param("spv_id");
$agent_id   = get_param("agent_id");
$last_phonecall = get_param("last_phonecall");

if($bucket_id != ''){
    $sFromTable .= " AND a.campaign_id='$bucket_id' ";
}

if($spv_id != ''){
    $sFromTable .= " AND a.spv_id='".$spv_id."' ";
}

if($agent_id!=''){
    $sFromTable .= " AND a.assign_to='$agent_id' ";
}

if ($spv_id=='') {
	if($v_agentlevel==2){
        $sFromTable .=  "AND a.spv_id = '".$v_agentid."' ";
    }
}

if ($agent_id=='') {
	if($v_agentlevel==1){
        $sFromTable .=  "AND a.assign_to = '".$v_agentid."' ";
    }
}

if($last_phonecall!=''){
    $sFromTable .= " AND a.call_status='$last_phonecall' "; 
}

		$sql = "SELECT 
                    a.id, a.agent_id, a.agent_name 
                FROM 
                    cc_agent_profile a
                WHERE 
                    a.`status`=1
                ORDER BY a.id DESC ";
        $res = mysqli_query($condb,$sql);
        while($rec = mysqli_fetch_array($res)) {
            $arr_agentid[$rec["id"]] = $rec["agent_name"]; 
        }
        mysqli_free_result($res);

        $sql = "SELECT id, call_status FROM cc_ts_call_status";
        $res = mysqli_query($condb,$sql);
        while($rec = mysqli_fetch_array($res)) {
             $arr_callstatus[$rec["id"]] = $rec["call_status"]; 
        }
        mysqli_free_result($res);
 
        $sql = "SELECT id, call_status_sub1 FROM cc_ts_call_status_sub1";
        $res = mysqli_query($condb,$sql);
        while($rec = mysqli_fetch_array($res)) {
             $arr_callstatussub[$rec["id"]] = $rec["call_status_sub1"]; 
        }
        mysqli_free_result($res);


	$sGroup = "";
	if ($privgroup != "") {
		$sGroup = " $privgroup ";
	}

	$wherewile = "";
	for($i = 0; $i <$filterActive ; $i++){
		
		$cob_search = $cmb_search[$i];
		$txt_search = $cmb_key[$i];
		if($cob_search!='' && $txt_search!=''){
			if($wherewile != ''){
			$wherewile .= " AND ";	
			}	
			$wherewile .= " $cob_search like '%$txt_search%' ";	
		}
		
	}
	
	$sDate = "";
	if($s_time=='1'){ //jika enable
		 
		 if($date_period!=''){
		 	$start_date 	= trim(substr($date_period,0,10));
			$end_date 		= trim(substr($date_period,12));
			
		 	$sDate = " AND $start_date_field >= '$start_date 00:00:00'
		 			   AND $end_date_field <= '$end_date 23:59:59' ";
		 
		 }else{
		 	$nowdate = date("Y-m-d");
		 	$sDate = " AND $start_date_field >= '$nowdate 00:00:00'
		 			   AND $end_date_field <= '$nowdate 23:59:59' ";
		 }
	 }

	 $sStatus = "";
	if($s_status=='1'){ //jika enable
		 if($val_status != '' && $val_status == '0'){
		 	$sStatus = " AND c.ticket_status = '".$val_status."' ";
		 }
	 }

	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".inj3($condb, $_GET['iDisplayStart'] ).", ".
		inj3($condb, $_GET['iDisplayLength'] );
	}
	
	
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		
		if($_GET['iSortCol_0']==0){

			$sOrder .= " $sIndexColumn DESC";

		}else{
			
		
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
						".inj3($condb, $_GET['sSortDir_'.$i] ) .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
		}
		
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
	}
	
	

	
	
	$sWhere = "";
	$sWhere .= "  ";
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "AND ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= $aColumns[$i]." LIKE '%".inj3($condb, $_GET['sSearch_'.$i])."%' ";
		}
	}
	
    // $sGroup = " GROUP BY MONTH(a.create_time), a.region, a.spv_id, a.bucket_id ";
	// $sOrder = " ORDER BY a.insert_time ASC ";
	
	// $sOrder = "  ORDER BY ISNULL(a.call_status) ASC, a.call_status=0, a.call_status  ASC,
 //                 CASE
 //                     WHEN a.call_status>0 THEN a.modif_time
 //                 END DESC ";
	
	// $sOrder = "  ORDER BY ISNULL(a.call_status) ASC, a.call_status=0,
 //                 CASE
 //                     WHEN a.call_status>0 THEN a.modif_time
 //                 END DESC ";
	
	$sOrder = "  ORDER BY ISNULL(a.call_status) ASC, a.call_status=0,
                 IF(a.call_status>0, a.modif_time,'') DESC, modif_time ASC";
    
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
		$sFromTable
		$sWhere
		$sWhereWhile
		$sDate
		$sStatus
		$sGroup
		$sOrder
		$sLimit
	"; //echo $sQuery;
	if($viewTrace == 1){
		echo $sQuery;
	}

	$rResult = mysqli_query($condb,$sQuery);  
	
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	$rResultFilterTotal = mysqli_query($condb,$sQuery);
	$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	$sQuery = "
		SELECT COUNT(".$sIndexColumn.")
		$sFromTable
	";
	$rResultTotal = mysqli_query($condb,$sQuery);
	$aResultTotal = mysqli_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];
	
	
	
	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	while ( $aRow = mysqli_fetch_array( $rResult ) )
	{
		$row = array();
		
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] == "version" )
			{
				//$row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
				$row[] = ($aRow[$i]=="0") ? '-' : $aRow[$i];
			}
			else if ( $aColumns[$i] != ' ' )
			{   
                if($i == 0) {
                    $row[] = "<i onclick=\"frefID('$aRow[$i]')\" class='fas fa-database' data-toggle=\"modal\" data-backdrop=\"false\" data-target=\"#modal_history\" />";
                } else if($i == 5) {
					$row[] = $arr_agentid[$aRow[$i]];
				} else if($i == 6) {
					$row[] = $arr_agentid[$aRow[$i]];
				} else if($i == 8) {
					if($aRow[$i] == "0"){
						$row[] = "New";
					} else {
						$row[] = $arr_callstatus[$aRow[$i]];
					}
                    // $row[] = htmlspecialchars($aRow[$i],ENT_QUOTES);
                    // $url = base64_encode($aRow[0]);
                    // $row[] = '<button class="btn btn-sm btn-success" onClick="downloadexcel(\''.$url.'\');"> 
                    // <i class="fas fa-file-export">&nbsp;&nbsp;XLS</i></button>';
                } else if($i == 9) {
					$row[] = $arr_callstatussub[$aRow[$i]];
					// $row[] = $arr_callstatus[$aRow[$i]];
				} else if($i == 10) {
					$row[] = $arr_agentid[$aRow[$i]];
					// $row[] = $arr_callstatus[$aRow[$i]];
				} else {
                    $row[] = htmlspecialchars($aRow[$i],ENT_QUOTES);
                }
			}
		}
		$output['aaData'][] = $row;
	}
    
disconnectDB($condb);	
echo json_encode( $output );

?>