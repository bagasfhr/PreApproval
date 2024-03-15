<?php
include "../../sysconf/global_func.php";
include "../../sysconf/session.php";
include "../../sysconf/db_config.php";

// load function from url
if(function_exists($_GET['f'])) {
   $_GET['f']();
}


function telesales_get_select_status_enable($idname, $name, $status) {
  $sel0 = "";
  $sel1 = "";

  if ($status == "0")
    $sel0 = "selected";
  else if ($status == "1")   
    $sel1 = "selected";

  $selectout = "<SELECT id=\"$idname\" name=\"$name\" class=\"select2 form-control\" style=\"width:100%;\">     
  <option value=\"0\" $sel0>Disable</option>
  <option value=\"1\" $sel1>Enable</option>
  </SELECT>";

  return $selectout;                     
}

function telesales_get_select_action($id, $name, $value) {
  $sel = "<div class='select2-input'>
  <SELECT id='$id' name='$name' class='select2 form-control' required='required' style='width:100%;'>";
  $sel .= "<option value='' >--Selected--</option>";    
  $sel .= "</SELECT>
  </div>";
  return $sel;
}

function telesales_skill_outbound($conDB, $id, $name, $skill,$agentid) {

  $sql = "SELECT * FROM cc_group_leader a WHERE a.agent_id='$agentid'";
  $res = mysqli_query($conDB, $sql);
  if ($row = mysqli_fetch_array($res)) {
    $group_id = $row['group_id'];
  }
  $sql3 = "SELECT DISTINCT(a.agent_id) FROM cc_group_agent a WHERE a.group_id='$group_id'";
  $res = mysqli_query($conDB, $sql3);
  while ($row = mysqli_fetch_array($res)) {
    $id_agent_arr[] = $row['agent_id'];
  }
  $id_agent = implode(",",$id_agent_arr);
  $sql4 = "SELECT DISTINCT(a.skill_id) FROM cc_skill_agent a WHERE a.agent_id IN ($id_agent)";
  $res = mysqli_query($conDB, $sql4);
  while ($row = mysqli_fetch_array($res)) {
    $id_skill_arr[] = $row['skill_id'];
  }
  $id_skill = implode(",",$id_skill_arr);
  $sel = "<SELECT id=\"$id\" name=\"$name\" class=\"select2 form-control\" style=\"width:100%;\">";
  $sel .= "<option value=\"\" selected>--Selected--</option>"; 
  $sel .= "<option value=\"0\" >All Skill Outbound</option>"; 
  $sql_str1 = "SELECT a.skill_id, b.skill_name FROM cc_skill_feature a, cc_skill b WHERE a.skill_id=b.id AND a.skill_feature = 10 AND b.id IN ($id_skill) ORDER BY a.skill_id";
  $sql_res1  = execSQL($conDB, $sql_str1);    
  while ($sql_rec1 = mysqli_fetch_array($sql_res1)) {
    if($sql_rec1['skill_id'] == $skill) {
      $sel .= "<option value=\"".$sql_rec1['skill_id']."\" selected>".$sql_rec1['skill_name']."</option>";  
    } else {
      $sel .= "<option value=\"".$sql_rec1['skill_id']."\" >".$sql_rec1['skill_name']."</option>";  

    }
  }

  $sel .= "</SELECT>";

  return $sel;
}

function get_agent_by_skill(){
  $condb = connectDB();
  $v_agentgroup = get_session('v_agentgroup');
  $skill_id     = get_param("skill_id");

  $skill_id != '0' && $skill_id != '' ? $where = "AND b.skill_id=$skill_id": $where=''; 

  $sel = '';
  $sel .= '<option value="" disabled selected>--- select agent ---</option>';
  $sql = "SELECT c.id, c.agent_id, c.agent_name, a.group_id, b.skill_id
            FROM cc_group_agent a, cc_skill_agent b
            LEFT JOIN cc_agent_profile c ON b.agent_id=c.id 
            WHERE a.agent_id=b.agent_id AND a.agent_id=c.id
            AND c.`status`=1
            AND c.agent_level=1
            AND a.group_id=$v_agentgroup
            $where  
            GROUP BY c.id";
  $res = mysqli_query($condb, $sql);
  while ($row = mysqli_fetch_array($res)) {
    $agent_id   = $row['id'];
    $agent_name = $row['agent_name'];
    $sel .= '<option value="'.$agent_id.'">'.$agent_name.'</option>';
  }

  $data['sel'] = $sel;
  $data['sql'] = $sql;
  echo json_encode($data);

}

/*
* desc function : get data bucket with assign_to = 0
* database target : cc_ts_data_bucket
* where assign_to = 0
*/
function get_datatable_bucket(){
  $condb = connectDB();
  $v_agentid = get_session('v_agentid');
  $cmbcampaign = $_GET['cmbcampaign'];

  $cmbcampaign != '' ? $wcampaign = 'AND c.id = '.$cmbcampaign: $wcampaign = '';
  if ($cmbcampaign == 1) {
    $aColumns = array("a.id", "c.campaign_code", "c.campaign_name", "a.source_data", "a.agrmnt_no", "IF(a.no_pengajuan IS NULL OR a.no_pengajuan = '', a.task_id, a.no_pengajuan)","a.customer_name");
  }else{
    $aColumns = array("a.id", "c.campaign_code", "c.campaign_name", "a.SOURCE_DATA", "a.AGRMNT_NO", "IF(a.TASK_ID IS NULL OR a.TASK_ID = '', '-', a.TASK_ID)", "a.CUST_NAME", "a.CUST_NO", "a.CUST_ID", "c.campaign_priority");
  }


// custno -> customer_id_ro
// custid -> customer_id
  $sIndexColumn = "a.id";

  //field date 
  // $start_date_field = "a.assignmentdate";
  // $end_date_field    = "a.assignmentdate";

  /*
  $sFromTable = "FROM cc_customer_profile_prv_prv a
  LEFT JOIN cc_ts_data_bucket_prv b ON a.id=b.cust_id
  LEFT JOIN cc_agent_profile c ON b.assign_to=c.id
  LEFT JOIN cc_campaign_prv d ON b.subcam_id=d.id
  LEFT JOIN cc_campaign_category_prv e ON b.cam_id=e.id
  WHERE 1=1 AND b.status in (1,0) $sqlfrom"; */ 
  if ($cmbcampaign == 1) {
    $sFromTable = "FROM cc_ts_penawaran a, cc_ts_penawaran_campaign c 
    WHERE 
    c.id=a.campaign_id AND (a.`assign_to`=$v_agentid OR a.`assign_to`=0) ".$wcampaign."";
  }else{
    $sFromTable = "FROM cc_ts_penawaran_job a, cc_ts_penawaran_campaign c 
    WHERE 
    c.id=a.campaign_id AND is_assign!=1 AND is_eligible_crm=1 AND is_process=1 ".$wcampaign."";
  }
  //                     left outer join ak_customer b on (a.id_cust=b.id)
  //echo $sFromTable;    
  $date_period  = $_GET['date_period'];
  $txt_search   = $_GET['txt_search'];

  $sDate = "";
  if($date_period!='') {
    $start_date   = trim(substr($date_period,0,10));
    $end_date     = trim(substr($date_period,12));
    /* search date hidden
    $sDate = " AND $start_date_field >= '$start_date 00:00:00'
    AND $end_date_field <= '$end_date 23:59:59' ";
    */
  }

  /* Individual column filtering */
  for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
    if($_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' ) {
      if($sWhere == "" ) {
        $sWhere = "AND ";
      } else {
       $sWhere .= " AND ";
      }

     $sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($condb, $_GET['sSearch_'.$i])."%' ";
    }
  }
  // echo "### $sWhere";

  $sQuery = "
    SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
    $sFromTable
    $sWhere
    $sDate
    $sOrder
    $sLimit
  "; // echo $sQuery;
  if(isset($_GET['mode'])) {
    echo $sQuery;
  }
  $rResult = mysqli_query($condb, $sQuery);
  $xsQuery = $sQuery;

  /* Data set length after filtering */
  $sQuery = "
    SELECT FOUND_ROWS()
  ";
  $rResultFilterTotal = mysqli_query($condb,$sQuery);
  $aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
  $iFilteredTotal = $aResultFilterTotal[0];

  /* Total data set length */
  $sQuery = "
    SELECT COUNT(".$sIndexColumn.")
    $sFromTable
  ";  //echo $sQuery;
  $rResultTotal = mysqli_query($condb, $sQuery);
  $aResultTotal = mysqli_fetch_array($rResultTotal);
  $iTotal = $aResultTotal[0];


  /*
  * Output
  */
  $output = array(
    "sEcho" => intval($_GET['sEcho']),
    "iTotalRecords" => $iTotal,
    "iTotalDisplayRecords" => $iFilteredTotal,
    "aaData" => array(),
    "xsql" => $xsQuery
  );

  $sqlx = "";
  while ($aRow = mysqli_fetch_array($rResult)) {
    $row = array();
    $tot_under = 0;
    if ($cmbcampaign!=1) {
      $sqls = "SELECT COUNT(b.id) as tot_under FROM cc_ts_penawaran_job a JOIN cc_ts_penawaran_campaign b ON a.campaign_id=b.id
              WHERE (a.CUST_ID = '".$aRow[8]."' OR a.CUST_NO='".$aRow[7]."') AND a.is_eligible_crm=1
              AND b.campaign_priority<".$aRow[9];
      // if($aRow[4]=="808500025698"){
      //   $sqlx = $sqls;
      // }
      // $ress = mysqli_query($condb, $sqls);
      // if($recs = mysqli_fetch_array($ress)){
      //   $tot_under = $recs["tot_under"];
      // }
      // mysqli_free_result($ress);
    }
    // if($tot_under<1){
      for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
        if ( $aColumns[$i] == "version" ) {
          //$row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
          $row[] = ($aRow[$i]=="0") ? '-' : $aRow[$i];
        } else if ( $aColumns[$i] != ' ' ) {
          // custno -> customer_id_ro
          // custid -> customer_id
          if ($i<7) {
            if($i == "0") {
              $row[] = " <input type='checkbox' id='check_assign' name='check_assign' value='".$aRow[$i]."' class='row_bulk' onclick=\"checkBulk()\">";
            } else {
             $row[] = $aRow[$i];
            }
          }
        }
      }
      $output['aaData'][] = $row;
    // }

  }

  $output['iTotalRecords'] = COUNT($output['aaData']);
  $output['iTotalDisplayRecords'] = COUNT($output['aaData']);
  // if(isset($_GET['mode'])) {
  // }

  // $output["sql_trace"] = $sqlx;
  freeResSQL($rResult);
  freeResSQL($rResultFilterTotal);
  freeResSQL($rResultTotal);
  disconnectDB($condb);
  echo json_encode($output);
}

function count_data(){
  $condb = connectDB();
  $v_agentid = get_session('v_agentid');

  $region               = get_param("region");
  $cabang               = get_param("cabang");
  // $cabang               = get_param("branch_name");
  $kategori_kendaraan   = get_param("kategori_kendaraan");
  $asset_type_kendaraan = get_param("asset_type_kendaraan");
  $status_call          = get_param("status_call");
  $campaign_id          = get_param("campaign");
  $campaign_priority    = get_param("campaign_priority");
  $last_call_dt         = get_param("last_call_dt");
  $dateperiod  = get_param("last_call_period");
  $date_from   = substr($dateperiod,0,10);
  $date_to     = substr($dateperiod,12);


  $total_data           = array();
  $status_call == "99" ? $status_call = "0":0;
  $where = '';

  if ($campaign_id == 1) {
    $where = 'AND a.assign_to=0';
  }

  $param_custno="";
  if ($campaign_id == "1") {
    $region_field = 'region_code';
    $branch_field = 'cabang_code';
  }else{
    $region_field = 'OFFICE_REGION_CODE';
    $branch_field = 'OFFICE_CODE';

    $sql_custno = "SELECT CUST_NO 
                  FROM cc_ts_penawaran_job a
                  LEFT JOIN cc_ts_penawaran_campaign b ON a.campaign_id=b.id
                  WHERE
                  a.CUST_NO IN (SELECT DISTINCT c.CUST_NO FROM cc_ts_penawaran_job c WHERE c.campaign_id=$campaign_id)
                  AND a.is_eligible_crm=1
                  AND b.campaign_priority < $campaign_priority";
    $res_custno = mysqli_query($condb, $sql_custno);
    $row_custno = mysqli_fetch_all($res_custno);
    $param_custno =  implode(', ', array_map(function ($entry) {
                  return "'".$entry[0]."'";
                }
              , $row_custno ));
    // $total_data['custno'] = $param_custno;
    if ($param_custno!="") {
      $where .= " AND a.CUST_NO NOT IN ($param_custno)";
    }


  }
  ($region != 0 && $region != "") ? $where .= " AND a.$region_field IN ($region)" : 0;
  
  // $kategori_kendaraan != 0 ? $where .= " AND a.region_code IN ($asset_type_kendaraan)" : 0;

  // if ($asset_type_kendaraan != '') {
  //   $where .= "AND a.asset_type IN ($asset_type_kendaraan)";
  // }

  // ($cabang != '') ? $where .= "AND a.cabang_code IN ($cabang)" : 0;
  ($cabang != '') ? $where .= "AND a.$branch_field IN ($cabang)" : 0;
  
  if ($campaign_id == 1) {
    if($status_call != '0') {
      if ($status_call == 'Fresh' || $status_call == '99') {
        $where .= " AND a.call_status = '' ";
      }else{
        $where .= " AND a.call_status = '$status_call' ";
      }
    }
  }else{
    $sqlsel="";
    if($status_call != '0') {
      if ($status_call == 'Fresh') {
        $where .= " AND a.last_phonecall = '' ";
      }else{
        // if ($last_call_dt == "1") {
          $date_from  .= " 00:00:00";
          $date_to    .= " 23:59:59";
          // get data by period
          $iddes = "";
          $sqlsel = "SELECT DISTINCT(a.agrmnt_no) as iddes
                      FROM cc_ts_penawaran_history a 
                      WHERE 
                      a.call_status=$status_call AND 
                      a.campaign_id=$campaign_id AND 
                      a.create_time >= '$date_from' AND
                      a.create_time <= '$date_to' ORDER BY a.agrmnt_no DESC";
          $ressel = mysqli_query($condb, $sqlsel);
          $rowsel = mysqli_fetch_all($ressel);
          // $iddes  = implode(",", $rowsel);

          $iddes =  implode(', ', array_map(function ($entry) {
                        return $entry[0];
                      }
                    , $rowsel ));

          if ($iddes != "") {
            $where .= " AND a.agrmnt_no IN ($iddes)";
          }else{
            $where .= " AND a.agrmnt_no = 0";
          }
        // }else{
          // $where .= " AND a.call_status IN ($status_call) ";
        // }
      }
    }
  }
  // AND (a.assign_to = $v_agentid OR a.assign_to=0)
  if ($campaign_id == 1) {
    $sql = "SELECT count(a.id) as total_data FROM cc_ts_penawaran a WHERE a.assign_to=0 AND a.campaign_id='$campaign_id' $where ";
  }else{
    $sql = "SELECT count(a.id) as total_data FROM cc_ts_penawaran_job a WHERE is_assign!=1 AND is_eligible_crm=1 AND is_process=1 AND a.campaign_id='$campaign_id' $where ";
  }
  $res = mysqli_query($condb, $sql);
  if ($row = mysqli_fetch_array($res)) {
    $total_data = $row;
  }

  $total_data['asset_type_kendaraan'] = $sqlsel;
  $total_data['custno'] = $param_custno;
  $total_data['sql'] = $sql;

  echo json_encode($total_data);
}

function load_det_campaign(){
  $condb = connectDB();
  $campaign_id  = get_param("campaign_id");
  $data = array();
  $iregion = 0;
  $itype = 0;

  $sql = "SELECT a.regional, a.type_asset, a.kendaraan, a.campaign_priority FROM cc_ts_penawaran_campaign a WHERE a.id=$campaign_id";
  $res = mysqli_query($condb, $sql);
  if ($row = mysqli_fetch_array($res)) {
    $data['campaign_priority']    = $row['campaign_priority'];
    $data['prio_tipe_kendaraan']  = $row['kendaraan'];
    
    // get region code
    $region = $row['regional'];
    $region != '0' && $region != '' ? $wregion = "a.id IN ($region)" : $wregion = '';
    $sqlreg = "SELECT a.region_code FROM cc_master_region a WHERE $wregion";
    $resreg = mysqli_query($condb, $sqlreg);
    $data['regional'] = '';
    while($rowreg = mysqli_fetch_array($resreg)){
      $iregion == 0 ? $data['regional'] .= $rowreg['region_code']: $data['regional'] .= ', '.$rowreg['region_code']; 
      $iregion++;
    }

    // get asset type
    $asset = $row['type_asset'];
    $asset != '0' && $asset != '' ? $wasset = "a.asset_type_id IN ($asset)" : $wasset = '';
    $sqlasset = "SELECT a.asset_type_code FROM cc_master_type_asset a WHERE $wasset";
    $resasset = mysqli_query($condb, $sqlasset);
    $data['asset_type_kendaraan'] = '';  
    while($rowasset = mysqli_fetch_array($resasset)){
      $itype == 0 ? $data['asset_type_kendaraan'] .= "'".$rowasset['asset_type_code']."'": $data['asset_type_kendaraan'] .= ", '".$rowasset['asset_type_code']."'"; 
      $itype++;
    }
  }
  echo json_encode($data);
}

