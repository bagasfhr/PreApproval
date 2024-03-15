<?php
include "config_api.php";
include "../../sysconf/global_func.php";
include "../../sysconf/db_config.php";

// $idName              = $_GET['idName']; //UPDATE_FROM_CRM 
$idName              = "UPDATE_FROM_CRM"; //UPDATE_FROM_CRM 
$taskId              = $_GET['taskId']; //POL000000005
$distributedDate     = $_GET['distributedDate']; //2021-04-23 04:10:36
$no_pengajuan        = $_GET['no_pengajuan']; //TUP69020220000002 
$whr_sql = " task_id='$taskId' ";
if ($no_pengajuan !="") {
    $whr_sql = " no_pengajuan='$no_pengajuan' ";
}
$condb = connectDB();
//API URL
// $url = $url_api_fin.'/api/Pengajuan/UpdateFromCRM';//echo "string $url";
$url = $url_api_fin.'/api/Pengajuan/UpdateTaskSLA';//echo "string $url";

$dateexe = DATE("Y-m-d H:i:s");
$datesla = DATE("Y-m-d");

//create a new cURL resource

$arrsubcat = array();
$sqlsubct = " SELECT id, call_status_sub1 FROM cc_ts_call_status_sub1 
WHERE status=1 ORDER BY call_status_sub1 ASC ";
$ressubct   = mysqli_query($condb, $sqlsubct);
while($recsubct = mysqli_fetch_array($ressubct)){
  $arrsubcat[$recsubct["id"]] = $recsubct['call_status_sub1'];
}

