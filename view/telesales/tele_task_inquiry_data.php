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
		'a.id', 'a.jenis_task', 'CONCAT(a.region_code, " / ", a.region_name) AS region_name', 
		'CONCAT(a.cabang_code, " / ", a.cabang_name) AS cabang_name', 
		'a.customer_name', 'a.customer_id_ro', 'a.agrmnt_no', 'a.product_offering_code', 'a.asset_type', 'a.item_year', 
		'a.status_kontrak', 'a.go_live_dt', 'a.tenor', 'a.customer_rating', 'a.agrmnt_rating', 'a.source_data', 'a.campaign_id', 
		'a.assign_to', 'a.last_followup_date', 'a.last_followup_by', 'a.call_status_sub2 AS call_status', 'a.call_status_sub1', 'a.sla_remaining', 
		'a.eligible_flag', 'a.approval_engine_result', 'a.order_no', 'a.app_no', 'a.region_name', 'a.cabang_name','"-"','a.visit_dt','IF(a.visit_stat="" OR a.visit_stat IS NULL, "-", a.visit_stat)',
		'a.submited_dt', 'a.mss_stat', 'a.wise_stat', 'a.priority_level', 'a.opsi_penanganan');
				
	$sIndexColumn = "a.id";
   
	
	$start_date_field = "a.create_time";
	$end_date_field	  = "a.create_time";

	$sFromTable = "FROM cc_ts_penawaran a WHERE 1=1 ";

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

$params	= get_param("params");
if($params !== ''){
	$dec_params = base64_decode($params); 
	$expparm = explode("&", $dec_params);

	$tregion = explode("=", $expparm[0]);
	$tbranch = explode("=", $expparm[1]);
	$tcustname = explode("=", $expparm[2]);
	$tcustid = explode("=", $expparm[3]);
	$tcampaign = explode("=", $expparm[4]);

	$ttype = explode("=", $expparm[5]);
	$tsource = explode("=", $expparm[6]);
	$tlastagent = explode("=", $expparm[7]);
	$tlastcalled = explode("=", $expparm[8]);
	$tlaststatus = explode("=", $expparm[9]);
	$tlevel = explode("=", $expparm[10]);
}

if($tregion[1] !== ''){
    $sFromTable .= " AND a.region_code='".$tregion[1]."' ";
}
if($tbranch[1] !== ''){
    $sFromTable .= " AND a.cabang_code LIKE '%".$tbranch[1]."%' ";
}
if($tcustname[1] !== ''){
    $sFromTable .= " AND a.customer_name LIKE '%".$tcustname[1]."%' ";
}
if($tcustid[1] !== ''){
    $sFromTable .= " AND a.customer_id_ro LIKE '%".$tcustid[1]."%' ";
}
if($tcampaign[1] !== ''){
    $sFromTable .= " AND a.campaign_id='".$tcampaign[1]."' ";
}

if($ttype[1] !== ''){
    $sFromTable .= " AND a.jenis_task='".$ttype[1]."' ";
}

if($tsource[1] !== ''){
    $sFromTable .= " AND a.source_data='".$tsource[1]."' ";
}

if($tlastagent[1] !== ''){
    $sFromTable .= " AND a.last_followup_by='".$tlastagent[1]."' ";
}

if($tlastcalled[1] !== ''){
    $sFromTable .= " AND DATE(a.last_followup_date)='".$tlastcalled[1]."' ";
}

if($tlaststatus[1] !== ''){
    $sFromTable .= " AND a.call_status='".$tlaststatus[1]."' ";
}

if($tlevel[1] !== ''){
    $sFromTable .= " AND a.priority_level='".$tlevel[1]."' ";
}

$arrcamp = array();
$sql1 = " SELECT a.id, a.campaign_code, a.campaign_name FROM cc_ts_penawaran_campaign a ";
$res1 = mysqli_query($condb, $sql1);
while($rec1 = mysqli_fetch_object($res1)) {
	$id = $rec1['id'];
	$campaign_code = $rec1['campaign_code'];
	$campaign_name = $rec1['campaign_name'];
	$arrcamp[$id] = $campaign_code." / ".$campaign_name;
}

$arrstatus = array();
$sql1 = " SELECT a.id, a.call_status FROM cc_ts_call_status a ";
$res1 = mysqli_query($condb, $sql1);
while($rec1 = mysqli_fetch_object($res1)) {
	$id = $rec1['id'];
	$call_status = $rec1['call_status'];
	$arrstatus[$id] = $call_status;
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
	
	$sOrder = " ORDER BY a.insert_time ASC ";
    
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
                    $row[] = "<i onclick=\"frefID('$aRow[$i]')\" class='fas fa-arrow-right' data-toggle=\"modal\" data-backdrop=\"false\" data-target=\"#modal_history\" />";
                } else if($i === 16) {
					$row[] = htmlspecialchars($arrcamp[$aRow[$i]],ENT_QUOTES);
                } else if($i === 17 || $i === 19) {
					$row[] = htmlspecialchars($arr_agentid[$aRow[$i]],ENT_QUOTES);
                } else if($i === 20) {
					$row[] = htmlspecialchars($arrstatus[$aRow[$i]],ENT_QUOTES);
                } else if($i === 21) {
					$row[] = htmlspecialchars($arr_callstatussub[$aRow[$i]],ENT_QUOTES);
                } else { 
                    $row[] = htmlspecialchars($aRow[$i],ENT_QUOTES);
                }
			}
		}
		$output['aaData'][] = $row;
	}
    
disconnectDB($condb);	

?>