function assign_by_contract(){
  $condb = connectDB();

  $v_agentid            = get_session("v_agentid");
  $v_agentlevel         = get_session("v_agentlevel");

  $method               = get_param("assignment_method");
  $iddeb                = get_param("iddeb");
  $region               = get_param("regional");
  $region               = implode(',', $region);
  // $cabang               = get_param("cabang");
  $cabang               = get_param("branch");
  $kategori_kendaraan   = get_param("kategori_kendaraan");
  $asset_type_kendaraan = get_param("asset_type_kendaraan");
  $last_call_dt         = get_param("last_call_dt");
  $dateperiod  = get_param("last_call_period");
  $date_from   = substr($dateperiod,0,10);
  $date_to     = substr($dateperiod,12);

  if ($campaign_id == 1) {
    $region_field = 'region_code';
    $branch_field = 'cabang_code';
  }else{
    $region_field = 'OFFICE_REGION_CODE';
    $branch_field = 'OFFICE_CODE';
  }

  // $asset = '';
  // foreach ($asset_type_kendaraan as $key => $value) {
  //   if ($value != 0) {
  //     $key == 0 ? $asset .= "'".$value."'": $asset .= ",'".$value."'";
  //   }
  // }

  $cabangs = '';
  foreach ($cabang as $key => $value) {
    if ($value != 0) {
      $key == 0 ? $cabangs .= "'".$value."'": $cabangs .= ",'".$value."'";
    }
  }

  $status_call          = get_param("status_call");
  $status_call          == "99" ? $status_call = "0":0;
  $agent_to             = get_param("agent");
  $campaign_id          = get_param("campaign");
  $campaign_priority    = get_param("temp_campaign_priority");
  
  
  $total_data           = get_param("val_num");
  $fomni_id             = get_param("fomni_id");


  $where_status = '';

  ($region != 0 && $region != "") ? $where .= " AND a.$region_field IN ($region) " : 0;
  // $kategori_kendaraan != '0' ? $where .= "AND a.region_code = '$asset_type_kendaraan'" : 0;
  if ($asset != '') {
    $where .= "AND a.asset_type IN ($asset) ";
  }
  // ($cabangs != '') ? $where .= " AND a.cabang_code IN ($cabangs)" : 0;
  ($cabangs != '') ? $where .= " AND a.$branch_field IN ($cabangs)" : 0;

  if ($campaign_id == 1) {
    if($status_call != '0') {
      if ($status_call == 'Fresh' || $status_call == '99') {
        $where .= " AND a.prospect_stat = '' ";
      }else{
        $where .= " AND a.prospect_stat = '$status_call' ";
      }
    }
  }else{
    $sqlsel="";
    if($status_call != '0') {
      if ($status_call == 'Fresh') {
        $where .= " AND a.last_phonecall = '' ";
      }else{
        // if ($last_call_dt == "1") {
          $date_from  .= " 00:00:00";
          $date_to    .= " 23:59:59";
          // get data by period
          $iddes = "";
          $sqlsel = "SELECT DISTINCT(a.agrmnt_no) as iddes
                      FROM cc_ts_penawaran_history a 
                      WHERE 
                      a.call_status=$status_call AND 
                      a.campaign_id=$campaign_id AND 
                      a.create_time >= '$date_from' AND
                      a.create_time <= '$date_to' ORDER BY a.agrmnt_no DESC";
          $ressel = mysqli_query($condb, $sqlsel);
          $rowsel = mysqli_fetch_all($ressel);
          // $iddes  = implode(",", $rowsel);

          $iddes =  implode(', ', array_map(function ($entry) {
                        return $entry[0];
                      }
                    , $rowsel ));

          if ($iddes != "") {
            $where .= " AND a.agrmnt_no IN ($iddes)";
          }else{
            $where .= " AND a.agrmnt_no = 0";
          }
        // }else{
          // $where .= " AND a.call_status IN ($status_call) ";
        // }
      }
    }
  }
  
  switch ($method) {
    case '1':
      $tot_agent            = count($fomni_id);
      $loop_agent           = 0;
      // echo $total_data;
      if ($total_data != 0 || $total_data != '') {
        $tot_assign   = 0;
        $index_assign = 0;
        if ($campaign_id == 1) {
          $sql          = "SELECT a.id FROM cc_ts_penawaran a WHERE a.campaign_id='$campaign_id' $where AND (a.assign_to = $v_agentid OR a.assign_to=0) ORDER BY a.id ASC";
        }else{
          if ($campaign_priority != "") {
            $sql_custno = "SELECT CUST_NO 
                          FROM cc_ts_penawaran_job a
                          LEFT JOIN cc_ts_penawaran_campaign b ON a.campaign_id=b.id
                          WHERE
                          a.CUST_NO IN (SELECT DISTINCT c.CUST_NO FROM cc_ts_penawaran_job c WHERE c.campaign_id=$campaign_id)
                          AND a.is_eligible_crm=1
                          AND b.campaign_priority < $campaign_priority";
            $res_custno = mysqli_query($condb, $sql_custno);
            $row_custno = mysqli_fetch_all($res_custno);
            $param_custno =  implode(', ', array_map(function ($entry) {
                          return "'".$entry[0]."'";
                        }
                      , $row_custno ));
            // $total_data['custno'] = $param_custno;
            if ($param_custno!="") {
              $where .= " AND a.CUST_NO NOT IN ($param_custno)";
            }
          }
          $sql          = "SELECT a.id FROM cc_ts_penawaran_job a WHERE is_assign!=1 AND is_eligible_crm=1 AND is_process=1 AND a.campaign_id='$campaign_id' $where ORDER BY a.id ASC";
        }
        $res          = mysqli_query($condb, $sql);
        while ($row = mysqli_fetch_array($res)) {
          if ($index_assign < $total_data) {
            $id = $row['id'];
            if ($loop_agent == $tot_agent) {
              $loop_agent = 0;
            }
            if ($campaign_id == 1) {
              $tot_process = 0;
              // check is process for backflag
              $sqlbfl = "SELECT COUNT(id) as total_process FROM cc_ts_penawaran WHERE is_process=1 AND id=$id";
              $recbfl = mysqli_query($condb, $sqlbfl);
              if($row = mysqli_fetch_array($recbfl)){
                $tot_process = $row["total_process"];
              }
              mysqli_free_result($recbfl);

              // $backflag = "";
              // if($tot_process>0){
              //   // set backflag
              //   $backflag = ",back_flag = 1";
              // }

              $backflag = ",back_flag = 0";
              // if($tot_process>0){
              //   // if ($flag_void == "0") {
              //     $backflag = ",back_flag = 1";
              //   // }
              // }

              $sqlsa = "UPDATE cc_ts_penawaran SET 
                      assign_to       ='$fomni_id[$loop_agent]',
                      assign_time     =now(),
                      modif_time      =now(),
                      assign_by       ='$v_agentid',
                      call_status     ='0',
                      total_course    ='0',
                      status          ='0'
                      ".$backflag."
                      where id ='$id'"; // echo $sqlsa;
            }else{

              $sqljob = "SELECT * FROM cc_ts_penawaran_job
                        WHERE id=$id";//task_id='$taskId'
              $resjob = mysqli_query($condb,$sqljob);
              if($recjob = mysqli_fetch_array($resjob)){
                @extract($recjob,EXTR_OVERWRITE);

                if ($AGRMNT_NO!='') {
                    $param_agrmen = " agrmnt_no = '$AGRMNT_NO', ";
                    $sqlbfl = "SELECT COUNT(id) as total_process FROM cc_ts_penawaran WHERE is_process=1 AND agrmnt_no='".$AGRMNT_NO."'";
                }else{
                    $param_agrmen = "";
                }

                $param_task = "";
                if ($TASK_ID!='') {
                    $param_task = " task_id = '$TASK_ID', ";
                    $sqlbfl = "SELECT COUNT(id) as total_process FROM cc_ts_penawaran WHERE is_process=1 AND task_id='".$TASK_ID."'";
                }

                $tot_process = 0;
                // check is process for backflag
                $recbfl = mysqli_query($condb, $sqlbfl);
                if($row = mysqli_fetch_array($recbfl)){
                  $tot_process = $row["total_process"];
                }
                mysqli_free_result($recbfl);

                // set backflag
                // $backflag = "";
                // if($tot_process>0){
                //   $backflag = ",back_flag = 1";
                // }else{
                //   $backflag = ",back_flag = 0";
                // }
                $backflag = ",back_flag = 0";
                if($tot_process>0){
                  if ($flag_void == "0") {
                    $backflag = ",back_flag = 1";
                  }else{
                        $sqlvoid = "UPDATE cc_ts_penawaran_job SET flag_void = 0 WHERE id=$id";
                        mysqli_query($condb, $sqlvoid);
                      }
                }
                
                $sqlsa = "INSERT INTO cc_ts_penawaran 
                          SET AGRMNT_ID            = '$AGRMNT_ID', 
                          campaign_id              = '$campaign_id', 
                          $param_agrmen 
                          $param_task
                          pipeline                 = '$PIPELINE_ID', 
                          distributed_date         = '$DISTRIBUTED_DT', 
                          final_result_cae         = '$CAE_FINAL_RESULT', 
                          dukcapil_result          = '$DUKCAPIL_RESULT', 
                          source_data              = '$SOURCE_DATA', 
                          kilat_pintar             = '$KILAT_PINTAR', 
                          region_code              = '$OFFICE_REGION_CODE', 
                          region_name              = '$OFFICE_REGION_NAME', 
                          cabang_code              = '$OFFICE_CODE', 
                          cabang_name              = '$OFFICE_NAME', 
                          cabang_coll              = '$CAB_COLL', 
                          cabang_coll_name         = '$CAB_COLL_NAME', 
                          kapos_name               = '$KAPOS_NAME', 
                          product_offering_code    = '$PROD_OFFERING_CODE', 
                          lob                      = '$LOB_CODE', 
                          customer_id_ro           = '$CUST_NO', 
                          customer_name            = '$CUST_NAME', 
                          nik_ktp                  = '$ID_NO', 
                          gender                   = '$GENDER', 
                          religion                 = '$RELIGION', 
                          tempat_lahir             = '$BIRTH_PLACE', 
                          tanggal_lahir            = '$BIRTH_DT', 
                          spouse_nik               = '$SPOUSE_ID_NO', 
                          spouse_name              = '$SPOUSE_NAME', 
                          spouse_birth_date        = '$SPOUSE_BIRTH_DT', 
                          spouse_birth_place       = '$SPOUSE_BIRTH_PLACE', 
                          legal_alamat             = '$ADDR_LEG', 
                          legal_rt                 = '$RT_LEG', 
                          legal_rw                 = '$RW_LEG', 
                          legal_provinsi           = '$PROVINSI_LEG', 
                          legal_city               = '$CITY_LEG', 
                          legal_kabupaten          = '$KABUPATEN_LEG', 
                          legal_kecamatan          = '$KECAMATAN_LEG', 
                          legal_kelurahan          = '$KELURAHAN_LEG', 
                          legal_kodepos            = '$ZIPCODE_LEG', 
                          legal_sub_kodepos        = '$SUB_ZIPCODE_LEG', 
                          survey_alamat            = '".mysqli_real_escape_string($condb,$ADDR_RES)."', 
                          survey_rt                = '$RT_RES', 
                          survey_rw                = '$RW_RES', 
                          survey_provinsi          = '$PROVINSI_RES', 
                          survey_city              = '$CITY_RES', 
                          survey_kabupaten         = '$KABUPATEN_RES', 
                          survey_kecamatan         = '$KECAMATAN_RES', 
                          survey_kelurahan         = '$KELURAHAN_RES', 
                          survey_kodepos           = '$ZIPCODE_RES', 
                          survey_sub_kodepos       = '$SUB_ZIPCODE_RES', 
                          mobile_1                 = '$MOBILE1', 
                          mobile_2                 = '$MOBILE2', 
                          phone_1                  = '$PHONE1', 
                          phone_2                  = '$PHONE2', 
                          office_phone_1           = '$OFFICE_PHONE1', 
                          office_phone_2           = '$OFFICE_PHONE2', 
                          profession_code          = '$PROFESSION_CODE', 
                          profession_name          = '$PROFESSION_NAME', 
                          profession_category_code = '$PROFESSION_CATEGORY_CODE', 
                          profession_cat_name      = '$PROFESSION_CATEGORY_NAME', 
                          job_position             = '$JOB_POSITION', 
                          industry_type_name       = '$INDUSTRY_TYPE_NAME', 
                          other_biz_name           = '$OTHER_BIZ_NAME', 
                          monthly_income           = '$MONTHLY_INCOME', 
                          monthly_expense          = '$MONTHLY_EXPENSE', 
                          monthly_instalment       = '$MONTHLY_INSTALLMENT', 
                          dp                       = '$DOWNPAYMENT', 
                          dp_pct                   = '$PERCENT_DP', 
                          plafond                  = '$PLAFOND', 
                          customer_rating          = '$CUST_RATING', 
                          suppl_name               = '$SUPPL_NAME', 
                          suppl_code               = '$SUPPL_CODE', 
                          no_mesin                 = '$MACHINE_NO', 
                          no_rangka                = '$CHASSIS_NO', 
                          product_category         = '$PRODUCT_CATEGORY', 
                          asset_category           = '$ASSET_CATEGORY_CODE', 
                          asset_type               = '$ASSET_TYPE', 
                          asset_age                = '$ASSET_AGE', 
                          brand                    = '$ITEM_BRAND', 
                          item_type                = '$ITEM_TYPE', 
                          item_desc                = '$ITEM_DESCRIPTION', 
                          otr_price                = '$OTR_PRICE', 
                          item_year                = '$ITEM_YEAR', 
                          ownership                = '$OWNER_RELATIONSHIP', 
                          kepemilikan_bpkb         = '$BPKB_OWNERSHIP', 
                          agrmnt_rating            = '$AGRMNT_RATING', 
                          status_kontrak           = '$CONTRACT_STAT', 
                          sisa_tenor               = '$OS_TENOR', 
                          tenor                    = '$TENOR', 
                          release_date_bpkb        = '$RELEASE_DATE_BPKB', 
                          maturity_date            = '$MATURITY_DT', 
                          go_live_dt               = '$GO_LIVE_DT', 
                          rrd_date                 = '$AAM_RRD_DT', 
                          os_principal             = '$OS_PRINCIPAL', 
                          os_installment_amt       = '$OS_INTEREST_AMT', 
                          aging_pembiayaan         = '$AGING_PEMBIAYAAN', 
                          jumlah_kontrak_per_cust  = '$JUMLAH_KONTRAK_PERCUST', 
                          estimasi_terima_bersih   = '$ESTIMASI_TERIMA_BERSIH', 
                          started_date             = '$STARTED_DT', 
                          pos_dealer               = '$POS_DEALER', 
                          sales_dealer_id          = '$SALES_DEALER_ID', 
                          sales_dealer             = '$SALES_DEALER', 
                          dtm_crt                  = '$DTM_CRT', 
                          usr_crt                  = '$USR_CRT', 
                          dtm_upd                  = '$DTM_UPD', 
                          usr_upd                  = '$USR_UPD', 
                          customer_id              = '$CUST_ID', 
                          kepemilikan_rumah        = '$HOME_STAT', 
                          nama_ibu_kandung         = '$MOTHER_NAME', 
                          is_repo                  = '$IS_REPO', 
                          is_write_off             = '$IS_WRITE_OFF', 
                          is_restructure           = '$IS_RESTRUKTUR', 
                          is_insurance             = '$IS_INSURANCE', 
                          is_negative              = '$IS_NEGATIVE_CUST', 
                          exposure                 = '$CUST_EXPOSURE', 
                          ltv                      = '$LTV', 
                          dsr                      = '$DSR', 
                          marital_status           = '$MARITAL_STAT', 
                          education                = '$EDUCATION', 
                          length_of_work           = '$LENGTH_OF_WORK', 
                          house_stay_length        = '$HOUSE_STAY_LENGTH', 
                          spouse_phone             = '$SPOUSE_PHONE',
                          spouse_mobile_phone      = '$SPOUSE_MOBILE_PHONE_NO',
                          guarantor_nik            = '$GUARANTOR_ID_NO',
                          guarantor_name           = '$GUARANTOR_NAME',
                          guarantor_mobile_phone   = '$GUARANTOR_MOBILE_PHONE_NO',
                          guarantor_birth_place    = '$GUARANTOR_BIRTH_PLACE',
                          guarantor_birth_date     = '$GUARANTOR_BIRTH_DT',
                          guarantor_address        = '$GUARANTOR_ADDR',
                          guarantor_rt             = '$GUARANTOR_RT',
                          guarantor_rw             = '$GUARANTOR_RW',
                          guarantor_kelurahan      = '$GUARANTOR_KELURAHAN',
                          guarantor_kecamatan      = '$GUARANTOR_KECAMATAN',
                          guarantor_kabupaten      = '$GUARANTOR_CITY',
                          guarantor_provinsi       = '$GUARANTOR_PROVINSI',
                          guarantor_zipcode        = '$GUARANTOR_ZIPCODE',
                          guarantor_relation       = '$GUARANTOR_RELATIONSHIP',
                          created_by               = '$v_agentid', 
                          modif_by                 = '$v_agentid', 
                          insert_time              = now(), 
                          modif_time               = now(), 
                          spv_id                   = '$v_agentid',
                          assign_to                = '$fomni_id[$loop_agent]', 
                          total_course             ='0',
                          call_status              ='0',
                          assign_by                = '$v_agentid', 
                          flag_wise                = '$flag_wise',
                          is_eligible_crm          = '$is_eligible_crm',
                          is_process               = '$is_process',                          
                          assign_time              = now(),
                          is_pre_approval          = '$IS_PRE_APPROVAL'
                          ".$backflag."
                          ON DUPLICATE KEY UPDATE
                          AGRMNT_ID                = '$AGRMNT_ID', 
                          campaign_id              = '$campaign_id', 
                          $param_agrmen
                          $param_task
                          pipeline                 = '$PIPELINE_ID', 
                          distributed_date         = '$DISTRIBUTED_DT', 
                          final_result_cae         = '$CAE_FINAL_RESULT', 
                          dukcapil_result          = '$DUKCAPIL_RESULT', 
                          source_data              = '$SOURCE_DATA', 
                          kilat_pintar             = '$KILAT_PINTAR', 
                          region_code              = '$OFFICE_REGION_CODE', 
                          region_name              = '$OFFICE_REGION_NAME', 
                          cabang_code              = '$OFFICE_CODE', 
                          cabang_name              = '$OFFICE_NAME', 
                          cabang_coll              = '$CAB_COLL', 
                          cabang_coll_name         = '$CAB_COLL_NAME', 
                          kapos_name               = '$KAPOS_NAME', 
                          product_offering_code    = '$PROD_OFFERING_CODE', 
                          lob                      = '$LOB_CODE', 
                          customer_id_ro           = '$CUST_NO', 
                          customer_name            = '$CUST_NAME', 
                          nik_ktp                  = '$ID_NO', 
                          gender                   = '$GENDER', 
                          religion                 = '$RELIGION', 
                          tempat_lahir             = '$BIRTH_PLACE', 
                          tanggal_lahir            = '$BIRTH_DT', 
                          spouse_nik               = '$SPOUSE_ID_NO', 
                          spouse_name              = '$SPOUSE_NAME', 
                          spouse_birth_date        = '$SPOUSE_BIRTH_DT', 
                          spouse_birth_place       = '$SPOUSE_BIRTH_PLACE', 
                          legal_alamat             = '$ADDR_LEG', 
                          legal_rt                 = '$RT_LEG', 
                          legal_rw                 = '$RW_LEG', 
                          legal_provinsi           = '$PROVINSI_LEG', 
                          legal_city               = '$CITY_LEG', 
                          legal_kabupaten          = '$KABUPATEN_LEG', 
                          legal_kecamatan          = '$KECAMATAN_LEG', 
                          legal_kelurahan          = '$KELURAHAN_LEG', 
                          legal_kodepos            = '$ZIPCODE_LEG', 
                          legal_sub_kodepos        = '$SUB_ZIPCODE_LEG', 
                          survey_alamat            = '".mysqli_real_escape_string($condb,$ADDR_RES)."', 
                          survey_rt                = '$RT_RES', 
                          survey_rw                = '$RW_RES', 
                          survey_provinsi          = '$PROVINSI_RES', 
                          survey_city              = '$CITY_RES', 
                          survey_kabupaten         = '$KABUPATEN_RES', 
                          survey_kecamatan         = '$KECAMATAN_RES', 
                          survey_kelurahan         = '$KELURAHAN_RES', 
                          survey_kodepos           = '$ZIPCODE_RES', 
                          survey_sub_kodepos       = '$SUB_ZIPCODE_RES', 
                          mobile_1                 = '$MOBILE1', 
                          mobile_2                 = '$MOBILE2', 
                          phone_1                  = '$PHONE1', 
                          phone_2                  = '$PHONE2', 
                          office_phone_1           = '$OFFICE_PHONE1', 
                          office_phone_2           = '$OFFICE_PHONE2', 
                          profession_code          = '$PROFESSION_CODE', 
                          profession_name          = '$PROFESSION_NAME', 
                          profession_category_code = '$PROFESSION_CATEGORY_CODE', 
                          profession_cat_name      = '$PROFESSION_CATEGORY_NAME', 
                          job_position             = '$JOB_POSITION', 
                          industry_type_name       = '$INDUSTRY_TYPE_NAME', 
                          other_biz_name           = '$OTHER_BIZ_NAME', 
                          monthly_income           = '$MONTHLY_INCOME', 
                          monthly_expense          = '$MONTHLY_EXPENSE', 
                          monthly_instalment       = '$MONTHLY_INSTALLMENT', 
                          dp                       = '$DOWNPAYMENT', 
                          dp_pct                   = '$PERCENT_DP', 
                          plafond                  = '$PLAFOND', 
                          customer_rating          = '$CUST_RATING', 
                          suppl_name               = '$SUPPL_NAME', 
                          suppl_code               = '$SUPPL_CODE', 
                          no_mesin                 = '$MACHINE_NO', 
                          no_rangka                = '$CHASSIS_NO', 
                          product_category         = '$PRODUCT_CATEGORY', 
                          asset_category           = '$ASSET_CATEGORY_CODE', 
                          asset_type               = '$ASSET_TYPE', 
                          asset_age                = '$ASSET_AGE', 
                          brand                    = '$ITEM_BRAND', 
                          item_type                = '$ITEM_TYPE', 
                          item_desc                = '$ITEM_DESCRIPTION', 
                          otr_price                = '$OTR_PRICE', 
                          item_year                = '$ITEM_YEAR', 
                          ownership                = '$OWNER_RELATIONSHIP', 
                          kepemilikan_bpkb         = '$BPKB_OWNERSHIP', 
                          agrmnt_rating            = '$AGRMNT_RATING', 
                          status_kontrak           = '$CONTRACT_STAT', 
                          sisa_tenor               = '$OS_TENOR', 
                          tenor                    = '$TENOR', 
                          release_date_bpkb        = '$RELEASE_DATE_BPKB', 
                          maturity_date            = '$MATURITY_DT', 
                          go_live_dt               = '$GO_LIVE_DT', 
                          rrd_date                 = '$AAM_RRD_DT', 
                          os_principal             = '$OS_PRINCIPAL', 
                          os_installment_amt       = '$OS_INTEREST_AMT', 
                          aging_pembiayaan         = '$AGING_PEMBIAYAAN', 
                          jumlah_kontrak_per_cust  = '$JUMLAH_KONTRAK_PERCUST', 
                          estimasi_terima_bersih   = '$ESTIMASI_TERIMA_BERSIH', 
                          started_date             = '$STARTED_DT', 
                          pos_dealer               = '$POS_DEALER', 
                          sales_dealer_id          = '$SALES_DEALER_ID', 
                          sales_dealer             = '$SALES_DEALER', 
                          dtm_crt                  = '$DTM_CRT', 
                          usr_crt                  = '$USR_CRT', 
                          dtm_upd                  = '$DTM_UPD', 
                          usr_upd                  = '$USR_UPD', 
                          customer_id              = '$CUST_ID', 
                          kepemilikan_rumah        = '$HOME_STAT', 
                          nama_ibu_kandung         = '$MOTHER_NAME', 
                          is_repo                  = '$IS_REPO', 
                          is_write_off             = '$IS_WRITE_OFF', 
                          is_restructure           = '$IS_RESTRUKTUR', 
                          is_insurance             = '$IS_INSURANCE', 
                          is_negative              = '$IS_NEGATIVE_CUST', 
                          exposure                 = '$CUST_EXPOSURE', 
                          ltv                      = '$LTV', 
                          dsr                      = '$DSR', 
                          marital_status           = '$MARITAL_STAT', 
                          education                = '$EDUCATION', 
                          length_of_work           = '$LENGTH_OF_WORK', 
                          house_stay_length        = '$HOUSE_STAY_LENGTH', 
                          spouse_phone             = '$SPOUSE_PHONE',
                          spouse_mobile_phone      = '$SPOUSE_MOBILE_PHONE_NO',
                          guarantor_nik            = '$GUARANTOR_ID_NO',
                          guarantor_name           = '$GUARANTOR_NAME',
                          guarantor_mobile_phone   = '$GUARANTOR_MOBILE_PHONE_NO',
                          guarantor_birth_place    = '$GUARANTOR_BIRTH_PLACE',
                          guarantor_birth_date     = '$GUARANTOR_BIRTH_DT',
                          guarantor_address        = '$GUARANTOR_ADDR',
                          guarantor_rt             = '$GUARANTOR_RT',
                          guarantor_rw             = '$GUARANTOR_RW',
                          guarantor_kelurahan      = '$GUARANTOR_KELURAHAN',
                          guarantor_kecamatan      = '$GUARANTOR_KECAMATAN',
                          guarantor_kabupaten      = '$GUARANTOR_CITY',
                          guarantor_provinsi       = '$GUARANTOR_PROVINSI',
                          guarantor_zipcode        = '$GUARANTOR_ZIPCODE',
                          guarantor_relation       = '$GUARANTOR_RELATIONSHIP',
                          created_by               = '$v_agentid', 
                          modif_by                 = '$v_agentid', 
                          modif_time               = now(), 
                          spv_id                   = '$v_agentid',
                          assign_to                = '$fomni_id[$loop_agent]', 
                          total_course             ='0',
                          call_status              ='0',
                          assign_by                = '$v_agentid', 
                          flag_wise                = '$flag_wise',
                          is_eligible_crm          = '$is_eligible_crm',
                          is_process               = '$is_process',                          
                          assign_time              = now(),
                          is_pre_approval          = '$IS_PRE_APPROVAL'
                          ".$backflag."
                          ";
                          // insert_time              = now(), 
              }
            }
            if(mysqli_query($condb,$sqlsa)){
              if ($campaign_id != 1) {
                $sqlupd = "UPDATE cc_ts_penawaran_job SET is_assign = 1 WHERE id=$id";
                mysqli_query($condb, $sqlupd);

                // delete from temp
                if($param_agrmen != "" || $param_task != ""){
                  $param_agrmen != "" ? $param_agrmen  = " AND ".$param_agrmen:0;
                  $param_task   != "" ? $param_task    = " AND ".$param_task  :0;
                  // $sqldel = "DELETE FROM cc_ts_penawaran_temp WHERE 1=1 ".$param_task." ".$param_agrmen." ";
                  // mysqli_query($condb, $sqldel);
                }

                if($CUST_NO != "" || $CUST_ID != ""){
                  $sqldel = "DELETE FROM cc_ts_penawaran_temp WHERE (customer_id_ro='$CUST_NO' OR customer_id = '$CUST_ID') ";
                  mysqli_query($condb, $sqldel);
                }
            
              $pattern = "/wise/i";
              $is_wise = preg_match_all($pattern, $SOURCE_DATA);

              if ($is_wise > 0) {
                $sqljobcust = "SELECT * FROM cc_ts_penawaran_job
                            WHERE CUST_NO='$CUST_NO' AND is_assign = 0 AND is_process = 1";//task_id='$taskId'
                $resjobcust = mysqli_query($condb,$sqljobcust);
                while($recjobcust = mysqli_fetch_array($resjobcust)){
                  @extract($recjobcust,EXTR_OVERWRITE);

                    if ($AGRMNT_NO!='') {
                        $param_agrmen = " agrmnt_no = '$AGRMNT_NO', ";
                        $sqlbfl = "SELECT COUNT(id) as total_process FROM cc_ts_penawaran WHERE is_process=1 AND agrmnt_no='".$AGRMNT_NO."'";
                    }else{
                        $param_agrmen = "";
                    }

                    $param_task = "";
                    if ($TASK_ID!='') {
                        $param_task = " task_id = '$TASK_ID', ";
                        $sqlbfl = "SELECT COUNT(id) as total_process FROM cc_ts_penawaran WHERE is_process=1 AND task_id='".$TASK_ID."'";
                    }

                    $tot_process = 0;
                    // check is process for backflag
                    $recbfl = mysqli_query($condb, $sqlbfl);
                    if($row = mysqli_fetch_array($recbfl)){
                      $tot_process = $row["total_process"];
                    }
                    mysqli_free_result($recbfl);

                    // set backflag
                    // $backflag = "";
                    // if($tot_process>0){
                    //   $backflag = ",back_flag = 1";
                    // }else{
                    //   $backflag = ",back_flag = 0";
                    // }
                    $backflag = ",back_flag = 0";
                    if($tot_process>0){
                      if ($flag_void == "0") {
                        $backflag = ",back_flag = 1";
                      }else{
                        $sqlvoid = "UPDATE cc_ts_penawaran_job SET flag_void = 0 WHERE id=$id";
                        mysqli_query($condb, $sqlvoid);
                      }
                    }
                    $sqlcust = "INSERT INTO cc_ts_penawaran 
                              SET AGRMNT_ID            = '$AGRMNT_ID', 
                              campaign_id              = '$campaign_id', 
                              $param_agrmen
                              $param_task
                              pipeline                 = '$PIPELINE_ID', 
                              distributed_date         = '$DISTRIBUTED_DT', 
                              final_result_cae         = '$CAE_FINAL_RESULT', 
                              dukcapil_result          = '$DUKCAPIL_RESULT', 
                              source_data              = '$SOURCE_DATA', 
                              kilat_pintar             = '$KILAT_PINTAR', 
                              region_code              = '$OFFICE_REGION_CODE', 
                              region_name              = '$OFFICE_REGION_NAME', 
                              cabang_code              = '$OFFICE_CODE', 
                              cabang_name              = '$OFFICE_NAME', 
                              cabang_coll              = '$CAB_COLL', 
                              cabang_coll_name         = '$CAB_COLL_NAME', 
                              kapos_name               = '$KAPOS_NAME', 
                              product_offering_code    = '$PROD_OFFERING_CODE', 
                              lob                      = '$LOB_CODE', 
                              customer_id_ro           = '$CUST_NO', 
                              customer_name            = '$CUST_NAME', 
                              nik_ktp                  = '$ID_NO', 
                              gender                   = '$GENDER', 
                              religion                 = '$RELIGION', 
                              tempat_lahir             = '$BIRTH_PLACE', 
                              tanggal_lahir            = '$BIRTH_DT', 
                              spouse_nik               = '$SPOUSE_ID_NO', 
                              spouse_name              = '$SPOUSE_NAME', 
                              spouse_birth_date        = '$SPOUSE_BIRTH_DT', 
                              spouse_birth_place       = '$SPOUSE_BIRTH_PLACE', 
                              legal_alamat             = '$ADDR_LEG', 
                              legal_rt                 = '$RT_LEG', 
                              legal_rw                 = '$RW_LEG', 
                              legal_provinsi           = '$PROVINSI_LEG', 
                              legal_city               = '$CITY_LEG', 
                              legal_kabupaten          = '$KABUPATEN_LEG', 
                              legal_kecamatan          = '$KECAMATAN_LEG', 
                              legal_kelurahan          = '$KELURAHAN_LEG', 
                              legal_kodepos            = '$ZIPCODE_LEG', 
                              legal_sub_kodepos        = '$SUB_ZIPCODE_LEG', 
                              survey_alamat            = '".mysqli_real_escape_string($condb,$ADDR_RES)."', 
                              survey_rt                = '$RT_RES', 
                              survey_rw                = '$RW_RES', 
                              survey_provinsi          = '$PROVINSI_RES', 
                              survey_city              = '$CITY_RES', 
                              survey_kabupaten         = '$KABUPATEN_RES', 
                              survey_kecamatan         = '$KECAMATAN_RES', 
                              survey_kelurahan         = '$KELURAHAN_RES', 
                              survey_kodepos           = '$ZIPCODE_RES', 
                              survey_sub_kodepos       = '$SUB_ZIPCODE_RES', 
                              mobile_1                 = '$MOBILE1', 
                              mobile_2                 = '$MOBILE2', 
                              phone_1                  = '$PHONE1', 
                              phone_2                  = '$PHONE2', 
                              office_phone_1           = '$OFFICE_PHONE1', 
                              office_phone_2           = '$OFFICE_PHONE2', 
                              profession_code          = '$PROFESSION_CODE', 
                              profession_name          = '$PROFESSION_NAME', 
                              profession_category_code = '$PROFESSION_CATEGORY_CODE', 
                              profession_cat_name      = '$PROFESSION_CATEGORY_NAME', 
                              job_position             = '$JOB_POSITION', 
                              industry_type_name       = '$INDUSTRY_TYPE_NAME', 
                              other_biz_name           = '$OTHER_BIZ_NAME', 
                              monthly_income           = '$MONTHLY_INCOME', 
                              monthly_expense          = '$MONTHLY_EXPENSE', 
                              monthly_instalment       = '$MONTHLY_INSTALLMENT', 
                              dp                       = '$DOWNPAYMENT', 
                              dp_pct                   = '$PERCENT_DP', 
                              plafond                  = '$PLAFOND', 
                              customer_rating          = '$CUST_RATING', 
                              suppl_name               = '$SUPPL_NAME', 
                              suppl_code               = '$SUPPL_CODE', 
                              no_mesin                 = '$MACHINE_NO', 
                              no_rangka                = '$CHASSIS_NO', 
                              product_category         = '$PRODUCT_CATEGORY', 
                              asset_category           = '$ASSET_CATEGORY_CODE', 
                              asset_type               = '$ASSET_TYPE', 
                              asset_age                = '$ASSET_AGE', 
                              brand                    = '$ITEM_BRAND', 
                              item_type                = '$ITEM_TYPE', 
                              item_desc                = '$ITEM_DESCRIPTION', 
                              otr_price                = '$OTR_PRICE', 
                              item_year                = '$ITEM_YEAR', 
                              ownership                = '$OWNER_RELATIONSHIP', 
                              kepemilikan_bpkb         = '$BPKB_OWNERSHIP', 
                              agrmnt_rating            = '$AGRMNT_RATING', 
                              status_kontrak           = '$CONTRACT_STAT', 
                              sisa_tenor               = '$OS_TENOR', 
                              tenor                    = '$TENOR', 
                              release_date_bpkb        = '$RELEASE_DATE_BPKB', 
                              maturity_date            = '$MATURITY_DT', 
                              go_live_dt               = '$GO_LIVE_DT', 
                              rrd_date                 = '$AAM_RRD_DT', 
                              os_principal             = '$OS_PRINCIPAL', 
                              os_installment_amt       = '$OS_INTEREST_AMT', 
                              aging_pembiayaan         = '$AGING_PEMBIAYAAN', 
                              jumlah_kontrak_per_cust  = '$JUMLAH_KONTRAK_PERCUST', 
                              estimasi_terima_bersih   = '$ESTIMASI_TERIMA_BERSIH', 
                              started_date             = '$STARTED_DT', 
                              pos_dealer               = '$POS_DEALER', 
                              sales_dealer_id          = '$SALES_DEALER_ID', 
                              sales_dealer             = '$SALES_DEALER', 
                              dtm_crt                  = '$DTM_CRT', 
                              usr_crt                  = '$USR_CRT', 
                              dtm_upd                  = '$DTM_UPD', 
                              usr_upd                  = '$USR_UPD', 
                              customer_id              = '$CUST_ID', 
                              kepemilikan_rumah        = '$HOME_STAT', 
                              nama_ibu_kandung         = '$MOTHER_NAME', 
                              is_repo                  = '$IS_REPO', 
                              is_write_off             = '$IS_WRITE_OFF', 
                              is_restructure           = '$IS_RESTRUKTUR', 
                              is_insurance             = '$IS_INSURANCE', 
                              is_negative              = '$IS_NEGATIVE_CUST', 
                              exposure                 = '$CUST_EXPOSURE', 
                              ltv                      = '$LTV', 
                              dsr                      = '$DSR', 
                              marital_status           = '$MARITAL_STAT', 
                              education                = '$EDUCATION', 
                              length_of_work           = '$LENGTH_OF_WORK', 
                              house_stay_length        = '$HOUSE_STAY_LENGTH', 
                              spouse_phone             = '$SPOUSE_PHONE',
                              spouse_mobile_phone      = '$SPOUSE_MOBILE_PHONE_NO',
                              guarantor_nik            = '$GUARANTOR_ID_NO',
                              guarantor_name           = '$GUARANTOR_NAME',
                              guarantor_mobile_phone   = '$GUARANTOR_MOBILE_PHONE_NO',
                              guarantor_birth_place    = '$GUARANTOR_BIRTH_PLACE',
                              guarantor_birth_date     = '$GUARANTOR_BIRTH_DT',
                              guarantor_address        = '$GUARANTOR_ADDR',
                              guarantor_rt             = '$GUARANTOR_RT',
                              guarantor_rw             = '$GUARANTOR_RW',
                              guarantor_kelurahan      = '$GUARANTOR_KELURAHAN',
                              guarantor_kecamatan      = '$GUARANTOR_KECAMATAN',
                              guarantor_kabupaten      = '$GUARANTOR_CITY',
                              guarantor_provinsi       = '$GUARANTOR_PROVINSI',
                              guarantor_zipcode        = '$GUARANTOR_ZIPCODE',
                              guarantor_relation       = '$GUARANTOR_RELATIONSHIP',
                              created_by               = '$v_agentid', 
                              modif_by                 = '$v_agentid', 
                              insert_time              = now(), 
                              modif_time               = now(), 
                              spv_id                   = '$v_agentid',
                              assign_to                = '$fomni_id[$loop_agent]', 
                              total_course             ='0',
                              call_status              ='0',
                              assign_by                = '$v_agentid', 
                              flag_wise                = '$flag_wise',
                              is_eligible_crm          = '$is_eligible_crm',
                              is_process               = '$is_process',                          
                              assign_time              = now(),
                              is_pre_approval          = '$IS_PRE_APPROVAL'
                              ".$backflag."
                              ON DUPLICATE KEY UPDATE
                              AGRMNT_ID                = '$AGRMNT_ID', 
                              campaign_id              = '$campaign_id', 
                              $param_agrmen
                              $param_task
                              pipeline                 = '$PIPELINE_ID', 
                              distributed_date         = '$DISTRIBUTED_DT', 
                              final_result_cae         = '$CAE_FINAL_RESULT', 
                              dukcapil_result          = '$DUKCAPIL_RESULT', 
                              source_data              = '$SOURCE_DATA', 
                              kilat_pintar             = '$KILAT_PINTAR', 
                              region_code              = '$OFFICE_REGION_CODE', 
                              region_name              = '$OFFICE_REGION_NAME', 
                              cabang_code              = '$OFFICE_CODE', 
                              cabang_name              = '$OFFICE_NAME', 
                              cabang_coll              = '$CAB_COLL', 
                              cabang_coll_name         = '$CAB_COLL_NAME', 
                              kapos_name               = '$KAPOS_NAME', 
                              product_offering_code    = '$PROD_OFFERING_CODE', 
                              lob                      = '$LOB_CODE', 
                              customer_id_ro           = '$CUST_NO', 
                              customer_name            = '$CUST_NAME', 
                              nik_ktp                  = '$ID_NO', 
                              gender                   = '$GENDER', 
                              religion                 = '$RELIGION', 
                              tempat_lahir             = '$BIRTH_PLACE', 
                              tanggal_lahir            = '$BIRTH_DT', 
                              spouse_nik               = '$SPOUSE_ID_NO', 
                              spouse_name              = '$SPOUSE_NAME', 
                              spouse_birth_date        = '$SPOUSE_BIRTH_DT', 
                              spouse_birth_place       = '$SPOUSE_BIRTH_PLACE', 
                              legal_alamat             = '$ADDR_LEG', 
                              legal_rt                 = '$RT_LEG', 
                              legal_rw                 = '$RW_LEG', 
                              legal_provinsi           = '$PROVINSI_LEG', 
                              legal_city               = '$CITY_LEG', 
                              legal_kabupaten          = '$KABUPATEN_LEG', 
                              legal_kecamatan          = '$KECAMATAN_LEG', 
                              legal_kelurahan          = '$KELURAHAN_LEG', 
                              legal_kodepos            = '$ZIPCODE_LEG', 
                              legal_sub_kodepos        = '$SUB_ZIPCODE_LEG', 
                              survey_alamat            = '".mysqli_real_escape_string($condb,$ADDR_RES)."', 
                              survey_rt                = '$RT_RES', 
                              survey_rw                = '$RW_RES', 
                              survey_provinsi          = '$PROVINSI_RES', 
                              survey_city              = '$CITY_RES', 
                              survey_kabupaten         = '$KABUPATEN_RES', 
                              survey_kecamatan         = '$KECAMATAN_RES', 
                              survey_kelurahan         = '$KELURAHAN_RES', 
                              survey_kodepos           = '$ZIPCODE_RES', 
                              survey_sub_kodepos       = '$SUB_ZIPCODE_RES', 
                              mobile_1                 = '$MOBILE1', 
                              mobile_2                 = '$MOBILE2', 
                              phone_1                  = '$PHONE1', 
                              phone_2                  = '$PHONE2', 
                              office_phone_1           = '$OFFICE_PHONE1', 
                              office_phone_2           = '$OFFICE_PHONE2', 
                              profession_code          = '$PROFESSION_CODE', 
                              profession_name          = '$PROFESSION_NAME', 
                              profession_category_code = '$PROFESSION_CATEGORY_CODE', 
                              profession_cat_name      = '$PROFESSION_CATEGORY_NAME', 
                              job_position             = '$JOB_POSITION', 
                              industry_type_name       = '$INDUSTRY_TYPE_NAME', 
                              other_biz_name           = '$OTHER_BIZ_NAME', 
                              monthly_income           = '$MONTHLY_INCOME', 
                              monthly_expense          = '$MONTHLY_EXPENSE', 
                              monthly_instalment       = '$MONTHLY_INSTALLMENT', 
                              dp                       = '$DOWNPAYMENT', 
                              dp_pct                   = '$PERCENT_DP', 
                              plafond                  = '$PLAFOND', 
                              customer_rating          = '$CUST_RATING', 
                              suppl_name               = '$SUPPL_NAME', 
                              suppl_code               = '$SUPPL_CODE', 
                              no_mesin                 = '$MACHINE_NO', 
                              no_rangka                = '$CHASSIS_NO', 
                              product_category         = '$PRODUCT_CATEGORY', 
                              asset_category           = '$ASSET_CATEGORY_CODE', 
                              asset_type               = '$ASSET_TYPE', 
                              asset_age                = '$ASSET_AGE', 
                              brand                    = '$ITEM_BRAND', 
                              item_type                = '$ITEM_TYPE', 
                              item_desc                = '$ITEM_DESCRIPTION', 
                              otr_price                = '$OTR_PRICE', 
                              item_year                = '$ITEM_YEAR', 
                              ownership                = '$OWNER_RELATIONSHIP', 
                              kepemilikan_bpkb         = '$BPKB_OWNERSHIP', 
                              agrmnt_rating            = '$AGRMNT_RATING', 
                              status_kontrak           = '$CONTRACT_STAT', 
                              sisa_tenor               = '$OS_TENOR', 
                              tenor                    = '$TENOR', 
                              release_date_bpkb        = '$RELEASE_DATE_BPKB', 
                              maturity_date            = '$MATURITY_DT', 
                              go_live_dt               = '$GO_LIVE_DT', 
                              rrd_date                 = '$AAM_RRD_DT', 
                              os_principal             = '$OS_PRINCIPAL', 
                              os_installment_amt       = '$OS_INTEREST_AMT', 
                              aging_pembiayaan         = '$AGING_PEMBIAYAAN', 
                              jumlah_kontrak_per_cust  = '$JUMLAH_KONTRAK_PERCUST', 
                              estimasi_terima_bersih   = '$ESTIMASI_TERIMA_BERSIH', 
                              started_date             = '$STARTED_DT', 
                              pos_dealer               = '$POS_DEALER', 
                              sales_dealer_id          = '$SALES_DEALER_ID', 
                              sales_dealer             = '$SALES_DEALER', 
                              dtm_crt                  = '$DTM_CRT', 
                              usr_crt                  = '$USR_CRT', 
                              dtm_upd                  = '$DTM_UPD', 
                              usr_upd                  = '$USR_UPD', 
                              customer_id              = '$CUST_ID', 
                              kepemilikan_rumah        = '$HOME_STAT', 
                              nama_ibu_kandung         = '$MOTHER_NAME', 
                              is_repo                  = '$IS_REPO', 
                              is_write_off             = '$IS_WRITE_OFF', 
                              is_restructure           = '$IS_RESTRUKTUR', 
                              is_insurance             = '$IS_INSURANCE', 
                              is_negative              = '$IS_NEGATIVE_CUST', 
                              exposure                 = '$CUST_EXPOSURE', 
                              ltv                      = '$LTV', 
                              dsr                      = '$DSR', 
                              marital_status           = '$MARITAL_STAT', 
                              education                = '$EDUCATION', 
                              length_of_work           = '$LENGTH_OF_WORK', 
                              house_stay_length        = '$HOUSE_STAY_LENGTH', 
                              spouse_phone             = '$SPOUSE_PHONE',
                              spouse_mobile_phone      = '$SPOUSE_MOBILE_PHONE_NO',
                              guarantor_nik            = '$GUARANTOR_ID_NO',
                              guarantor_name           = '$GUARANTOR_NAME',
                              guarantor_mobile_phone   = '$GUARANTOR_MOBILE_PHONE_NO',
                              guarantor_birth_place    = '$GUARANTOR_BIRTH_PLACE',
                              guarantor_birth_date     = '$GUARANTOR_BIRTH_DT',
                              guarantor_address        = '$GUARANTOR_ADDR',
                              guarantor_rt             = '$GUARANTOR_RT',
                              guarantor_rw             = '$GUARANTOR_RW',
                              guarantor_kelurahan      = '$GUARANTOR_KELURAHAN',
                              guarantor_kecamatan      = '$GUARANTOR_KECAMATAN',
                              guarantor_kabupaten      = '$GUARANTOR_CITY',
                              guarantor_provinsi       = '$GUARANTOR_PROVINSI',
                              guarantor_zipcode        = '$GUARANTOR_ZIPCODE',
                              guarantor_relation       = '$GUARANTOR_RELATIONSHIP',
                              created_by               = '$v_agentid', 
                              modif_by                 = '$v_agentid', 
                              modif_time               = now(), 
                              spv_id                   = '$v_agentid',
                              assign_to                = '$fomni_id[$loop_agent]', 
                              total_course             ='0',
                              call_status              ='0',
                              assign_by                = '$v_agentid', 
                              flag_wise                = '$flag_wise',
                              is_eligible_crm          = '$is_eligible_crm',
                              is_process               = '$is_process',                          
                              assign_time              = now(),
                              is_pre_approval          = '$IS_PRE_APPROVAL'
                              ".$backflag."
                              ";
                              // insert_time              = now(), 
                              mysqli_query($condb, $sqlcust);

                              // delete from temp
                              // if($param_agrmen != "" || $param_task != ""){
                              //   $param_agrmen != "" ? $param_agrmen  = " AND ".$param_agrmen:0;
                              //   $param_task   != "" ? $param_task    = " AND ".$param_task  :0;
                              //   $sqldel = "DELETE FROM cc_ts_penawaran_temp WHERE 1=1 ".$param_task." ".$param_agrmen." ";
                              //   mysqli_query($condb, $sqldel);
                              // }
                              
                            $sqlupd = "UPDATE cc_ts_penawaran_job SET is_assign = 1 WHERE id=$id";
                            mysqli_query($condb, $sqlupd);
                } // end of while
              } // end of is wise condition


              // $sqlcust = "UPDATE cc_ts_penawaran SET 
              //       assign_to            ='$fomni_id[$loop_agent]',
              //       assign_time          =now(),
              //       assign_by            ='$v_agentid'
              //       where customer_id_ro ='$CUST_NO'";
              //       mysqli_query($condb,$sqlcust);
              }else{
                $sqlsel = "SELECT customer_id, customer_id_ro FROM cc_ts_penawaran WHERE id ='$id'";
                $ressel = mysqli_query($condb, $sqlsel);
                if($rowsel = mysqli_fetch_array($ressel)){
                  $custid     = $rowsel["customer_id"];
                  $custid_ro  = $rowsel["customer_id_ro"];
                  if($custid != "" || $custid_ro != ""){
                    $sqldel = "DELETE FROM cc_ts_penawaran_temp WHERE  id ='$id'";
                    mysqli_query($condb, $sqldel);
                  }
                }
              }

              // $sqllog = "INSERT INTO cc_ts_consumer_detail_log (id_cust_detail,  polo_order_in_id,  distributed_date,  source_data,  region_code,  region_name,  cabang_code,  cabang_name,  cabang_coll,  cabang_coll_name,  kapos_name,  agrmnt_no,  order_no,  product,  product_cat,  product_offering_code,  order_no_ro,  customer_id,  customer_name,  nik_ktp,  religion,  tempat_lahir,  tanggal_lahir,  nama_pasangan,  tanggal_lahir_pasangan,  child_name,  child_birthdate,  legal_alamat,  legal_rt,  legal_rw,  legal_provinsi,  legal_kabupaten,  legal_city,  legal_kecamatan,  legal_kelurahan,  legal_kodepos,  legal_sub_kodepos,  survey_alamat,  survey_rt,  survey_rw,  survey_provinsi,  survey_kabupaten,  survey_city,  survey_kecamatan,  survey_kelurahan,  survey_kodepos,  survey_sub_kodepos,  city_id,  gender,  mobile_1,  mobile_2,  phone_1,  phone_2,  office_phone_1,  office_phone_2,  profession_name,  profession_cat_name,  job_position,  industry_type_name,  monthly_income,  monthly_instalment,  plafond,  cust_rating,  suppl_name,  suppl_code,  pekerjaan,  jenis_pekerjaan,  detail_pekerjaan,  oth_biz_name,  hobby,  kepemilikan_rumah,  customer_id_ro,  customer_rating,  nama_dealer,  kode_dealer,  no_mesin,  no_rangka,  asset_type,  asset_category,  asset_desc,  asset_price_amount,  item_id,  item_type,  item_desc,  item_year,  otr_price,  kepemilikan_bpkb,  agrmnt_rating,  status_kontrak,  angsuran_ke,  sisa_tenor,  tenor,  release_date_bpkb,  max_past_due_date,  tanggal_jatuh_tempo,  maturity_date,  os_principal,  product_category,  sisa_piutang,  kilat_pintar,  aging_pembiayaan,  jumlah_kontrak_per_cust,  estimasi_terima_bersih,  cycling,  task_id,  jenis_task,  soa,  down_payment,  ltv,  call_stat,  answer_call,  prospect_stat,  reason_not_prospect,  confirmation,  notes,  sla_remaining,  started_date,  emp_position,  application_id,  application_ia,  dukcapil_stat,  field_person_name,  negative_cust,  notes_new_lead,  visit_dt,  input_dt,  sub_sitrict_kat_code,  contact_no,  source_data_mss,  referantor_code,  referantor_name,  supervisor_name,  note_telesales,  submited_dt,  mss_stat,  wise_stat,  visit_stat,  survey_stat,  flag_void_sla,  eligible_flag,  eligible_flag_dt,  dtm_crt,  usr_crt,  rtm_upd,  usr_upd,  app_no,  application_stat,  bpkb_out,  brand,  city_leg,  city_res,  cust_photo,  dp_pct,  f_card_photo,  ia_app,  id_photo,  jenis_pembiayaan,  monthly_expense,  npwp_no,  order_id,  other_biz_name,  ownership,  pos_dealer,  promotion_activity,  referantor_code_1,  referantor_code_2,  referantor_name_1,  referantor_name_2,  sales_dealer,  send_flag_wise,  spouse_id_photo,  send_flag_mss,  flag_pre_ia,  task_id_mss,  profession_code,  sales_dealer_id,  profession_category_code,  flag_void_sla_tele,  status_task_mss,  priority_level,  outstand_principal,  outstand_monthly_instalment,  rrd_date,  group_id,  sumber_order,  special_cash_flag,  created_by,  modif_by,  insert_time,  modif_time,  campaign_id,  external_code,  priority,  branch_name,  phone,  product_type,  vehicle_year,  plafond_price,  installment_price,  referentor,  desc_note,  desc_note_adv,  assign_by,  assign_to,  assign_time,  reassign,  reassign_by,  reassign_time,  first_call_time,  first_followup_by,  last_call_time,  last_followup_by,  call_status,  call_status_sub1,  call_status_sub2,  total_dial,  total_phone,  total_course,  status,  status_bypass,  status_approve,  close_time,  close_by,  close_approve_time,  close_approve_by,  qa_approve_status,  qa_approve_note,  qa_approve_time,  qa_approve_by)
              //                 SELECT * FROM cc_ts_consumer_detail
              //                 WHERE id='$id'";
              // mysqli_query($condb,$sqllog);
              $tot_assign += 1;

              $agnt_id='';
              $agnt_id = $fomni_id[$loop_agent];
              $tot_peragent[$agnt_id] = $tot_peragent[$agnt_id]+1; 
              $param_updt .="|".$sqlsa;

              $loop_agent++;
            }
            $index_assign++;
          }else{
            // break;
            $sqlins = "INSERT INTO cc_agent_trail_log SET agent_id = '".$v_agentid."', trail_desc='failed from id : $id, QUERY : $sqlsa', insert_time=now()";
            mysqli_query($condb, $sqlins);
          }
        }

        //start new 
        $detail_assign="";
        foreach($tot_peragent as $x => $val) {
          if ($detail_assign=="") {
            $detail_assign = "$x : $val ";
          }else{
            $detail_assign .= ", $x : $val ";
          }
          
        }
        $param_updt = mysqli_real_escape_string($condb, $param_updt);
        //end new

        if ($tot_assign > 0) {
          $sqlins = "INSERT INTO cc_agent_trail_log SET agent_id = '".$v_agentid."', trail_desc='Success, ".$tot_assign.", ".$total_data.",|$detail_assign|, QUERY : ".mysqli_real_escape_string($condb, $sql)."', insert_time=now()";
          mysqli_query($condb, $sqlins);

          echo 'Success!|'.$tot_assign.'|'.$total_data;//."|".$sqlsa;
        }else{
          if ($total_data > 0) {
            $sqlins = "INSERT INTO cc_agent_trail_log SET agent_id = '".$v_agentid."', trail_desc='Failed Error, ".$tot_assign.", ".$total_data.",|$detail_assign|,$param_updt, QUERY : ".mysqli_real_escape_string($condb, $sql)."', insert_time=now()";
            mysqli_query($condb, $sqlins);
            echo 'Failed! Error|'.$sqlsa;//.$sqlsa;
          }else{
            echo "Failed! Data Not Found|";//.$sql;
          }
        }
      }

      break;
    case '2':
      $total      = 0; 
      $success    = 0; 
      $failed     = 0; 
      $lengtideb  = explode(",", $iddeb);
      for ($i=1; $i <= count($lengtideb)-1; $i++) {
        if ($campaign_id == 1) {
          $tot_process = 0;
          // check is process for backflag
          $sqlbfl = "SELECT COUNT(id) as total_process FROM cc_ts_penawaran WHERE is_process=1 AND id='$lengtideb[$i]'";
          $recbfl = mysqli_query($condb, $sqlbfl);
          if($row = mysqli_fetch_array($recbfl)){
            $tot_process = $row["total_process"];
          }
          mysqli_free_result($recbfl);

          $backflag = "";
          if($tot_process>0){
            // set backflag
            $backflag = ",back_flag = 1";
          }

          $sqlsa = "UPDATE cc_ts_penawaran SET 
                    assign_to       ='$agent_to',
                    total_course    ='0',
                    assign_time     =now(),
                    modif_time      =now(),
                    assign_by       ='$v_agentid',
                    call_status     ='0',
                    status          ='0'
                    ".$backflag."
                    where id ='$lengtideb[$i]'"; //echo $sqlsa; 
        }else{
          

              $sqljob = "SELECT * FROM cc_ts_penawaran_job
                        WHERE id='$lengtideb[$i]'";//task_id='$taskId'
              $resjob = mysqli_query($condb,$sqljob);
              if($recjob = mysqli_fetch_array($resjob)){
                @extract($recjob,EXTR_OVERWRITE);

                if ($AGRMNT_NO!='') {
                    $param_agrmen = " agrmnt_no = '$AGRMNT_NO', ";
                    $sqlbfl = "SELECT COUNT(id) as total_process FROM cc_ts_penawaran WHERE is_process=1 AND agrmnt_no='".$AGRMNT_NO."'";
                }else{
                    $param_agrmen = "";
                }

                $param_task = "";
                if ($TASK_ID!='') {
                    $param_task = " task_id = '$TASK_ID', ";
                    $sqlbfl = "SELECT COUNT(id) as total_process FROM cc_ts_penawaran WHERE is_process=1 AND task_id='".$TASK_ID."'";
                }

                $tot_process = 0;
                // check is process for backflag
                $recbfl = mysqli_query($condb, $sqlbfl);
                if($row = mysqli_fetch_array($recbfl)){
                  $tot_process = $row["total_process"];
                }
                mysqli_free_result($recbfl);

                // set backflag
                // $backflag = "";
                // if($tot_process>0){
                //   $backflag = ",back_flag = 1";
                // }else{
                //   $backflag = ",back_flag = 0";
                // }

                $backflag = ",back_flag = 0";
                if($tot_process>0){
                  if ($flag_void == "0") {
                    $backflag = ",back_flag = 1";
                  }else{
                        $sqlvoid = "UPDATE cc_ts_penawaran_job SET flag_void = 0 WHERE id=$id";
                        mysqli_query($condb, $sqlvoid);
                      }
                }

                $sqlsa = "INSERT INTO cc_ts_penawaran 
                          SET AGRMNT_ID            = '$AGRMNT_ID', 
                          campaign_id              = '$campaign_id', 
                          $param_agrmen 
                          $param_task
                          pipeline                 = '$PIPELINE_ID', 
                          distributed_date         = '$DISTRIBUTED_DT', 
                          final_result_cae         = '$CAE_FINAL_RESULT', 
                          dukcapil_result          = '$DUKCAPIL_RESULT', 
                          source_data              = '$SOURCE_DATA', 
                          kilat_pintar             = '$KILAT_PINTAR', 
                          region_code              = '$OFFICE_REGION_CODE', 
                          region_name              = '$OFFICE_REGION_NAME', 
                          cabang_code              = '$OFFICE_CODE', 
                          cabang_name              = '$OFFICE_NAME', 
                          cabang_coll              = '$CAB_COLL', 
                          cabang_coll_name         = '$CAB_COLL_NAME', 
                          kapos_name               = '$KAPOS_NAME', 
                          product_offering_code    = '$PROD_OFFERING_CODE', 
                          lob                      = '$LOB_CODE', 
                          customer_id_ro           = '$CUST_NO', 
                          customer_name            = '$CUST_NAME', 
                          nik_ktp                  = '$ID_NO', 
                          gender                   = '$GENDER', 
                          religion                 = '$RELIGION', 
                          tempat_lahir             = '$BIRTH_PLACE', 
                          tanggal_lahir            = '$BIRTH_DT', 
                          spouse_nik               = '$SPOUSE_ID_NO', 
                          spouse_name              = '$SPOUSE_NAME', 
                          spouse_birth_date        = '$SPOUSE_BIRTH_DT', 
                          spouse_birth_place       = '$SPOUSE_BIRTH_PLACE', 
                          legal_alamat             = '$ADDR_LEG', 
                          legal_rt                 = '$RT_LEG', 
                          legal_rw                 = '$RW_LEG', 
                          legal_provinsi           = '$PROVINSI_LEG', 
                          legal_city               = '$CITY_LEG', 
                          legal_kabupaten          = '$KABUPATEN_LEG', 
                          legal_kecamatan          = '$KECAMATAN_LEG', 
                          legal_kelurahan          = '$KELURAHAN_LEG', 
                          legal_kodepos            = '$ZIPCODE_LEG', 
                          legal_sub_kodepos        = '$SUB_ZIPCODE_LEG', 
                          survey_alamat            = '".mysqli_real_escape_string($condb,$ADDR_RES)."', 
                          survey_rt                = '$RT_RES', 
                          survey_rw                = '$RW_RES', 
                          survey_provinsi          = '$PROVINSI_RES', 
                          survey_city              = '$CITY_RES', 
                          survey_kabupaten         = '$KABUPATEN_RES', 
                          survey_kecamatan         = '$KECAMATAN_RES', 
                          survey_kelurahan         = '$KELURAHAN_RES', 
                          survey_kodepos           = '$ZIPCODE_RES', 
                          survey_sub_kodepos       = '$SUB_ZIPCODE_RES', 
                          mobile_1                 = '$MOBILE1', 
                          mobile_2                 = '$MOBILE2', 
                          phone_1                  = '$PHONE1', 
                          phone_2                  = '$PHONE2', 
                          office_phone_1           = '$OFFICE_PHONE1', 
                          office_phone_2           = '$OFFICE_PHONE2', 
                          profession_code          = '$PROFESSION_CODE', 
                          profession_name          = '$PROFESSION_NAME', 
                          profession_category_code = '$PROFESSION_CATEGORY_CODE', 
                          profession_cat_name      = '$PROFESSION_CATEGORY_NAME', 
                          job_position             = '$JOB_POSITION', 
                          industry_type_name       = '$INDUSTRY_TYPE_NAME', 
                          other_biz_name           = '$OTHER_BIZ_NAME', 
                          monthly_income           = '$MONTHLY_INCOME', 
                          monthly_expense          = '$MONTHLY_EXPENSE', 
                          monthly_instalment       = '$MONTHLY_INSTALLMENT', 
                          dp                       = '$DOWNPAYMENT', 
                          dp_pct                   = '$PERCENT_DP', 
                          plafond                  = '$PLAFOND', 
                          customer_rating          = '$CUST_RATING', 
                          suppl_name               = '$SUPPL_NAME', 
                          suppl_code               = '$SUPPL_CODE', 
                          no_mesin                 = '$MACHINE_NO', 
                          no_rangka                = '$CHASSIS_NO', 
                          product_category         = '$PRODUCT_CATEGORY', 
                          asset_category           = '$ASSET_CATEGORY_CODE', 
                          asset_type               = '$ASSET_TYPE', 
                          asset_age                = '$ASSET_AGE', 
                          brand                    = '$ITEM_BRAND', 
                          item_type                = '$ITEM_TYPE', 
                          item_desc                = '$ITEM_DESCRIPTION', 
                          otr_price                = '$OTR_PRICE', 
                          item_year                = '$ITEM_YEAR', 
                          ownership                = '$OWNER_RELATIONSHIP', 
                          kepemilikan_bpkb         = '$BPKB_OWNERSHIP', 
                          agrmnt_rating            = '$AGRMNT_RATING', 
                          status_kontrak           = '$CONTRACT_STAT', 
                          sisa_tenor               = '$OS_TENOR', 
                          tenor                    = '$TENOR', 
                          release_date_bpkb        = '$RELEASE_DATE_BPKB', 
                          maturity_date            = '$MATURITY_DT', 
                          go_live_dt               = '$GO_LIVE_DT', 
                          rrd_date                 = '$AAM_RRD_DT', 
                          os_principal             = '$OS_PRINCIPAL', 
                          os_installment_amt       = '$OS_INTEREST_AMT', 
                          aging_pembiayaan         = '$AGING_PEMBIAYAAN', 
                          jumlah_kontrak_per_cust  = '$JUMLAH_KONTRAK_PERCUST', 
                          estimasi_terima_bersih   = '$ESTIMASI_TERIMA_BERSIH', 
                          started_date             = '$STARTED_DT', 
                          pos_dealer               = '$POS_DEALER', 
                          sales_dealer_id          = '$SALES_DEALER_ID', 
                          sales_dealer             = '$SALES_DEALER', 
                          dtm_crt                  = '$DTM_CRT', 
                          usr_crt                  = '$USR_CRT', 
                          dtm_upd                  = '$DTM_UPD', 
                          usr_upd                  = '$USR_UPD', 
                          customer_id              = '$CUST_ID', 
                          kepemilikan_rumah        = '$HOME_STAT', 
                          nama_ibu_kandung         = '$MOTHER_NAME', 
                          is_repo                  = '$IS_REPO', 
                          is_write_off             = '$IS_WRITE_OFF', 
                          is_restructure           = '$IS_RESTRUKTUR', 
                          is_insurance             = '$IS_INSURANCE', 
                          is_negative              = '$IS_NEGATIVE_CUST', 
                          exposure                 = '$CUST_EXPOSURE', 
                          ltv                      = '$LTV', 
                          dsr                      = '$DSR', 
                          marital_status           = '$MARITAL_STAT', 
                          education                = '$EDUCATION', 
                          length_of_work           = '$LENGTH_OF_WORK', 
                          house_stay_length        = '$HOUSE_STAY_LENGTH', 
                          spouse_phone             = '$SPOUSE_PHONE',
                          spouse_mobile_phone      = '$SPOUSE_MOBILE_PHONE_NO',
                          guarantor_nik            = '$GUARANTOR_ID_NO',
                          guarantor_name           = '$GUARANTOR_NAME',
                          guarantor_mobile_phone   = '$GUARANTOR_MOBILE_PHONE_NO',
                          guarantor_birth_place    = '$GUARANTOR_BIRTH_PLACE',
                          guarantor_birth_date     = '$GUARANTOR_BIRTH_DT',
                          guarantor_address        = '$GUARANTOR_ADDR',
                          guarantor_rt             = '$GUARANTOR_RT',
                          guarantor_rw             = '$GUARANTOR_RW',
                          guarantor_kelurahan      = '$GUARANTOR_KELURAHAN',
                          guarantor_kecamatan      = '$GUARANTOR_KECAMATAN',
                          guarantor_kabupaten      = '$GUARANTOR_CITY',
                          guarantor_provinsi       = '$GUARANTOR_PROVINSI',
                          guarantor_zipcode        = '$GUARANTOR_ZIPCODE',
                          guarantor_relation       = '$GUARANTOR_RELATIONSHIP',
                          created_by               = '$v_agentid', 
                          modif_by                 = '$v_agentid', 
                          insert_time              = now(), 
                          modif_time               = now(), 
                          spv_id                   = '$v_agentid',
                          assign_to                = '$agent_to', 
                          total_course             ='0',
                          call_status              ='0',
                          assign_by                = '$v_agentid', 
                          flag_wise                = '$flag_wise',
                          is_eligible_crm          = '$is_eligible_crm',
                          is_process               = '$is_process',                          
                          assign_time              = now(),
                          is_pre_approval          = '$IS_PRE_APPROVAL'
                          ".$backflag."
                          ON DUPLICATE KEY UPDATE
                          AGRMNT_ID                = '$AGRMNT_ID', 
                          campaign_id              = '$campaign_id', 
                          $param_agrmen
                          $param_task
                          pipeline                 = '$PIPELINE_ID', 
                          distributed_date         = '$DISTRIBUTED_DT', 
                          final_result_cae         = '$CAE_FINAL_RESULT', 
                          dukcapil_result          = '$DUKCAPIL_RESULT', 
                          source_data              = '$SOURCE_DATA', 
                          kilat_pintar             = '$KILAT_PINTAR', 
                          region_code              = '$OFFICE_REGION_CODE', 
                          region_name              = '$OFFICE_REGION_NAME', 
                          cabang_code              = '$OFFICE_CODE', 
                          cabang_name              = '$OFFICE_NAME', 
                          cabang_coll              = '$CAB_COLL', 
                          cabang_coll_name         = '$CAB_COLL_NAME', 
                          kapos_name               = '$KAPOS_NAME', 
                          product_offering_code    = '$PROD_OFFERING_CODE', 
                          lob                      = '$LOB_CODE', 
                          customer_id_ro           = '$CUST_NO', 
                          customer_name            = '$CUST_NAME', 
                          nik_ktp                  = '$ID_NO', 
                          gender                   = '$GENDER', 
                          religion                 = '$RELIGION', 
                          tempat_lahir             = '$BIRTH_PLACE', 
                          tanggal_lahir            = '$BIRTH_DT', 
                          spouse_nik               = '$SPOUSE_ID_NO', 
                          spouse_name              = '$SPOUSE_NAME', 
                          spouse_birth_date        = '$SPOUSE_BIRTH_DT', 
                          spouse_birth_place       = '$SPOUSE_BIRTH_PLACE', 
                          legal_alamat             = '$ADDR_LEG', 
                          legal_rt                 = '$RT_LEG', 
                          legal_rw                 = '$RW_LEG', 
                          legal_provinsi           = '$PROVINSI_LEG', 
                          legal_city               = '$CITY_LEG', 
                          legal_kabupaten          = '$KABUPATEN_LEG', 
                          legal_kecamatan          = '$KECAMATAN_LEG', 
                          legal_kelurahan          = '$KELURAHAN_LEG', 
                          legal_kodepos            = '$ZIPCODE_LEG', 
                          legal_sub_kodepos        = '$SUB_ZIPCODE_LEG', 
                          survey_alamat            = '".mysqli_real_escape_string($condb,$ADDR_RES)."', 
                          survey_rt                = '$RT_RES', 
                          survey_rw                = '$RW_RES', 
                          survey_provinsi          = '$PROVINSI_RES', 
                          survey_city              = '$CITY_RES', 
                          survey_kabupaten         = '$KABUPATEN_RES', 
                          survey_kecamatan         = '$KECAMATAN_RES', 
                          survey_kelurahan         = '$KELURAHAN_RES', 
                          survey_kodepos           = '$ZIPCODE_RES', 
                          survey_sub_kodepos       = '$SUB_ZIPCODE_RES', 
                          mobile_1                 = '$MOBILE1', 
                          mobile_2                 = '$MOBILE2', 
                          phone_1                  = '$PHONE1', 
                          phone_2                  = '$PHONE2', 
                          office_phone_1           = '$OFFICE_PHONE1', 
                          office_phone_2           = '$OFFICE_PHONE2', 
                          profession_code          = '$PROFESSION_CODE', 
                          profession_name          = '$PROFESSION_NAME', 
                          profession_category_code = '$PROFESSION_CATEGORY_CODE', 
                          profession_cat_name      = '$PROFESSION_CATEGORY_NAME', 
                          job_position             = '$JOB_POSITION', 
                          industry_type_name       = '$INDUSTRY_TYPE_NAME', 
                          other_biz_name           = '$OTHER_BIZ_NAME', 
                          monthly_income           = '$MONTHLY_INCOME', 
                          monthly_expense          = '$MONTHLY_EXPENSE', 
                          monthly_instalment       = '$MONTHLY_INSTALLMENT', 
                          dp                       = '$DOWNPAYMENT', 
                          dp_pct                   = '$PERCENT_DP', 
                          plafond                  = '$PLAFOND', 
                          customer_rating          = '$CUST_RATING', 
                          suppl_name               = '$SUPPL_NAME', 
                          suppl_code               = '$SUPPL_CODE', 
                          no_mesin                 = '$MACHINE_NO', 
                          no_rangka                = '$CHASSIS_NO', 
                          product_category         = '$PRODUCT_CATEGORY', 
                          asset_category           = '$ASSET_CATEGORY_CODE', 
                          asset_type               = '$ASSET_TYPE', 
                          asset_age                = '$ASSET_AGE', 
                          brand                    = '$ITEM_BRAND', 
                          item_type                = '$ITEM_TYPE', 
                          item_desc                = '$ITEM_DESCRIPTION', 
                          otr_price                = '$OTR_PRICE', 
                          item_year                = '$ITEM_YEAR', 
                          ownership                = '$OWNER_RELATIONSHIP', 
                          kepemilikan_bpkb         = '$BPKB_OWNERSHIP', 
                          agrmnt_rating            = '$AGRMNT_RATING', 
                          status_kontrak           = '$CONTRACT_STAT', 
                          sisa_tenor               = '$OS_TENOR', 
                          tenor                    = '$TENOR', 
                          release_date_bpkb        = '$RELEASE_DATE_BPKB', 
                          maturity_date            = '$MATURITY_DT', 
                          go_live_dt               = '$GO_LIVE_DT', 
                          rrd_date                 = '$AAM_RRD_DT', 
                          os_principal             = '$OS_PRINCIPAL', 
                          os_installment_amt       = '$OS_INTEREST_AMT', 
                          aging_pembiayaan         = '$AGING_PEMBIAYAAN', 
                          jumlah_kontrak_per_cust  = '$JUMLAH_KONTRAK_PERCUST', 
                          estimasi_terima_bersih   = '$ESTIMASI_TERIMA_BERSIH', 
                          started_date             = '$STARTED_DT', 
                          pos_dealer               = '$POS_DEALER', 
                          sales_dealer_id          = '$SALES_DEALER_ID', 
                          sales_dealer             = '$SALES_DEALER', 
                          dtm_crt                  = '$DTM_CRT', 
                          usr_crt                  = '$USR_CRT', 
                          dtm_upd                  = '$DTM_UPD', 
                          usr_upd                  = '$USR_UPD', 
                          customer_id              = '$CUST_ID', 
                          kepemilikan_rumah        = '$HOME_STAT', 
                          nama_ibu_kandung         = '$MOTHER_NAME', 
                          is_repo                  = '$IS_REPO', 
                          is_write_off             = '$IS_WRITE_OFF', 
                          is_restructure           = '$IS_RESTRUKTUR', 
                          is_insurance             = '$IS_INSURANCE', 
                          is_negative              = '$IS_NEGATIVE_CUST', 
                          exposure                 = '$CUST_EXPOSURE', 
                          ltv                      = '$LTV', 
                          dsr                      = '$DSR', 
                          marital_status           = '$MARITAL_STAT', 
                          education                = '$EDUCATION', 
                          length_of_work           = '$LENGTH_OF_WORK', 
                          house_stay_length        = '$HOUSE_STAY_LENGTH', 
                          spouse_phone             = '$SPOUSE_PHONE',
                          spouse_mobile_phone      = '$SPOUSE_MOBILE_PHONE_NO',
                          guarantor_nik            = '$GUARANTOR_ID_NO',
                          guarantor_name           = '$GUARANTOR_NAME',
                          guarantor_mobile_phone   = '$GUARANTOR_MOBILE_PHONE_NO',
                          guarantor_birth_place    = '$GUARANTOR_BIRTH_PLACE',
                          guarantor_birth_date     = '$GUARANTOR_BIRTH_DT',
                          guarantor_address        = '$GUARANTOR_ADDR',
                          guarantor_rt             = '$GUARANTOR_RT',
                          guarantor_rw             = '$GUARANTOR_RW',
                          guarantor_kelurahan      = '$GUARANTOR_KELURAHAN',
                          guarantor_kecamatan      = '$GUARANTOR_KECAMATAN',
                          guarantor_kabupaten      = '$GUARANTOR_CITY',
                          guarantor_provinsi       = '$GUARANTOR_PROVINSI',
                          guarantor_zipcode        = '$GUARANTOR_ZIPCODE',
                          guarantor_relation       = '$GUARANTOR_RELATIONSHIP',
                          created_by               = '$v_agentid', 
                          modif_by                 = '$v_agentid', 
                          modif_time               = now(), 
                          spv_id                   = '$v_agentid',
                          assign_to                = '$agent_to', 
                          total_course             ='0',
                          call_status              ='0',
                          assign_by                = '$v_agentid', 
                          flag_wise                = '$flag_wise',
                          is_eligible_crm          = '$is_eligible_crm',
                          is_process               = '$is_process',                          
                          assign_time              = now(),
                          is_pre_approval          = '$IS_PRE_APPROVAL'
                          ".$backflag."
                          ";
                          // insert_time              = now(), 
              }
        }
        if(mysqli_query($condb,$sqlsa)){
          if ($campaign_id != 1) {
            $sqlupd = "UPDATE cc_ts_penawaran_job SET is_assign = 1 WHERE id=$lengtideb[$i]";
            mysqli_query($condb, $sqlupd);

            // delete from temp
            // if($param_agrmen != "" || $param_task != ""){
            //   $param_agrmen != "" ? $param_agrmen  = " AND ".$param_agrmen:0;
            //   $param_task   != "" ? $param_task    = " AND ".$param_task  :0;
            //   $sqldel = "DELETE FROM cc_ts_penawaran_temp WHERE 1=1 ".$param_task." ".$param_agrmen." ";
            //   mysqli_query($condb, $sqldel);
            // }

            if($CUST_NO != "" || $CUST_ID != ""){
              $sqldel = "DELETE FROM cc_ts_penawaran_temp WHERE (customer_id_ro='$CUST_NO' OR customer_id = '$CUST_ID') ";
              mysqli_query($condb, $sqldel);
            }
            
            $pattern = "/wise/i";
            $is_wise = preg_match_all($pattern, $SOURCE_DATA);

            if ($is_wise > 0) {
              $sqljobcust = "SELECT * FROM cc_ts_penawaran_job
                          WHERE CUST_NO='$CUST_NO' AND is_assign = 0 AND is_process = 1";//task_id='$taskId'
              $resjobcust = mysqli_query($condb,$sqljobcust);
              while($recjobcust = mysqli_fetch_array($resjobcust)){
                @extract($recjobcust,EXTR_OVERWRITE);

                  if ($AGRMNT_NO!='') {
                      $param_agrmen = " agrmnt_no = '$AGRMNT_NO', ";
                      $sqlbfl = "SELECT COUNT(id) as total_process FROM cc_ts_penawaran WHERE is_process=1 AND agrmnt_no='".$AGRMNT_NO."'";
                  }else{
                      $param_agrmen = "";
                  }

                  $param_task = "";
                  if ($TASK_ID!='') {
                      $param_task = " task_id = '$TASK_ID', ";
                      $sqlbfl = "SELECT COUNT(id) as total_process FROM cc_ts_penawaran WHERE is_process=1 AND task_id='".$TASK_ID."'";
                  }

                  $tot_process = 0;
                  // check is process for backflag
                  $recbfl = mysqli_query($condb, $sqlbfl);
                  if($row = mysqli_fetch_array($recbfl)){
                    $tot_process = $row["total_process"];
                  }
                  mysqli_free_result($recbfl);

                  // set backflag
                  // $backflag = "";
                  // if($tot_process>0){
                  //   $backflag = ",back_flag = 1";
                  // }else{
                  //   $backflag = ",back_flag = 0";
                  // }

                  $backflag = ",back_flag = 0";
                  if($tot_process>0){
                    if ($flag_void == "0") {
                      $backflag = ",back_flag = 1";
                    }else{
                        $sqlvoid = "UPDATE cc_ts_penawaran_job SET flag_void = 0 WHERE id=$id";
                        mysqli_query($condb, $sqlvoid);
                      }
                  }
                  $sqlcust = "INSERT INTO cc_ts_penawaran 
                            SET AGRMNT_ID            = '$AGRMNT_ID', 
                            campaign_id              = '$campaign_id', 
                            $param_agrmen
                            $param_task
                            pipeline                 = '$PIPELINE_ID', 
                            distributed_date         = '$DISTRIBUTED_DT', 
                            final_result_cae         = '$CAE_FINAL_RESULT', 
                            dukcapil_result          = '$DUKCAPIL_RESULT', 
                            source_data              = '$SOURCE_DATA', 
                            kilat_pintar             = '$KILAT_PINTAR', 
                            region_code              = '$OFFICE_REGION_CODE', 
                            region_name              = '$OFFICE_REGION_NAME', 
                            cabang_code              = '$OFFICE_CODE', 
                            cabang_name              = '$OFFICE_NAME', 
                            cabang_coll              = '$CAB_COLL', 
                            cabang_coll_name         = '$CAB_COLL_NAME', 
                            kapos_name               = '$KAPOS_NAME', 
                            product_offering_code    = '$PROD_OFFERING_CODE', 
                            lob                      = '$LOB_CODE', 
                            customer_id_ro           = '$CUST_NO', 
                            customer_name            = '$CUST_NAME', 
                            nik_ktp                  = '$ID_NO', 
                            gender                   = '$GENDER', 
                            religion                 = '$RELIGION', 
                            tempat_lahir             = '$BIRTH_PLACE', 
                            tanggal_lahir            = '$BIRTH_DT', 
                            spouse_nik               = '$SPOUSE_ID_NO', 
                            spouse_name              = '$SPOUSE_NAME', 
                            spouse_birth_date        = '$SPOUSE_BIRTH_DT', 
                            spouse_birth_place       = '$SPOUSE_BIRTH_PLACE', 
                            legal_alamat             = '$ADDR_LEG', 
                            legal_rt                 = '$RT_LEG', 
                            legal_rw                 = '$RW_LEG', 
                            legal_provinsi           = '$PROVINSI_LEG', 
                            legal_city               = '$CITY_LEG', 
                            legal_kabupaten          = '$KABUPATEN_LEG', 
                            legal_kecamatan          = '$KECAMATAN_LEG', 
                            legal_kelurahan          = '$KELURAHAN_LEG', 
                            legal_kodepos            = '$ZIPCODE_LEG', 
                            legal_sub_kodepos        = '$SUB_ZIPCODE_LEG', 
                            survey_alamat            = '".mysqli_real_escape_string($condb,$ADDR_RES)."', 
                            survey_rt                = '$RT_RES', 
                            survey_rw                = '$RW_RES', 
                            survey_provinsi          = '$PROVINSI_RES', 
                            survey_city              = '$CITY_RES', 
                            survey_kabupaten         = '$KABUPATEN_RES', 
                            survey_kecamatan         = '$KECAMATAN_RES', 
                            survey_kelurahan         = '$KELURAHAN_RES', 
                            survey_kodepos           = '$ZIPCODE_RES', 
                            survey_sub_kodepos       = '$SUB_ZIPCODE_RES', 
                            mobile_1                 = '$MOBILE1', 
                            mobile_2                 = '$MOBILE2', 
                            phone_1                  = '$PHONE1', 
                            phone_2                  = '$PHONE2', 
                            office_phone_1           = '$OFFICE_PHONE1', 
                            office_phone_2           = '$OFFICE_PHONE2', 
                            profession_code          = '$PROFESSION_CODE', 
                            profession_name          = '$PROFESSION_NAME', 
                            profession_category_code = '$PROFESSION_CATEGORY_CODE', 
                            profession_cat_name      = '$PROFESSION_CATEGORY_NAME', 
                            job_position             = '$JOB_POSITION', 
                            industry_type_name       = '$INDUSTRY_TYPE_NAME', 
                            other_biz_name           = '$OTHER_BIZ_NAME', 
                            monthly_income           = '$MONTHLY_INCOME', 
                            monthly_expense          = '$MONTHLY_EXPENSE', 
                            monthly_instalment       = '$MONTHLY_INSTALLMENT', 
                            dp                       = '$DOWNPAYMENT', 
                            dp_pct                   = '$PERCENT_DP', 
                            plafond                  = '$PLAFOND', 
                            customer_rating          = '$CUST_RATING', 
                            suppl_name               = '$SUPPL_NAME', 
                            suppl_code               = '$SUPPL_CODE', 
                            no_mesin                 = '$MACHINE_NO', 
                            no_rangka                = '$CHASSIS_NO', 
                            product_category         = '$PRODUCT_CATEGORY', 
                            asset_category           = '$ASSET_CATEGORY_CODE', 
                            asset_type               = '$ASSET_TYPE', 
                            asset_age                = '$ASSET_AGE', 
                            brand                    = '$ITEM_BRAND', 
                            item_type                = '$ITEM_TYPE', 
                            item_desc                = '$ITEM_DESCRIPTION', 
                            otr_price                = '$OTR_PRICE', 
                            item_year                = '$ITEM_YEAR', 
                            ownership                = '$OWNER_RELATIONSHIP', 
                            kepemilikan_bpkb         = '$BPKB_OWNERSHIP', 
                            agrmnt_rating            = '$AGRMNT_RATING', 
                            status_kontrak           = '$CONTRACT_STAT', 
                            sisa_tenor               = '$OS_TENOR', 
                            tenor                    = '$TENOR', 
                            release_date_bpkb        = '$RELEASE_DATE_BPKB', 
                            maturity_date            = '$MATURITY_DT', 
                            go_live_dt               = '$GO_LIVE_DT', 
                            rrd_date                 = '$AAM_RRD_DT', 
                            os_principal             = '$OS_PRINCIPAL', 
                            os_installment_amt       = '$OS_INTEREST_AMT', 
                            aging_pembiayaan         = '$AGING_PEMBIAYAAN', 
                            jumlah_kontrak_per_cust  = '$JUMLAH_KONTRAK_PERCUST', 
                            estimasi_terima_bersih   = '$ESTIMASI_TERIMA_BERSIH', 
                            started_date             = '$STARTED_DT', 
                            pos_dealer               = '$POS_DEALER', 
                            sales_dealer_id          = '$SALES_DEALER_ID', 
                            sales_dealer             = '$SALES_DEALER', 
                            dtm_crt                  = '$DTM_CRT', 
                            usr_crt                  = '$USR_CRT', 
                            dtm_upd                  = '$DTM_UPD', 
                            usr_upd                  = '$USR_UPD', 
                            customer_id              = '$CUST_ID', 
                            kepemilikan_rumah        = '$HOME_STAT', 
                            nama_ibu_kandung         = '$MOTHER_NAME', 
                            is_repo                  = '$IS_REPO', 
                            is_write_off             = '$IS_WRITE_OFF', 
                            is_restructure           = '$IS_RESTRUKTUR', 
                            is_insurance             = '$IS_INSURANCE', 
                            is_negative              = '$IS_NEGATIVE_CUST', 
                            exposure                 = '$CUST_EXPOSURE', 
                            ltv                      = '$LTV', 
                            dsr                      = '$DSR', 
                            marital_status           = '$MARITAL_STAT', 
                            education                = '$EDUCATION', 
                            length_of_work           = '$LENGTH_OF_WORK', 
                            house_stay_length        = '$HOUSE_STAY_LENGTH', 
                            spouse_phone             = '$SPOUSE_PHONE',
                            spouse_mobile_phone      = '$SPOUSE_MOBILE_PHONE_NO',
                            guarantor_nik            = '$GUARANTOR_ID_NO',
                            guarantor_name           = '$GUARANTOR_NAME',
                            guarantor_mobile_phone   = '$GUARANTOR_MOBILE_PHONE_NO',
                            guarantor_birth_place    = '$GUARANTOR_BIRTH_PLACE',
                            guarantor_birth_date     = '$GUARANTOR_BIRTH_DT',
                            guarantor_address        = '$GUARANTOR_ADDR',
                            guarantor_rt             = '$GUARANTOR_RT',
                            guarantor_rw             = '$GUARANTOR_RW',
                            guarantor_kelurahan      = '$GUARANTOR_KELURAHAN',
                            guarantor_kecamatan      = '$GUARANTOR_KECAMATAN',
                            guarantor_kabupaten      = '$GUARANTOR_CITY',
                            guarantor_provinsi       = '$GUARANTOR_PROVINSI',
                            guarantor_zipcode        = '$GUARANTOR_ZIPCODE',
                            guarantor_relation       = '$GUARANTOR_RELATIONSHIP',
                            created_by               = '$v_agentid', 
                            modif_by                 = '$v_agentid', 
                            insert_time              = now(), 
                            modif_time               = now(), 
                            spv_id                   = '$v_agentid',
                            assign_to                = '$agent_to', 
                            total_course             ='0',
                            call_status              ='0',
                            assign_by                = '$v_agentid',
                            flag_wise                = '$flag_wise',
                            is_eligible_crm          = '$is_eligible_crm',
                            is_process               = '$is_process',                          
                            assign_time              = now(),
                            is_pre_approval          = '$IS_PRE_APPROVAL'
                            ".$backflag."
                            ON DUPLICATE KEY UPDATE
                            AGRMNT_ID                = '$AGRMNT_ID', 
                            campaign_id              = '$campaign_id', 
                            $param_agrmen
                            $param_task
                            pipeline                 = '$PIPELINE_ID', 
                            distributed_date         = '$DISTRIBUTED_DT', 
                            final_result_cae         = '$CAE_FINAL_RESULT', 
                            dukcapil_result          = '$DUKCAPIL_RESULT', 
                            source_data              = '$SOURCE_DATA', 
                            kilat_pintar             = '$KILAT_PINTAR', 
                            region_code              = '$OFFICE_REGION_CODE', 
                            region_name              = '$OFFICE_REGION_NAME', 
                            cabang_code              = '$OFFICE_CODE', 
                            cabang_name              = '$OFFICE_NAME', 
                            cabang_coll              = '$CAB_COLL', 
                            cabang_coll_name         = '$CAB_COLL_NAME', 
                            kapos_name               = '$KAPOS_NAME', 
                            product_offering_code    = '$PROD_OFFERING_CODE', 
                            lob                      = '$LOB_CODE', 
                            customer_id_ro           = '$CUST_NO', 
                            customer_name            = '$CUST_NAME', 
                            nik_ktp                  = '$ID_NO', 
                            gender                   = '$GENDER', 
                            religion                 = '$RELIGION', 
                            tempat_lahir             = '$BIRTH_PLACE', 
                            tanggal_lahir            = '$BIRTH_DT', 
                            spouse_nik               = '$SPOUSE_ID_NO', 
                            spouse_name              = '$SPOUSE_NAME', 
                            spouse_birth_date        = '$SPOUSE_BIRTH_DT', 
                            spouse_birth_place       = '$SPOUSE_BIRTH_PLACE', 
                            legal_alamat             = '$ADDR_LEG', 
                            legal_rt                 = '$RT_LEG', 
                            legal_rw                 = '$RW_LEG', 
                            legal_provinsi           = '$PROVINSI_LEG', 
                            legal_city               = '$CITY_LEG', 
                            legal_kabupaten          = '$KABUPATEN_LEG', 
                            legal_kecamatan          = '$KECAMATAN_LEG', 
                            legal_kelurahan          = '$KELURAHAN_LEG', 
                            legal_kodepos            = '$ZIPCODE_LEG', 
                            legal_sub_kodepos        = '$SUB_ZIPCODE_LEG', 
                            survey_alamat            = '".mysqli_real_escape_string($condb,$ADDR_RES)."', 
                            survey_rt                = '$RT_RES', 
                            survey_rw                = '$RW_RES', 
                            survey_provinsi          = '$PROVINSI_RES', 
                            survey_city              = '$CITY_RES', 
                            survey_kabupaten         = '$KABUPATEN_RES', 
                            survey_kecamatan         = '$KECAMATAN_RES', 
                            survey_kelurahan         = '$KELURAHAN_RES', 
                            survey_kodepos           = '$ZIPCODE_RES', 
                            survey_sub_kodepos       = '$SUB_ZIPCODE_RES', 
                            mobile_1                 = '$MOBILE1', 
                            mobile_2                 = '$MOBILE2', 
                            phone_1                  = '$PHONE1', 
                            phone_2                  = '$PHONE2', 
                            office_phone_1           = '$OFFICE_PHONE1', 
                            office_phone_2           = '$OFFICE_PHONE2', 
                            profession_code          = '$PROFESSION_CODE', 
                            profession_name          = '$PROFESSION_NAME', 
                            profession_category_code = '$PROFESSION_CATEGORY_CODE', 
                            profession_cat_name      = '$PROFESSION_CATEGORY_NAME', 
                            job_position             = '$JOB_POSITION', 
                            industry_type_name       = '$INDUSTRY_TYPE_NAME', 
                            other_biz_name           = '$OTHER_BIZ_NAME', 
                            monthly_income           = '$MONTHLY_INCOME', 
                            monthly_expense          = '$MONTHLY_EXPENSE', 
                            monthly_instalment       = '$MONTHLY_INSTALLMENT', 
                            dp                       = '$DOWNPAYMENT', 
                            dp_pct                   = '$PERCENT_DP', 
                            plafond                  = '$PLAFOND', 
                            customer_rating          = '$CUST_RATING', 
                            suppl_name               = '$SUPPL_NAME', 
                            suppl_code               = '$SUPPL_CODE', 
                            no_mesin                 = '$MACHINE_NO', 
                            no_rangka                = '$CHASSIS_NO', 
                            product_category         = '$PRODUCT_CATEGORY', 
                            asset_category           = '$ASSET_CATEGORY_CODE', 
                            asset_type               = '$ASSET_TYPE', 
                            asset_age                = '$ASSET_AGE', 
                            brand                    = '$ITEM_BRAND', 
                            item_type                = '$ITEM_TYPE', 
                            item_desc                = '$ITEM_DESCRIPTION', 
                            otr_price                = '$OTR_PRICE', 
                            item_year                = '$ITEM_YEAR', 
                            ownership                = '$OWNER_RELATIONSHIP', 
                            kepemilikan_bpkb         = '$BPKB_OWNERSHIP', 
                            agrmnt_rating            = '$AGRMNT_RATING', 
                            status_kontrak           = '$CONTRACT_STAT', 
                            sisa_tenor               = '$OS_TENOR', 
                            tenor                    = '$TENOR', 
                            release_date_bpkb        = '$RELEASE_DATE_BPKB', 
                            maturity_date            = '$MATURITY_DT', 
                            go_live_dt               = '$GO_LIVE_DT', 
                            rrd_date                 = '$AAM_RRD_DT', 
                            os_principal             = '$OS_PRINCIPAL', 
                            os_installment_amt       = '$OS_INTEREST_AMT', 
                            aging_pembiayaan         = '$AGING_PEMBIAYAAN', 
                            jumlah_kontrak_per_cust  = '$JUMLAH_KONTRAK_PERCUST', 
                            estimasi_terima_bersih   = '$ESTIMASI_TERIMA_BERSIH', 
                            started_date             = '$STARTED_DT', 
                            pos_dealer               = '$POS_DEALER', 
                            sales_dealer_id          = '$SALES_DEALER_ID', 
                            sales_dealer             = '$SALES_DEALER', 
                            dtm_crt                  = '$DTM_CRT', 
                            usr_crt                  = '$USR_CRT', 
                            dtm_upd                  = '$DTM_UPD', 
                            usr_upd                  = '$USR_UPD', 
                            customer_id              = '$CUST_ID', 
                            kepemilikan_rumah        = '$HOME_STAT', 
                            nama_ibu_kandung         = '$MOTHER_NAME', 
                            is_repo                  = '$IS_REPO', 
                            is_write_off             = '$IS_WRITE_OFF', 
                            is_restructure           = '$IS_RESTRUKTUR', 
                            is_insurance             = '$IS_INSURANCE', 
                            is_negative              = '$IS_NEGATIVE_CUST', 
                            exposure                 = '$CUST_EXPOSURE', 
                            ltv                      = '$LTV', 
                            dsr                      = '$DSR', 
                            marital_status           = '$MARITAL_STAT', 
                            education                = '$EDUCATION', 
                            length_of_work           = '$LENGTH_OF_WORK', 
                            house_stay_length        = '$HOUSE_STAY_LENGTH', 
                            spouse_phone             = '$SPOUSE_PHONE',
                            spouse_mobile_phone      = '$SPOUSE_MOBILE_PHONE_NO',
                            guarantor_nik            = '$GUARANTOR_ID_NO',
                            guarantor_name           = '$GUARANTOR_NAME',
                            guarantor_mobile_phone   = '$GUARANTOR_MOBILE_PHONE_NO',
                            guarantor_birth_place    = '$GUARANTOR_BIRTH_PLACE',
                            guarantor_birth_date     = '$GUARANTOR_BIRTH_DT',
                            guarantor_address        = '$GUARANTOR_ADDR',
                            guarantor_rt             = '$GUARANTOR_RT',
                            guarantor_rw             = '$GUARANTOR_RW',
                            guarantor_kelurahan      = '$GUARANTOR_KELURAHAN',
                            guarantor_kecamatan      = '$GUARANTOR_KECAMATAN',
                            guarantor_kabupaten      = '$GUARANTOR_CITY',
                            guarantor_provinsi       = '$GUARANTOR_PROVINSI',
                            guarantor_zipcode        = '$GUARANTOR_ZIPCODE',
                            guarantor_relation       = '$GUARANTOR_RELATIONSHIP',
                            created_by               = '$v_agentid', 
                            modif_by                 = '$v_agentid', 
                            modif_time               = now(), 
                            spv_id                   = '$v_agentid',
                            assign_to                = '$agent_to', 
                            total_course             ='0',
                            call_status              ='0',
                            assign_by                = '$v_agentid', 
                            flag_wise                = '$flag_wise',
                            is_eligible_crm          = '$is_eligible_crm',
                            is_process               = '$is_process',
                            assign_time              = now(),
                            is_pre_approval          = '$IS_PRE_APPROVAL'
                            ".$backflag."                          
                            ";
                            // insert_time              = now(), 
                            mysqli_query($condb, $sqlcust);
                            
                          $sqlupd = "UPDATE cc_ts_penawaran_job SET is_assign = 1 WHERE id=$id";
                          mysqli_query($condb, $sqlupd);

                          // delete from temp
                          // if($param_agrmen != "" || $param_task != ""){
                          //   $param_agrmen != "" ? $param_agrmen  = " AND ".$param_agrmen:0;
                          //   $param_task   != "" ? $param_task    = " AND ".$param_task  :0;
                          //   $sqldel = "DELETE FROM cc_ts_penawaran_temp WHERE 1=1 ".$param_task." ".$param_agrmen." ";
                          //   mysqli_query($condb, $sqldel);
                          // }
              } // end of while
            } // end of is wise condition

          }else{
            $sqlsel = "SELECT customer_id, customer_id_ro FROM cc_ts_penawaran WHERE id ='$id'";
            $ressel = mysqli_query($condb, $sqlsel);
            if($rowsel = mysqli_fetch_array($ressel)){
              $custid     = $rowsel["customer_id"];
              $custid_ro  = $rowsel["customer_id_ro"];
              if($custid != "" || $custid_ro != ""){
                $sqldel = "DELETE FROM cc_ts_penawaran_temp WHERE  id ='$id'";
                mysqli_query($condb, $sqldel);
              }
            }
          }
          
          // $sqllog = "INSERT INTO cc_ts_consumer_detail_log (id_cust_detail,  polo_order_in_id,  distributed_date,  source_data,  region_code,  region_name,  cabang_code,  cabang_name,  cabang_coll,  cabang_coll_name,  kapos_name,  agrmnt_no,  order_no,  product,  product_cat,  product_offering_code,  order_no_ro,  customer_id,  customer_name,  nik_ktp,  religion,  tempat_lahir,  tanggal_lahir,  nama_pasangan,  tanggal_lahir_pasangan,  child_name,  child_birthdate,  legal_alamat,  legal_rt,  legal_rw,  legal_provinsi,  legal_kabupaten,  legal_city,  legal_kecamatan,  legal_kelurahan,  legal_kodepos,  legal_sub_kodepos,  survey_alamat,  survey_rt,  survey_rw,  survey_provinsi,  survey_kabupaten,  survey_city,  survey_kecamatan,  survey_kelurahan,  survey_kodepos,  survey_sub_kodepos,  city_id,  gender,  mobile_1,  mobile_2,  phone_1,  phone_2,  office_phone_1,  office_phone_2,  profession_name,  profession_cat_name,  job_position,  industry_type_name,  monthly_income,  monthly_instalment,  plafond,  cust_rating,  suppl_name,  suppl_code,  pekerjaan,  jenis_pekerjaan,  detail_pekerjaan,  oth_biz_name,  hobby,  kepemilikan_rumah,  customer_id_ro,  customer_rating,  nama_dealer,  kode_dealer,  no_mesin,  no_rangka,  asset_type,  asset_category,  asset_desc,  asset_price_amount,  item_id,  item_type,  item_desc,  item_year,  otr_price,  kepemilikan_bpkb,  agrmnt_rating,  status_kontrak,  angsuran_ke,  sisa_tenor,  tenor,  release_date_bpkb,  max_past_due_date,  tanggal_jatuh_tempo,  maturity_date,  os_principal,  product_category,  sisa_piutang,  kilat_pintar,  aging_pembiayaan,  jumlah_kontrak_per_cust,  estimasi_terima_bersih,  cycling,  task_id,  jenis_task,  soa,  down_payment,  ltv,  call_stat,  answer_call,  prospect_stat,  reason_not_prospect,  confirmation,  notes,  sla_remaining,  started_date,  emp_position,  application_id,  application_ia,  dukcapil_stat,  field_person_name,  negative_cust,  notes_new_lead,  visit_dt,  input_dt,  sub_sitrict_kat_code,  contact_no,  source_data_mss,  referantor_code,  referantor_name,  supervisor_name,  note_telesales,  submited_dt,  mss_stat,  wise_stat,  visit_stat,  survey_stat,  flag_void_sla,  eligible_flag,  eligible_flag_dt,  dtm_crt,  usr_crt,  rtm_upd,  usr_upd,  app_no,  application_stat,  bpkb_out,  brand,  city_leg,  city_res,  cust_photo,  dp_pct,  f_card_photo,  ia_app,  id_photo,  jenis_pembiayaan,  monthly_expense,  npwp_no,  order_id,  other_biz_name,  ownership,  pos_dealer,  promotion_activity,  referantor_code_1,  referantor_code_2,  referantor_name_1,  referantor_name_2,  sales_dealer,  send_flag_wise,  spouse_id_photo,  send_flag_mss,  flag_pre_ia,  task_id_mss,  profession_code,  sales_dealer_id,  profession_category_code,  flag_void_sla_tele,  status_task_mss,  priority_level,  outstand_principal,  outstand_monthly_instalment,  rrd_date,  group_id,  sumber_order,  special_cash_flag,  created_by,  modif_by,  insert_time,  modif_time,  campaign_id,  external_code,  priority,  branch_name,  phone,  product_type,  vehicle_year,  plafond_price,  installment_price,  referentor,  desc_note,  desc_note_adv,  assign_by,  assign_to,  assign_time,  reassign,  reassign_by,  reassign_time,  first_call_time,  first_followup_by,  last_call_time,  last_followup_by,  call_status,  call_status_sub1,  call_status_sub2,  total_dial,  total_phone,  total_course,  status,  status_bypass,  status_approve,  close_time,  close_by,  close_approve_time,  close_approve_by,  qa_approve_status,  qa_approve_note,  qa_approve_time,  qa_approve_by)
          //                     SELECT * FROM cc_ts_consumer_detail
          //                     WHERE id='$lengtideb[$i]'";
          // mysqli_query($condb,$sqllog);

          $success++; 
        }else{
          $failed++; 
        }
        $total++;
      }
      if ($success > 0) {
        $detail_assign = "$agent_to : $total ";
        $sqlins = "INSERT INTO cc_agent_trail_log SET agent_id = '".$v_agentid."', trail_desc='Success, ".$success.", ".$total.",|$detail_assign|, where : ".mysqli_real_escape_string($condb, $where)."', insert_time=now()";
        mysqli_query($condb, $sqlins);
        echo 'Success!|'.$success.'|'.$total;
      }
      break;
    default:
      echo "Method Not Found";
      break;
  }
}

