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

	$aColumns = array(  
		'a.id', 'b.campaign_name', 'a.customer_id_ro', 'a.agrmnt_no', 'a.customer_name', 
		'a.spv_id', 'a.assign_to', 'a.modif_time', 'a.call_status', 
		'a.call_status_sub1', 'a.last_followup_by', 'a.opsi_penanganan');
				
	$sIndexColumn = "a.id";
   
	
	$start_date_field = "a.create_time";
	$end_date_field	  = "a.create_time";

	$sFromTable = "FROM cc_ts_penawaran a, 
	cc_ts_penawaran_campaign b WHERE b.id=a.campaign_id ";

	  $viewTrace = 0;

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

if($bucket_id !== ''){
    $sFromTable .= " AND a.campaign_id='$bucket_id' ";
}

if($spv_id !== ''){
    $sFromTable .= " AND a.spv_id='".$spv_id."' ";
}

if($agent_id!==''){
    $sFromTable .= " AND a.assign_to='$agent_id' ";
}

if ($spv_id==='') {
	if($v_agentlevel===2){
        $sFromTable .=  "AND a.spv_id = '".$v_agentid."' ";
    }
}

if ($agent_id==='') {
	if($v_agentlevel===1){
        $sFromTable .=  "AND a.assign_to = '".$v_agentid."' ";
    }
}

if($last_phonecall!==''){
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
        while($rec = mysqli_fetch_object($res)) {
            $arr_agentid[$rec["id"]] = $rec["agent_name"]; 
        }
        mysqli_free_result($res);

        $sql = "SELECT id, call_status FROM cc_ts_call_status";
        $res = mysqli_query($condb,$sql);
        while($rec = mysqli_fetch_object($res)) {
             $arr_callstatus[$rec["id"]] = $rec["call_status"]; 
        }
        mysqli_free_result($res);
 
        $sql = "SELECT id, call_status_sub1 FROM cc_ts_call_status_sub1";
        $res = mysqli_query($condb,$sql);
        while($rec = mysqli_fetch_object($res)) {
             $arr_callstatussub[$rec["id"]] = $rec["call_status_sub1"]; 
        }
        mysqli_free_result($res);


	$sGroup = "";
	if ($privgroup !== "") {
		$sGroup = " $privgroup ";
	}

	$wherewile = "";
	for($i = 0; $i <$filterActive ; $i++){
		
		$cob_search = $cmb_search[$i];
		$txt_search = $cmb_key[$i];
		if($cob_search!=='' && $txt_search!==''){
			if($wherewile !== ''){
			$wherewile .= " AND ";	
			}	
			$wherewile .= " $cob_search like '%$txt_search%' ";	
		}
		
	}
	
	$sDate = "";
	if($s_time==='1'){ 
		 
		 if($date_period!==''){
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
	if($s_status==='1'){ 
		 if($val_status !== '' && $val_status === '0'){
		 	$sStatus = " AND c.ticket_status = '".$val_status."' ";
		 }
	 }

	$sLimit = "";
	if ( isset( $xxx = filter_input(INPUT_GET, 'iDisplayStart'] ) && $xxx = filter_input(INPUT_GET, 'iDisplayLength'] !== '-1' )
	{
		$sLimit = "LIMIT ".inj3($condb, $xxx = filter_input(INPUT_GET, 'iDisplayStart'] ).", ".
		inj3($condb, $xxx = filter_input(INPUT_GET, 'iDisplayLength'] );
	}
	
	
	if ( isset( $xxx = filter_input(INPUT_GET, 'iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		
		if($xxx = filter_input(INPUT_GET, 'iSortCol_0']===0){

			$sOrder .= " $sIndexColumn DESC";

		}else{
			
		
			for ( $i=0 ; $i<intval( $xxx = filter_input(INPUT_GET, 'iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($xxx = filter_input(INPUT_GET, 'iSortCol_'.$i]) ] === "true" )
				{
					$sOrder .= $aColumns[ intval( $xxx = filter_input(INPUT_GET, 'iSortCol_'.$i] ) ]."
						".inj3($condb, $xxx = filter_input(INPUT_GET, 'sSortDir_'.$i] ) .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
		}
		
			if ( $sOrder === "ORDER BY" )
			{
				$sOrder = "";
			}
	}
	
	

	
	
	$sWhere = "";
	$sWhere .= "  ";
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( $xxx = filter_input(INPUT_GET, 'bSearchable_'.$i] === "true" && $xxx = filter_input(INPUT_GET, 'sSearch_'.$i] !== '' )
		{
			if ( $sWhere === "" )
			{
				$sWhere = "AND ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= $aColumns[$i]." LIKE '%".inj3($condb, $xxx = filter_input(INPUT_GET, 'sSearch_'.$i])."%' ";
		}
	}
	
	
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
	"; 
	if($viewTrace === 1){
		echo $sQuery;
	}

	$rResult = mysqli_query($condb,$sQuery);  
	
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	$rResultFilterTotal = mysqli_query($condb,$sQuery);
	$aResultFilterTotal = mysqli_fetch_object($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	$sQuery = "
		SELECT COUNT(".$sIndexColumn.")
		$sFromTable
	";
	$rResultTotal = mysqli_query($condb,$sQuery);
	$aResultTotal = mysqli_fetch_object($rResultTotal);
	$iTotal = $aResultTotal[0];
	
	
	
	$output = array(
		"sEcho" => intval($xxx = filter_input(INPUT_GET, 'sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	while (( $aRow = mysqli_fetch_object( $rResult )) === TRUE) 
	{
		$row = array();
		
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] === "version" )
			{
				$row[] = ($aRow[$i]==="0") ? '-' : $aRow[$i];
			}
			else if ( $aColumns[$i] !== ' ' )
			{   
                if($i === 0) {
                    $row[] = "<i onclick=\"frefID('$aRow[$i]')\" class='fas fa-database' data-toggle=\"modal\" data-backdrop=\"false\" data-target=\"#modal_history\" />";
                } else if($i === 5) {
					$row[] = $arr_agentid[$aRow[$i]];
				} else if($i === 6) {
					$row[] = $arr_agentid[$aRow[$i]];
				} else if($i === 8) {
					if($aRow[$i] === "0"){
						$row[] = "New";
					} else {
						$row[] = $arr_callstatus[$aRow[$i]];
					}
                } else if($i === 9) {
					$row[] = $arr_callstatussub[$aRow[$i]];
				} else if($i === 10) {
					$row[] = $arr_agentid[$aRow[$i]];
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