$sql12 = " SELECT * FROM cc_ts_penawaran WHERE $whr_sql ";//echo "string $sql12 </br>";
$res12 = mysqli_query($condb, $sql12);
if($rec12 = mysqli_fetch_array($res12)) {
  $customer_id     = $rec12["customer_id"];
  $customer_id_ro     = $rec12["customer_id_ro"];
}
$sqlwhr=" (customer_id='$customer_id' OR customer_id_ro='$customer_id_ro') AND call_status > 0 ";
if ($customer_id=='') {
    $sqlwhr=" $whr_sql ";
}
$sqla = "SELECT * FROM cc_ts_penawaran WHERE $sqlwhr";//echo $sqla; die();//task_id='$taskId'
$resa = mysqli_query($condb,$sqla);
while($reca = mysqli_fetch_array($resa)){
    @extract($reca,EXTR_OVERWRITE);
    if ($no_pengajuan!="") {
        $taskId=$task_id;
    }
    $taskId=$task_id;
    $num_duplicate=0;
    $paramduplicate = strpos($source_data,"WISE");
    if($paramduplicate >=0){
        $sql12 = " SELECT * FROM cc_ts_simulasi a
                   WHERE a.id_cust_detail='$id' AND a.num_duplicate>0
                   AND a.modif_by='$last_followup_by' ";//echo "string $sql12 </br>";
        $res12 = mysqli_query($condb, $sql12);
        if($rec12 = mysqli_fetch_array($res12)) {
          $id_simulasi     = $rec12["id"];
          $num_duplicate   = $rec12["num_duplicate"];

          $sqlupall = "UPDATE cc_ts_simulasi SET    
                          num_duplicate = '0',
                          last_num_duplicate = '$num_duplicate'
                   WHERE id ='$id_simulasi'";
          mysqli_query($condb,$sqlupall);
        }
    }


$sqlupall = "UPDATE cc_ts_simulasi SET    
                sla_date = '$datesla'
         WHERE id_cust_detail ='$id'";
mysqli_query($condb,$sqlupall);


        $sql12 = " SELECT a.agent_name, b.emp_name, c.referantor_id, c.referantor_no, c.referantor_name FROM cc_agent_profile a 
                 LEFT JOIN cc_employee b ON a.agent_id=b.ref_no
                 LEFT JOIN cc_master_referantor c ON b.ref_emp_id=c.ref_emp_id WHERE a.id='$last_followup_by' ";//echo "string $sql12 </br>";
        $res12 = mysqli_query($condb, $sql12);
        if($rec12 = mysqli_fetch_array($res12)) {
          $referantor_id   = $rec12["referantor_id"];
          $referantor_no   = $rec12["referantor_no"];
          $referantor_name = $rec12["referantor_name"];
        }
    //call_status
    $sqlcs = "SELECT b.call_status, a.sub_result FROM cc_ts_penawaran_call_session a LEFT JOIN cc_ts_call_status b  ON a.result=b.id WHERE a.task_id='$taskId' ORDER BY a.id DESC LIMIT 1 ";
    $rescs = mysqli_query($condb,$sqlcs);
    if($reccs = mysqli_fetch_array($rescs)){
        $call_status2         = $reccs['call_status'];
        $call_status_sub12    = $reccs['call_status_sub1'];
        $sub_result           = $reccs['sub_result'];
        if ($call_status2=="Prospect") {
            $prospect_stat2 = "Prospek";
        }else if ($call_status2=="Interest") {
            $prospect_stat2 = $call_status2;
        }else if ($call_status2=="Uncontacted") {
            $prospect_stat2 = $call_status2;
        }else if ($call_status2=="Unconnected") {
            $prospect_stat2 = $call_status2;
        }
        // else if ($call_status2=="Follow Up") {
        //     $prospect_stat2 = "Not Interest";
        // }
        // else if ($call_status2=="UnAnswer") {
        //     $prospect_stat2 = "Uncontacted";
        // }
        else if ($call_status2=="UnConnected") {
            $prospect_stat2 = "Unconnected";
        }else{
            $prospect_stat2 = $call_status2;
        }
    }
    if ($call_status=='5') {
        $prospect_stat2 = "UnAnswer";
    }
    if ($call_status=='6') {
        $prospect_stat2 = "Unconnected";
    }

    $SubStatusCall = $arrsubcat[$sub_result];

    if ($call_status=='4') {
          $sqlcallback = "UPDATE cc_call_back SET    
                          notif_flag = '0'
                   WHERE com_ticket ='$id' AND notif_flag='99'";
          mysqli_query($condb,$sqlcallback);
    }


    $sqlcs = "SELECT a.agent_name FROM cc_agent_profile a WHERE a.id='$last_followup_by' ";
    $rescs = mysqli_query($condb,$sqlcs);
    if($reccs = mysqli_fetch_array($rescs)){
        $agent_name         = $reccs['agent_name'];
    }
    // echo "string $sqlcs | $prospect_stat2 | $call_status2";

    //new
    // $tanggal_lahir= $tanggal_lahir." 00:00:00";
    // $tanggal_lahir_pasangan= $tanggal_lahir_pasangan." 00:00:00";
    // $release_date_bpkb= $release_date_bpkb." 00:00:00";
    // $maturity_date = $maturity_date." 00:00:00";
    // $tanggal_jatuh_tempo = $tanggal_jatuh_tempo." 00:00:00";

    
    $ch = curl_init($url);
    // $max_past_due_date = "19";
    // if ($legalRt=='') {
    //     $legalRt='00';
    // }
    // if ($legalRw=='') {
    //     $legalRw='00';
    // }
    // if ($mobile_1=='') {
    //     $mobile_1='null';
    // }
    // if ($mobile_2=='') {
    //     $mobile_2='null';
    // }
    // if ($phone_1=='') {
    //     $phone_1='null';
    // }
    // if ($phone_2=='') {
    //     $phone_2='null';
    // }
    // if ($office_phone_1=='') {
    //     $office_phone_1='null';
    // }
    // if ($office_phone_2=='') {
    //     $office_phone_2='null';
    // }
    // if ($other_biz_name=='') {
    //     $other_biz_name='null';
    // }
    // if ($soa=='') {
    //     $soa='null';
    // }
    // if ($ltv=='') {
    //     $ltv='null';
    // }
    // if ($down_payment=='') {
    //     $down_payment=null;
    // }
    // if ($down_payment=='0') {
    //     $down_payment=null;
    // }

    // $monthly_income  = str_replace(".00", "", $monthly_income); 
    $monthly_instalment = str_replace(".00", "", $monthly_instalment);
    $plafond        = str_replace(".00", "", $plafond);
    $otr_price    = str_replace(".00", "", $otr_price);
    $emp_position = "TELESALES";
    // if ($tanggal_lahir_pasangan =="0000-00-00 00:00:00" || $tanggal_lahir_pasangan =="") {
    //     // $tanggal_lahir_pasangan = "1970-01-01 00:00:00";
    //     $tanggal_lahir_pasangan = null;
    // }
    // if ($distributed_date =="0000-00-00 00:00:00") {// || $distributed_date ==""
    //     $distributed_date = "1970-01-01 00:00:00";
    // }
    // if ($release_date_bpkb =="0000-00-00 00:00:00") {// || $release_date_bpkb ==""
    //     $release_date_bpkb = "1970-01-01 00:00:00";
    // }
    // if ($maturity_date =="0000-00-00 00:00:00") {// || $maturity_date ==""
    //     $maturity_date = "1970-01-01 00:00:00";
    // }
    // if ($started_date =="0000-00-00 00:00:00") {// || $started_date ==""
    //     $started_date = "1970-01-01 00:00:00";
    // }
    // if ($tanggal_jatuh_tempo =="0000-00-00 00:00:00") {// || $tanggal_jatuh_tempo ==""
    //     $tanggal_jatuh_tempo = "1970-01-01 00:00:00";
    // }
    // if ($os_principal=="") {
    //     $os_principal = "0";
    // }
    // if ($max_past_due_date=="") {
    //     // $max_past_due_date = "0";
    //     $max_past_due_date = null;
    // }
    
//setup request to send json via POST 1970-01-01 00:00:00
    $path = '../../public/konfirm/cust_photo/'.$cust_photo;
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $cust_photo = base64_encode($data);


    $path = '../../public/konfirm/id_photo/'.$id_photo;
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $id_photo = base64_encode($data);


    // if ($distributed_date=='') {
    //     $distributed_date=null;
    // }
    // if ($tanggal_lahir=='') {
    //     $tanggal_lahir=null;
    // }
    // if ($tanggal_lahir_pasangan=='') {
    //     $tanggal_lahir_pasangan=null;
    // }
    // if ($monthly_income=='') {
    //     $monthly_income=null;
    // }
    $monthly_income    = str_replace(".", "", $monthly_income);
    // if ($monthly_income=='8.000.000') {
    //     $monthly_income='8000000';
    // }
    // if ($monthly_expense=='') {
    //     $monthly_expense=null;
    // }
    // if ($plafond=='') {
    //     $plafond=null;
    // }
    // if ($otr_price=='') {
    //     $otr_price=null;
    // }

    // if ($otr_price=='0') {
    //     $otr_price=null;
    // }
    // if ($num_of_dependents=='') {
    //     $num_of_dependents=null;
    // }
    // if ($OsTenor=='') {
    //     $OsTenor=null;
    // }
    // if ($OsTenor=='0') {
    //     $OsTenor=null;
    // }
    // if ($sisa_tenor=='') {
    //     $sisa_tenor=null;
    // }
    // if ($sisa_tenor=='0') {
    //     $sisa_tenor=null;
    // }
    // if ($tenor=='') {
    //     $tenor=null;
    // }
    // if ($tenor=='0') {
    //     $tenor=null;
    // }
    // if ($release_date_bpkb=='') {
    //     $release_date_bpkb=null;
    // }
    // if ($max_past_due_date=='') {
    //     $max_past_due_date=null;
    // }
    // if ($maturity_date=='') {
    //     $maturity_date=null;
    // }
    // if ($down_payment=='') {
    //     $down_payment=null;
    // }
    // if ($started_date=='') {
    //     $started_date=null;
    // }
    // if ($monthly_instalment=='') {
    //     $monthly_instalment=null;
    // }
    // if ($stay_length=='') {
    //     $stay_length=null;
    // }
    // if ($length_of_work=='') {
    //     $length_of_work=null;
    // }
    // if ($duplicate_ke=='') {
    //     $duplicate_ke=null;
    // }
    // if ($due_date=='') {
    //     $due_date=null;
    // }
    // if ($os_installment_amt=='') {
    //     $os_installment_amt=null;
    // }


    // $sqlasset = "SELECT b.engine_no,b.chasis_no,b.assets_desc,b.assets_name,b.instalment 
    //              FROM cc_ts_penawaran_add_assets b
    //              WHERE b.task_id='$taskId' ORDER BY b.id DESC LIMIT 1; ";
    // $resasset = mysqli_query($condb,$sqlasset);
    // if($recasset = mysqli_fetch_array($resasset)){
    //     $engine_no         = $recasset['engine_no'];
    //     $chasis_no         = $recasset['chasis_no'];
    //     $assets_desc       = $recasset['assets_desc'];
    //     $assets_name       = $recasset['assets_name'];
    //     $instalment        = $recasset['instalment'];
    // }


$sqlsa = "SELECT 
            a.id, a.id_penawaran, a.assets_type, a.assets_name, a.assets_type_desc, a.assets_desc,
            a.engine_no, a.license_plate, a.chasis_no, a.manufacturing_year, a.asset_ownership, a.product_offering, 
            a.asset_price, a.platfond_max, a.tenor, a.ltv, a.instalment, a.ltv_persen, a.kategori_asset
          FROM 
            cc_ts_penawaran_add_assets a 
          WHERE 
            a.task_id='$taskId'
          ORDER BY a.update_time DESC LIMIT 1";
$ressa = mysqli_query($condb,$sqlsa);
$no=1;
if($recsa = mysqli_fetch_array($ressa)){
    $assets_desc       = $recsa['assets_desc'];
}

    // // relation
    // $sql_relation = "master_code FROM cc_master_relation WHERE descr='$guarantor_relation'";
    // $res_relation = mysqli_query($condb, $sql_relation);
    // while($row = mysqli_fetch_array($res_relation)){
    //     $guarantor_relation = $row['master_code'];
    // }

    $asset_desc=$assets_desc;
    if ($no_mesin=="") {
        $no_mesin=$engine_no;
    }
    if ($no_rangka=="") {
        $no_rangka=$chasis_no;
    }
    // if ($asset_desc=="") {
    //     $asset_desc=$assets_desc;
    // }
    // if ($monthly_instalment=='0') {
    //     $monthly_instalment=null;
    // }
    // $no_mesin
    // $data = array(
    //         "TaskId" => "$task_id",  
    //         "DistributedDate" => $distributed_date,
    //         "OfficeRegionCode" => "$region_code",
    //         "OfficeRegionName" => "$region_name",
    //         "OfficeCode" => "$cabang_code",
    //         "OfficeName" => "$cabang_name",
    //         "ProdOfferingCode" => "$product_offering_code",
    //         "CustNo" => "$customer_id",
    //         "CustName" => "$customer_name",
    //         "IdNo" => "$nik_ktp",
    //         "Religion" => "$religion",
    //         "BirthPlace" => "$tempat_lahir",
    //         "BirthDate" => $tanggal_lahir,
    //         "SpouseName" => "$nama_pasangan",
    //         "SpouseBirthDate" => $tanggal_lahir_pasangan,
    //         "SpouseIdPhoto" => "$spouse_id_photo",
    //         "LegalAddr" => "$legal_alamat",
    //         "LegalCity" => "$legal_city",
    //         "LegalSubDistrict" => "$legal_kecamatan",
    //         "LegalVillage" => "$legal_kelurahan",
    //         "LegalProvince" => "$legal_provinsi",
    //         "LegalDistrict" => "$legal_kabupaten",
    //         "LegalRt" => "$legal_rt",
    //         "LegalRw" => "$legal_rw",
    //         "LegalZipcode" => "$legal_kodepos",
    //         "LegalSubZipcode" => "$legal_sub_kodepos",
    //         "SurveyAddr" => "$survey_alamat",
    //         "SurveyRt" => "$survey_rt",
    //         "SurveyRw" => "$survey_rw",
    //         "SurveyProvince" => "$survey_provinsi",
    //         "SurveyCity" => "$survey_city",
    //         "SurveySubDistrict" => "$survey_kecamatan",
    //         "SurveyVillage" => "$survey_kelurahan",
    //         "SurveyZipCode" => "$survey_kodepos",
    //         "SurveySubZipcode" => "$survey_sub_kodepos",
    //         "SurveyDistrict" => "$survey_kabupaten",
    //         //"SurveySubDistrict" => "$SurveySubDistrict",
    //         "MobilePhoneNo1" => "$mobile_1",
    //         "MobilePhoneNo2" => "$mobile_2",
    //         "Phone1" => "$phone_1",
    //         "Phone2" => "$phone_2",
    //         "JobPhone1" => "$job_phone_1",
    //         "JobPhone2" => "$job_phone_2",
    //         "ProfessionName" => "$profession_name",
    //         "ProfessionCategoryName" => "$profession_cat_name",
    //         "JobPosition" => "$job_position",
    //         "IndustryTypeName" => "$industry_type_name",
    //         "MonthlyIncome" => $monthly_income,
    //         "MonthlyExpense" => $monthly_expense,
    //         "Plafon" => $plafond,
    //         "OtherBizName" => "$oth_biz_name",
    //         "CustRating" => "$customer_rating",
    //         "SupplBranchName" => "$suppl_name",
    //         "SupplBranchCode" => "$suppl_code",
    //         "MachineNo" => "$no_mesin",
    //         "ChassisNo" => "$no_rangka",
    //         "AssetDescription" => "$asset_desc",
    //         "AssetName" => "$assets_name",
    //         "OtrPriceAmt" => $otr_price,
    //         "ManufacturingYear" => "$item_year",
    //         "OwnerRelationship" => "$ownership",
    //         "AgrmntRating" => "$agrmnt_rating",
    //         "ContractStat" => "$contract_stat",
    //         "NextInstNum" => $num_of_dependents,
    //         "OsTenor" => $sisa_tenor,
    //         "Tenor" => $tenor,
    //         "BpkbReleaseDt" => $release_date_bpkb,
    //         "MaxPastDueDt" => $max_past_due_date,
    //         "MaturityDt" => $maturity_date,
    //         "ProdCategory" => "$product_cat",
    //         "TaskType" => "$jenis_task",
    //         "SOA" => "$soa",
    //         "DownPayment" => $down_payment,
    //         "Ltv" => "$ltv",
    //         "AnswerCall" => "$answer_call",
    //         "ProspectStat" => "$prospect_stat2",
    //         "ReasonNotProspect" => "$reason_not_prospect",
    //         "Note" => "$notes",
    //         "StartDt" => $started_date,
    //         "EmpPosition" => "$emp_position",
    //         "IaApp" => "$ia_app",
    //         "CustPhoto" => "$cust_photo",
    //         "IdPhoto" => "$id_photo",
    //         "FCardPhoto" => "$f_card_photo",
    //         "PriorityLvl" => "$priority_level",
    //         "DukcapilStat" => "$dukcapil_stat",
    //         "FieldPersonName" => "$field_person_name",
    //         "ReferantorCode" => "$referantor_code",
    //         "ReferantorName" => "$referantor_name",
    //         "PosDealer" => "$pos_dealer",
    //         "MotherName" => "$nama_ibukandung",
    //         "HomeStat" => "$ownership",
    //         "MonthlyInstallment" => $monthly_instalment,
    //         "MaritalStat" => "$marital_status",
    //         "Education" => "$education",
    //         "StayLength" => $stay_length,
    //         "LengthOfWork" => $length_of_work,
    //         "IsDuplicate" => "$duplicate_result",
    //         "DuplicateNum" => $duplicate_ke,
    //         "AssetCode" => "$asset_code",
    //         "DueDt" => $due_date,
    //         "OsInstallmentAmt" => $os_installment_amt,
    //         "StatusCall" => "$status_call",
    //         "SpouseNIK" => "$spouse_nik",
    //         "SpouseBirthPlace" => "$tempat_lahir",
    //         "GuarantorName" => "$guarantor_name",
    //         "GuarantorNIK" => "$guarantor_nik",
    //         "GuarantorMobilePhoneNo" => "$guarantor_phone",
    //         "GuarantorAddr" => "$guarantor_address",
    //         "GuarantorRt" => "$guarantor_rt",
    //         "GuarantorRw" => "$guarantor_rw",
    //         "GuarantorProvince" => "$guarantor_provinsi",
    //         "GuarantorCity" => "$guarantor_kabupaten",
    //         "GuarantorKecamatan" => "$guarantor_kecamatan",
    //         "GuarantorKelurahan" => "$guarantor_kelurahan",
    //         "GuarantorZipcode" => "$guarantor_zipcode",
    //         "GuarantorSubZipcode" => "$GuarantorSubZipcode",
    //         "GuarantorRelationship" => "$GuarantorRelationship",
    //         "CustModel" => "$customer_model",
    //         "NotesOtherVehicle" => "$notes_other_vehicle",
    //         "NotesMobilePhoneNo" => "$notes_phone_alternative",
    // );

    
    $data ="";
    $data2="";

    if($distributed_date!=''&&$distributed_date !="0000-00-00 00:00:00"){
            $data2.=',"DistributedDate":"'.$distributed_date.'"';
    }else{
        $data2.=',"DistributedDate":"'.$assign_time.'"';
    }
    if($region_code!=''){ 
            $data2.=',"OfficeRegionCode":"'.$region_code.'"';
    }
    if($region_name!=''){ 
            $data2.=',"OfficeRegionName":"'.$region_name.'"';
    }
    if($cabang_code!=''){ 
            $data2.=',"OfficeCode":"'.$cabang_code.'"';
    }
    if($cabang_name!=''){ 
            $data2.=',"OfficeName":"'.$cabang_name.'"';
    }
    if($product_offering_code!=''){ 
            $data2.=',"ProdOfferingCode":"'.$product_offering_code.'"';
    }
    if($customer_id!=''){ 
        if($customer_id_ro!=''){ 
            $data2.=',"CustNo":"'.$customer_id_ro.'"';
        }else{
            $data2.=',"CustNo":"'.$customer_id.'"';
        }
    }else{
        if($customer_id_ro!=''){ 
            $data2.=',"CustNo":"'.$customer_id_ro.'"';
        }
    }
    if($customer_name!=''){ 
            $data2.=',"CustName":"'.$customer_name.'"';
    }
    if($nik_ktp!=''){ 
            $data2.=',"IdNo":"'.$nik_ktp.'"';
    }
    if($religion!=''){ 
            $data2.=',"Religion":"'.$religion.'"';
    }
    if($tempat_lahir!=''){ 
            $data2.=',"BirthPlace":"'.$tempat_lahir.'"';
    }
    if($tanggal_lahir!=''&&$tanggal_lahir !="0000-00-00 00:00:00"){ 
            $data2.=',"BirthDate":"'.$tanggal_lahir.'"';
    }
    if($nama_pasangan!=''){ 
            $data2.=',"SpouseName":"'.$nama_pasangan.'"';
    }
    if($tanggal_lahir_pasangan!=''&&$tanggal_lahir_pasangan !="0000-00-00 00:00:00"){ 
            $data2.=',"SpouseBirthDate":"'.$tanggal_lahir_pasangan.'"';
    }
    if($last_followup_date!=''&&$last_followup_date !="0000-00-00 00:00:00"){ 
            $data2.=',"InputDt":"'.$last_followup_date.'"';
    }
    if($waktu_survey!=''&&$waktu_survey !="0000-00-00 00:00:00"){ 
            $data2.=',"SurveyDt":"'.$waktu_survey.'"';
    }
    if($visit_dt!=''&&$visit_dt !="0000-00-00 00:00:00"){ 
            $data2.=',"VisitDt":"'.$visit_dt.'"';
    }
    if($spouse_id_photo!=''){ 
            $data2.=',"SpouseIdPhoto":"'.$spouse_id_photo.'"';
    }
    if($spouse_mobile_phone!=''){ 
            $data2.=',"SpouseMobilePhnNo":"'.$spouse_mobile_phone.'"';
    }
    if($negative_cust!=''){ 
            $data2.=',"NegativeCust":"'.$negative_cust.'"';
    }
    //start new
    if($dukcapil_spouse_stat!=''){ 
            $data2.=',"DukcapilSpouseResult":"'.$dukcapil_spouse_stat.'"';
    }
    if($negative_spouse_cust!=''){ 
            $data2.=',"NegativeSpouse":"'.$negative_spouse_cust.'"';
    }
    if($dukcapil_guarantor_stat!=''){ 
            $data2.=',"DukcapilGuarantorResult":"'.$dukcapil_guarantor_stat.'"';
    }
    if($negative_guarantor_cust!=''){ 
            $data2.=',"NegativeGuarantor":"'.$negative_guarantor_cust.'"';
    }

    if($guarantor_birth_date!=''){ 
            $data2.=',"GuarantorBirthDate":"'.$guarantor_birth_date.'"';
    }
    if($guarantor_birth_place!=''){ 
            $data2.=',"GuarantorBirthPlace":"'.$guarantor_birth_place.'"';
    }
    if($guarantor_mobile_phone!=''){ 
            $data2.=',"GuarantorMobilePhoneNo":"'.$guarantor_mobile_phone.'"';
    }
    // if($GuarantorRelationship!=''){ 
    //         $data2.=',"GuarantorRelationship":"'.$GuarantorRelationship.'"';
    // }

    //end new

    if($legal_alamat!=''){ 
            $data2.=',"LegalAddr":"'.$legal_alamat.'"';
    }
    if($legal_city!=''){ 
            $data2.=',"LegalCity":"'.$legal_city.'"';
    }
    if($legal_kecamatan!=''){ 
            $data2.=',"LegalSubDistrict":"'.$legal_kecamatan.'"';
    }
    if($legal_kelurahan!=''){ 
            $data2.=',"LegalVillage":"'.$legal_kelurahan.'"';
    }
    if($legal_provinsi!=''){ 
            $data2.=',"LegalProvince":"'.$legal_provinsi.'"';
    }
    if($legal_kabupaten!=''){ 
            $data2.=',"LegalDistrict":"'.$legal_kabupaten.'"';
    }
    if($legal_rt!=''){ 
            $data2.=',"LegalRt":"'.$legal_rt.'"';
    }
    if($legal_rw!=''){ 
            $data2.=',"LegalRw":"'.$legal_rw.'"';
    }
    if($legal_kodepos!=''){ 
            $data2.=',"LegalZipcode":"'.$legal_kodepos.'"';
    }
    if($legal_sub_kodepos!=''){ 
            $data2.=',"LegalSubZipcode":"'.$legal_sub_kodepos.'"';
    }
    if($survey_alamat!=''){ 
            $data2.=',"SurveyAddr":"'.$survey_alamat.'"';
    }
    if($survey_rt!=''){ 
            $data2.=',"SurveyRt":"'.$survey_rt.'"';
    }
    if($survey_rw!=''){ 
            $data2.=',"SurveyRw":"'.$survey_rw.'"';
    }
    if($survey_provinsi!=''){ 
            $data2.=',"SurveyProvince":"'.$survey_provinsi.'"';
    }
    if($survey_kabupaten!=''){ 
            $data2.=',"SurveyCity":"'.$survey_kabupaten.'"';
    }
    if($survey_kecamatan!=''){ 
            $data2.=',"SurveySubDistrict":"'.$survey_kecamatan.'"';
    }
    if($survey_kelurahan!=''){ 
            $data2.=',"SurveyVillage":"'.$survey_kelurahan.'"';
    }
    if($survey_kodepos!=''){ 
            $data2.=',"SurveyZipCode":"'.$survey_kodepos.'"';
    }
    if($survey_sub_kodepos!=''){ 
            $data2.=',"SurveySubZipcode":"'.$survey_sub_kodepos.'"';
    }
    if($survey_kabupaten!=''){ 
            $data2.=',"SurveyDistrict":"'.$survey_kabupaten.'"';
    }
    if($SurveySubDistrict!=''){ 
            $data2.=',"SurveySubDistrict":"'.$SurveySubDistrict.'"';
    }
    if($mobile_1!=''){ 
            $data2.=',"MobilePhoneNo1":"'.$mobile_1.'"';
    }
    if($mobile_2!=''){ 
            $data2.=',"MobilePhoneNo2":"'.$mobile_2.'"';
    }
    if($phone_1!=''){ 
            $data2.=',"Phone1":"'.$phone_1.'"';
    }
    if($phone_2!=''){ 
            $data2.=',"Phone2":"'.$phone_2.'"';
    }
    if($job_phone_1!=''){ 
            $data2.=',"JobPhone1":"'.$job_phone_1.'"';
    }
    if($job_phone_2!=''){ 
            $data2.=',"JobPhone2":"'.$job_phone_2.'"';
    }
    if($profession_name!=''){ 
            $data2.=',"ProfessionName":"'.$profession_name.'"';
    }
    if($profession_cat_name!=''){ 
            $data2.=',"ProfessionCategoryName":"'.$profession_cat_name.'"';
    }
    if($job_position!=''){ 
            $data2.=',"JobPosition":"'.$job_position.'"';
    }
    if($industry_type_name!=''){ 
            $data2.=',"IndustryTypeName":"'.$industry_type_name.'"';
    }
    if($monthly_income!=''){
            if ($monthly_income=='0') {
                $monthly_income=null;
             } 
            $data2.=',"MonthlyIncome":"'.$monthly_income.'"';
    }
    if($monthly_expense!=''){ 
            $data2.=',"MonthlyExpense":"'.$monthly_expense.'"';
    }
    if($plafond!=''&&$plafond!='0.0'){ 
            $data2.=',"Plafon":"'.$plafond.'"';
    }
    if($oth_biz_name!=''){ 
            $data2.=',"OtherBizName":"'.$oth_biz_name.'"';
    }
    if($customer_rating!=''){ 
            $data2.=',"CustRating":"'.$customer_rating.'"';
    }
    if ($lob=="MGJMTRKON" || $lob=="MGJMBLSYR" || $lob=="MGJMTRSYR" || $lob=="MGJMBLKON" || $lob=="FASDANMBL" || $lob=="SLBINV" || $lob=="FASDANMTR" || $lob=="SLBMBL") {
        $suppl_name="SUPPLIER";
        $suppl_code="DUMMY";
    }
    if($suppl_name!=''){ 
            $data2.=',"SupplBranchName":"'.$suppl_name.'"';
    }
    if($suppl_code!=''){ 
            $data2.=',"SupplBranchCode":"'.$suppl_code.'"';
    }
    if($no_mesin!=''){ 
            $data2.=',"MachineNo":"'.$no_mesin.'"';
    }
    if($no_rangka!=''){ 
            $data2.=',"ChassisNo":"'.$no_rangka.'"';
    }
    if($asset_desc!=''){ 
            $data2.=',"AssetDescription":"'.$asset_desc.'"';
    }
    if($assets_name!=''){ 
            $data2.=',"AssetName":"'.$assets_name.'"';
    }
    if($otr_price!=''){ 
            $data2.=',"OtrPriceAmt":"'.$otr_price.'"';
    }
    if($item_year!=''){ 
            $data2.=',"ManufacturingYear":"'.$item_year.'"';
    }
    // if($ownership!=''){ 
    //         $data2.=',"OwnerRelationship":"'.$ownership.'"';
    // }
    if($agrmnt_rating!=''){ 
            $data2.=',"AgrmntRating":"'.$agrmnt_rating.'"';
    }
    if($contract_stat!=''){ 
            $data2.=',"ContractStat":"'.$contract_stat.'"';
    }
    if($num_of_dependents!=''){ 
            $data2.=',"NextInstNum":"'.$num_of_dependents.'"';
    }
    if($sisa_tenor!=''&&$sisa_tenor!=0){ 
            $data2.=',"OsTenor":"'.$sisa_tenor.'"';
    }
    if($tenor!=''){ 
            $data2.=',"Tenor":"'.$tenor.'"';
    }
    if($release_date_bpkb!=''&&$release_date_bpkb !="0000-00-00 00:00:00"){ 
            $data2.=',"BpkbReleaseDt":"'.$release_date_bpkb.'"';
    }
    if($max_past_due_date!=''){ 
            $data2.=',"MaxPastDueDt":"'.$max_past_due_date.'"';
    }
    if($maturity_date!=''&&$maturity_date !="0000-00-00 00:00:00"){ 
            $data2.=',"MaturityDt":"'.$maturity_date.'"';
    }
    if($product_cat!=''){ 
            $data2.=',"ProdCategory":"'.$product_cat.'"';
    }
    if($jenis_task!=''){ 
            $data2.=',"TaskType":"'.$jenis_task.'"';
    }
    if($soa!=''){ 
            $data2.=',"SOA":"'.$soa.'"';
    }
    if($down_payment!=''){ 
            $data2.=',"DownPayment":"'.$down_payment.'"';
    }
    
    if ($ltv=='.00.00') {
        $ltv=null;
    }
    if ($ltv=='.00.00.00.00.00.00.00.00') {
        $ltv=null;
    }
    if($ltv!=''&&$ltv!='.00'){ 
            $data2.=',"Ltv":"'.$ltv.'"';
    }
    if($answer_call!=''){ 
            $data2.=',"AnswerCall":"'.$answer_call.'"';
    }
    if($prospect_stat2!=''){ 
            $data2.=',"ProspectStat":"'.$prospect_stat2.'"';
    }
    if($reason_not_prospect!=''){ 
            $data2.=',"ReasonNotProspect":"'.$reason_not_prospect.'"';
    }
    if($remark_desc!=''){ 
            $data2.=',"Note":"'.$remark_desc.'"';
    }
    if($started_date!=''&&$started_date !="0000-00-00 00:00:00"){
            $data2.=',"StartDt":"'.$started_date.'"';
    }
    if($emp_position!=''){ 
            $data2.=',"EmpPosition":"'.$emp_position.'"';
    }
    if($ia_app!=''){ 
            $data2.=',"IaApp":"'.$ia_app.'"';
    }
    if($cust_photo!=''){ 
            $data2.=',"CustPhoto":"'.$cust_photo.'"';
    }
    if($id_photo!=''){ 
            $data2.=',"IdPhoto":"'.$id_photo.'"';
    }
    if($f_card_photo!=''){ 
            $data2.=',"FCardPhoto":"'.$f_card_photo.'"';
    }
    if($priority_level!=''){ 
            $data2.=',"PriorityLvl":"'.$priority_level.'"';
    }
    if ($dukcapil_stat=='NULL') {
        $dukcapil_stat=null;
    }
    if($dukcapil_stat!=''){ 
            $data2.=',"DukcapilStat":"'.$dukcapil_stat.'"';
    }
    if($agent_name!=''){ 
            $data2.=',"FieldPersonName":"'.$agent_name.'"';
    }
    if($referantor_no!=''){ 
            $data2.=',"ReferantorCode":"'.$referantor_no.'"';
    }
    if($referantor_name!=''){ 
            $data2.=',"ReferantorName":"'.$referantor_name.'"';
    }
    if($pos_dealer!=''){ 
            $data2.=',"PosDealer":"'.$pos_dealer.'"';
    }
    if($nama_ibukandung!=''){ 
            $data2.=',"MotherName":"'.$nama_ibukandung.'"';
    }
    if($house_ownership!=''){ 
            $data2.=',"HomeStat":"'.$house_ownership.'"';
    }
    if($monthly_instalment!=''){ 
            $data2.=',"MonthlyInstallment":"'.$monthly_instalment.'"';
    }
    if($marital_status!=''){ 
            $data2.=',"MaritalStat":"'.$marital_status.'"';
    }
    if($education!=''){ 
            $data2.=',"Education":"'.$education.'"';
    }
    if($length_of_domicile!=''){ 
            $data2.=',"StayLength":"'.$length_of_domicile.'"';
    }
    if($length_of_work!=''){ 
            $data2.=',"LengthOfWork":"'.$length_of_work.'"';
    }
    if($num_duplicate!=''&&$num_duplicate>0){ 
            $data2.=',"IsDuplicate":"T"';
    }
    if($num_duplicate!=''&&$num_duplicate>0){ 
            $data2.=',"DuplicateNum":"'.$num_duplicate.'"';
    }
    if($asset_code!=''){ 
            $data2.=',"AssetCode":"'.$asset_code.'"';
    }else{
        $data2.=',"AssetCode":"'.$item_type.'"';
    }
    if($due_date!=''){ 
            $data2.=',"DueDt":"'.$due_date.'"';
    }
    if($os_installment_amt!=''){ 
            $data2.=',"OsInstallmentAmt":"'.$os_installment_amt.'"';
    }
    if($status_call!=''){ 
            $data2.=',"StatusCall":"'.$status_call.'"';
    }
    if($spouse_nik!=''){ 
            $data2.=',"SpouseNIK":"'.$spouse_nik.'"';
    }
    if($spouse_birth_place!=''){ 
            $data2.=',"SpouseBirthPlace":"'.$spouse_birth_place.'"';
    }
    if($guarantor_name!=''){ 
            $data2.=',"GuarantorName":"'.$guarantor_name.'"';
    }
    if($guarantor_nik!=''){ 
            $data2.=',"GuarantorNIK":"'.$guarantor_nik.'"';
    }
    if($guarantor_phone!=''){ 
            $data2.=',"GuarantorMobilePhoneNo":"'.$guarantor_phone.'"';
    }
    if($guarantor_address!=''){ 
            $data2.=',"GuarantorAddr":"'.$guarantor_address.'"';
    }
    if($guarantor_rt!=''){ 
            $data2.=',"GuarantorRt":"'.$guarantor_rt.'"';
    }
    if($guarantor_rw!=''){ 
            $data2.=',"GuarantorRw":"'.$guarantor_rw.'"';
    }
    if($guarantor_provinsi!=''){ 
            $data2.=',"GuarantorProvince":"'.$guarantor_provinsi.'"';
    }
    if($guarantor_kabupaten!=''){ 
            $data2.=',"GuarantorCity":"'.$guarantor_kabupaten.'"';
    }
    if($guarantor_kecamatan!=''){ 
            $data2.=',"GuarantorKecamatan":"'.$guarantor_kecamatan.'"';
    }
    if($guarantor_kelurahan!=''){ 
            $data2.=',"GuarantorKelurahan":"'.$guarantor_kelurahan.'"';
    }
    if($guarantor_zipcode!=''){ 
            $data2.=',"GuarantorZipcode":"'.$guarantor_zipcode.'"';
    }
    if($GuarantorSubZipcode!=''){ 
            $data2.=',"GuarantorSubZipcode":"'.$GuarantorSubZipcode.'"';
    }
    if($guarantor_relation!=''){ 
            $data2.=',"GuarantorRelationship":"'.$guarantor_relation.'"';
    }
    if($customer_model!=''){ 
            $data2.=',"CustModel":"'.$customer_model.'"';
    }
    if($notes_other_vehicle!=''){ 
            $data2.=',"NotesOtherVehicle":"'.$notes_other_vehicle.'"';
    }
    if($notes_phone_alternative!=''){ 
            $data2.=',"NotesMobilePhoneNo":"'.$notes_phone_alternative.'"';
    }         
    if($source_data!=''){ 
            $data2.=',"SourceData":"'.$source_data.'"';
    }           
    if($agrmnt_no!=''){ 
            $data2.=',"AgrmntNo":"'.$agrmnt_no.'"';
    }           
    if($lob!=''){ 
            $data2.=',"Lob":"'.$lob.'"';
    }           
    if($three_ins_type!=''){ 
            $data2.=',"InsuranceType":"'.$three_ins_type.'"';
    }           
    if($three_ph_yang!=''){ 
            $data2.=',"OsInstallmentAmt":"'.$three_ph_yang.'"';
    }

    //new    
    if($is_pre_approval!=''){ 
            $param_approv = 'PRE APPROVAL';
            $data2.=',"IsPreApproval":"'.$is_pre_approval.'"';
    }   
    if($opsi_penanganan!=''){ 
            $data2.=',"OpsiPenanganan":"'.$opsi_penanganan.'"';
    }   
    if($SubStatusCall!=''){ 
            $data2.=',"SubStatusCall":"'.$SubStatusCall.'"';
    }

    $data = '{"TaskId":"'.$task_id.'"'.$data2.'}';


    // $payload = json_encode($data);
    $payload = $data;

    $sqllog = "INSERT INTO cc_respons_log SET
                    type_api            ='API_UPDATE_Data_To_POLO2', 
                    url_api             ='$url', 
                    post_api            ='$payload', 
                    respon_exe          =now()";
    $reslog = mysqli_query($condb,$sqllog);
    $idlog  = mysqli_insert_id($condb);

    // echo "string <pre>$payload </pre></br>";
    //attach encoded JSON string to the POST fields
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    //set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    //return response instead of outputting
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //execute the POST request
    $result = curl_exec($ch);
// print_r($result); echo "<br>";
// echo 'Curl error: ' . curl_error($ch);

    $resp = json_decode($result, true);
    // echo $resp;
    $result = str_replace("[", "", $result);
    $result = str_replace("]", "", $result);
    // echo $result;
    // echo " </br></br>string $result";
    // echo $resp;
    // print_r($resp);

    //close cURL resource
    curl_close($ch);



$responseMessage        = $resp[0]['responseMessage'];
$sqllog = "UPDATE cc_respons_log SET
                respon_status       ='$responseMessage', 
                respon_desc         ='$result',  
                respon_time         =now()
                WHERE id='$idlog'";
$reslog = mysqli_query($condb,$sqllog);
sleep(5);
}
$result = '{"responseCode":"00","responseMessage":"SUCCESS","data":"POL000493995"}';
echo $result;

// }


disconnectDB($condb);
?>