function validate_number_priority_campaign(){
  $condb = connectDB();
  $number = get_param('number');
  $messages = 'fail';

  $sql = "SELECT COUNT(*) AS tot_prio FROM cc_campaign WHERE campaign_priority=$number";
  $res = mysqli_query($condb, $sql);
  if($row = mysqli_fetch_array($res)){
    $tot_prio = $row['tot_prio'];
    if ($tot_prio != 0) {
      $messages = 'protect';
    }else{
      $messages = 'safe';
    }
  }
  mysqli_free_result($res);

  echo json_encode($messages);
}

function validate_number_priority_campaign2(){
  $condb = connectDB();
  $number = get_param('number');
  $messages = 'fail';

  $sql = "SELECT COUNT(*) AS tot_prio FROM cc_ts_penawaran_campaign WHERE campaign_priority=$number";
  $res = mysqli_query($condb, $sql);
  if($row = mysqli_fetch_array($res)){
    $tot_prio = $row['tot_prio'];
    if ($tot_prio != 0) {
      $messages = 'protect';
    }else{
      $messages = 'safe';
    }
  }
  mysqli_free_result($res);

  echo json_encode($messages);
}

// by group
function get_select_campaign_by_group($conDB, $id, $name, $required, $campaign_id){
  $v_agentid = get_session('v_agentid');
  $sel = "<SELECT id=\"$id\" name=\"$name\" class=\"select2 form-control\" style=\"width:100%;\" \"$required\">";
  $sel .= "<option value='' selected disabled>--Select Campaign--</option>"; 
  $sel .= "<option value='1'>Campaign Auto</option>"; 
  $sql_str1 = "SELECT DISTINCT(a.campaign_id) as id, b.campaign_code, b.campaign_name 
              FROM cc_ts_penawaran_job a LEFT JOIN cc_ts_penawaran_campaign b ON a.campaign_id=b.id
              WHERE b.status!=0 AND (b.spv_id REGEXP '[[:<:]]".$v_agentid."[[:>:]]' OR a.campaign_id=1)";//a.assign_to=69 OR  (a.assign_to='$v_agentid' OR a.assign_to=0) AND 
              // WHERE b.status!=0 AND (b.spv_id='$v_agentid' OR a.campaign_id=1)";//a.assign_to=69 OR  (a.assign_to='$v_agentid' OR a.assign_to=0) AND 
  $sql_res1  = execSQL($conDB, $sql_str1);
  while ($sql_rec1 = mysqli_fetch_array($sql_res1)) {
    if($sql_rec1['id'] == $campaign_id) {
      $sel .= "<option value=\"".$sql_rec1['id']."\" selected>".$sql_rec1['campaign_name']."</option>";  
    } else {
      $sel .= "<option value=\"".$sql_rec1['id']."\" >".$sql_rec1['campaign_name']."</option>";  

    }
  }
  $sel .= "</SELECT>";

  return $sel;
}

// by campaign
function get_select_regional(){
  $condb = connectDB();
  $campaign_id  = get_param('campaign_id');
  // $region       = get_param('regional');
  $where = '';
  $campaign_id  != '' ? $where .= ' AND a.campaign_id='.$campaign_id : 0;
  $campaign_id == '1' ? $where .= ' AND a.assign_to=0':0;
  // ($region       != '' && $region != '0') ? $where .= ' AND b.region_code IN ('.$region.')' : 0;


  $sel = array();
  $sel[] = "<option value='' disabled>--- Select Regional ---</option>";
  $sel[] = "<option value='0' >All</option>";
  // $sql = "SELECT DISTINCT(a.region_code) as code, b.region_name as name FROM cc_ts_consumer_detail a LEFT JOIN  cc_master_region b ON a.region_code=b.region_code
  if ($campaign_id == 1) {
    $sql = "SELECT DISTINCT(a.region_code) as code, b.region_name as name FROM cc_ts_penawaran a LEFT JOIN  cc_master_region b ON a.region_code=b.region_code
            WHERE b.is_active=1 $where";
  }else{
    $sql = "SELECT DISTINCT(a.OFFICE_REGION_CODE) as code, b.region_name as name FROM cc_ts_penawaran_job a LEFT JOIN  cc_master_region b ON a.OFFICE_REGION_CODE=b.region_code
            WHERE b.is_active=1 $where";
  }
  $res = mysqli_query($condb, $sql);
  while($row = mysqli_fetch_array($res)){
    $code = $row['code'];
    $name = $row['name'];
    // if ($code == $region) {
      $sel[] = "<option value='$code' selected>$name</option>";
    // }else if($code != '0'){
      // $sel[] = "<option value='$code'>$name</option>";
    // }
  }

  $sel[] = "</SELECT>";

  $data['arrSel'] = $sel;
  $data['sql'] = $sql;

  echo json_encode($data);

}

// by campaign
function get_select_asset_type(){
  $condb = connectDB();
  $campaign_id  = get_param('campaign_id');
  $type       = get_param('type');
  $where = '';
  $campaign_id  != '' ? $where .= ' AND a.campaign_id='.$campaign_id : 0;
  $campaign_id == '1' ? $where .= ' AND a.assign_to=0':0;
  ($type       != '' || $type != '0') ? $where .= " AND b.asset_type_code IN ($type)" : 0;


  $sel = array();
  $sel[] = "<option value='' disabled>--- Select Asset Type ---</option>";
  $sel[] = "<option value='0' >All</option>";
  // $sql = "SELECT DISTINCT(a.asset_type) AS code, b.asset_type_name as name FROM cc_ts_consumer_detail a LEFT JOIN  cc_master_type_asset b ON a.asset_type=b.asset_type_code
  $sql = "SELECT DISTINCT(a.asset_type) AS code, b.asset_type_name as name FROM cc_ts_penawaran a LEFT JOIN  cc_master_type_asset b ON a.asset_type=b.asset_type_code
          WHERE 1=1 $where";
  $res = mysqli_query($condb, $sql);
  while($row = mysqli_fetch_array($res)){
    $code = $row['code'];
    $name = $row['name'];
    // if ($code == $type) {
      $sel[] = "<option value='$code' selected>$name</option>";
    // }else if($code != '0'){
      // $sel[] = "<option value='$code'>$name</option>";
    // }
  }

  $sel[] = "</SELECT>";

  $data['arrSel'] = $sel;
  $data['sql'] = $sql;

  echo json_encode($data);
}

// by campaign
function get_select_kategori_kendaraan(){
  $condb = connectDB();
  $campaign_id  = get_param('campaign_id');
  $type       = get_param('type');
  $where = '';
  // $campaign_id  != '' ? $where .= ' AND a.campaign_id='.$campaign_id : 0;
  // $type       != '' ? $where .= " AND b.asset_type_code='$type'" : 0;


  $campaign_id == '1' ? $where .= ' AND a.assign_to=0':0;

  $sel = array();
  $sel[] = "<option value='' disabled>--- Select Asset Type ---</option>";
  $sel[] = "<option value='0' selected>All</option>";
  $sql = "SELECT a.id AS code, b.asset_category_name as name FROM cc_ts_consumer_detail a LEFT JOIN  cc_master_type_asset b ON a.asset_type=b.asset_type_code
          WHERE b.is_active=1 AND a.assign_to=0 $where";
  $res = mysqli_query($condb, $sql);
  // while($row = mysqli_fetch_array($res)){
  //   $code = $row['code'];
  //   $name = $row['name'];
  //   if ($code == $type) {
  //     $sel[] = "<option value='$code' selected>$name</option>";
  //   }else{
  //     $sel[] = "<option value='$code'>$name</option>";
  //   }
  // }

  $sel[] = "</SELECT>";

  $data['arrSel'] = $sel;
  $data['sql'] = $sql;

  echo json_encode($data);
}

// by campaign
function get_select_cabang(){
  $condb = connectDB();
  $campaign_id  = get_param('campaign_id');

  $where = '';
  $campaign_id  != '' ? $where .= ' AND a.campaign_id='.$campaign_id : 0;
  $campaign_id == '1' ? $where .= ' AND a.assign_to=0':0;
  // $type       != '' ? $where .= " AND b.asset_type_code='$type'" : 0;


  $sel = array();
  $sel[] = "<option value='' disabled>--- Select Asset Type ---</option>";
  $sel[] = "<option value='0' >All</option>";
  // $sql = "SELECT DISTINCT(a.cabang_code) AS code, b.office_name as name FROM cc_ts_consumer_detail a LEFT JOIN  cc_master_cabang b ON a.cabang_code=b.office_code
  if ($campaign_id == 1) {
    $sql = "SELECT DISTINCT(a.cabang_code) AS code, b.office_name as name FROM cc_ts_penawaran a LEFT JOIN  cc_master_cabang b ON a.cabang_code=b.office_code WHERE b.is_active=1 $where";
  }else{
    // $sql = "SELECT DISTINCT(a.OFFICE_CODE) AS code, b.office_name as name FROM cc_ts_penawaran_job a LEFT JOIN  cc_master_cabang b ON a.OFFICE_CODE=b.office_code WHERE b.is_active=1 $where";

    // get from penawaran job
    $sqlpj  = "SELECT DISTINCT(a.OFFICE_CODE) AS CODE
              FROM cc_ts_penawaran_job a 
              WHERE 1=1 $where";
    $respj  = mysqli_query($condb, $sqlpj);
    $rowpj  = mysqli_fetch_all($respj, MYSQLI_ASSOC);
    $arr_pj = array_column($rowpj, 'CODE');
    $strpj  = "'" . implode("','", $arr_pj) . "'";

    if ($strpj == "") {
      $strpj=-1;
    }

    $sql = "SELECT DISTINCT(a.office_code) AS code, a.office_name as name 
          FROM cc_master_cabang a WHERE a.is_active=1 AND  a.office_code IN ($strpj)";


  }
  $res = mysqli_query($condb, $sql);
  while($row = mysqli_fetch_array($res)){
    $code = $row['code'];
    $name = $row['name'];
    if ($code == $type) {
      $sel[] = "<option value='$code' selected>$name</option>";
    }else if($code != '0'){
      $sel[] = "<option value='$code'>$name</option>";
    }
  }

  $sel[] = "</SELECT>";

  $data['arrSel'] = $sel;
  $data['sql'] = $sql;
  $data['sqlpj'] = $strpj;

  echo json_encode($data);
}

// by campaign
function get_select_call_status(){
  $condb = connectDB();
  $campaign_id  = get_param('campaign_id');

  $where = '';
  $campaign_id  != '' ? $where .= ' AND a.campaign_id='.$campaign_id : 0;
  $campaign_id == '1' ? $where .= ' AND a.assign_to=0':0;
  // $type       != '' ? $where .= " AND b.asset_type_code='$type'" : 0;


  $sel = array();
  // $sel[] = "<option value=''  disabled>--- Select Asset Type ---</option>";
  // $sel[] = "<option value='0' >All</option>";
  $sel[] = "<option value='99' >New</option>";

  if ($campaign_id != 1) {
    $sql = "SELECT DISTINCT(a.call_status) AS code, b.call_status as name
            FROM cc_ts_penawaran a
            LEFT JOIN cc_ts_call_status b ON a.call_status=b.id
            WHERE a.call_status>0 $where ";
    $res = mysqli_query($condb, $sql);
    $list_code = ""; 
    while($row = mysqli_fetch_array($res)){
      $code = $row['code'];
      $name = $row['name'];
      $list_code .= $code.", ";
      if ($code == "") {
        $sel[] = "<option value='Fresh'>Fresh</option>";
      }elseif($code != "0"){
        $sel[] = "<option value='$code'>$name</option>";
      }
    }
  }

  $sel[] = "</SELECT>";

  $data['arrSel'] = $sel;
  $data['sql'] = $sql.' - '.$list_code;

  echo json_encode($data);
}

function tele_idno($param, $conDB) {
    // $sql = "SELECT SUBSTR(MAX(`task_id`),-7) AS ID  FROM cc_ts_consumer_detail WHERE source_data = 'NEW'";
    $sql = "SELECT SUBSTR(MAX(`task_id`),-7) AS ID  FROM cc_ts_penawaran WHERE source_data = 'NEW'";
        $dataMax = mysqli_fetch_assoc(mysqli_query($conDB,$sql)); // ambil data maximal dari id transaksi
     // $param = $param.rand(10,99);
      $param = $param;
        if($dataMax['ID']=='') { // bila data kosong
            $ID = $param."0000001";
        }else {
            $MaksID = $dataMax['ID'];
            $MaksID++;
            if($MaksID < 10) $ID = $param."000000".$MaksID; // nilai kurang dari 10
            else if($MaksID < 100) $ID = $param."00000".$MaksID; // nilai kurang dari 100
            else if($MaksID < 1000) $ID = $param."0000".$MaksID; // nilai kurang dari 1000
            else if($MaksID < 10000) $ID = $param."000".$MaksID; // nilai kurang dari 10000
            else if($MaksID < 100000) $ID = $param."00".$MaksID; // nilai kurang dari 100000
            else if($MaksID < 1000000) $ID = $param."0".$MaksID; // nilai kurang dari 1000000
            else $ID = $MaksID; // lebih dari 10000
        }

        return $ID;
}

function get_select_master_branch($conDB, $id, $name, $required, $branch_id) {
    
    // if(!empty($region_id)) {
      $isarray = explode(",", $region_id);
      $data[] = "";
      foreach ($isarray as $key => $value) {
          $data[$value] = $value;
      }
    // }

  $sel = "<SELECT id=\"$id\" name=\"$name\" class=\"select2 form-control\" style=\"width:100%;\" multiple=\"multiple\" required>";
  if($data[0] == "0") {
      $sel .= "<option value=\"0\" selected>All</option>";  
  } else {
      $sel .= "<option value=\"0\">All</option>";
  }
  $sql_str1 = " SELECT a.id, a.branch_code, a.branch_name FROM cc_master_branch a ";
  $sql_res1  = execSQL($conDB, $sql_str1);
  while ($sql_rec1 = mysqli_fetch_array($sql_res1)) {
    $sid = $sql_rec1['id'];
    if($sid == $data[$sid]) {
      $sel .= "<option value=\"".$sql_rec1['id']."\" selected>".$sql_rec1['branch_code']." / ".$sql_rec1['branch_name']."</option>";  
    } else {
      $sel .= "<option value=\"".$sql_rec1['id']."\" >".$sql_rec1['branch_code']." / ".$sql_rec1['branch_name']."</option>";
    }
  }
  $sel .= "</SELECT>";

  return $sel;
}

 function get_select_suppl_branch_name_enable($idname, $name, $status) {
    $sel0 = "";
    $sel1 = "";
    
    if ($status == "0")
       $sel0 = "selected";
    else if ($status == "1")   
       $sel1 = "selected";
       
    $selectout = "<SELECT id=\"$idname\" name=\"$name\" class=\"select2 form-control\" style=\"width:100%;\">     
                    <option value=\"0\" $sel0>Disable</option>
                    <option value=\"1\" $sel1>Enable</option>
                  </SELECT>";
                  
    return $selectout;                     
  }

  
function get_select_lastcall(){
  $condb       = connectDB();
  $bucket_id   = get_param('bucket_id');
  $status_call = get_param("status_call");

  $where = '';
  $bucket_id  != '' ? $where .= ' AND a.campaign_id='.$bucket_id : 0;

  $sel = array();
  $sel[] = "<option value='' disabled>--- Select Lastdate Call ---</option>";
  $sel[] = "<option value='0' >All</option>";

  $sql = "SELECT MIN(a.create_time) as mindate, MAX(a.create_time) as maxdate 
          FROM cc_ts_penawaran_history a 
          WHERE 1=1 AND a.call_status=$status_call $where";
  $res = mysqli_query($condb, $sql);
  $list_code = ""; 
  while($row = mysqli_fetch_array($res)){
    // $code = $row['code'];
    // $name = $row['code'];
    // $list_code .= $code.", ";
    // if ($code == "") {
    //   // $sel[] = "<option value='Fresh'>Fresh</option>";
    // }elseif($code != "0"){
    //   $sel[] = "<option value='$code'>$name</option>";
    // }

    $data['mindate'] = $row['mindate'];
    $data['maxdate'] = $row['maxdate'];
  }

  $sel[] = "</SELECT>";

  // $data['sql'] = $sql.' - '.$list_code;
  $data['arrSel'] = $sel;
  $data['sql'] = $sql.' - '.$list_code;

  echo json_encode($data);
}
?>