<?php
$path = "config_api.php";
if (file_exists($path)) {
        include $path;
}
$path = "global_func.php";
if (file_exists($path)) {
        include $path;
}
$path = "db_config.php";
if (file_exists($path)) {
        include $path;
}

$idName              = "UPDATE_FROM_CRM"; 
$taskId = filter_input(INPUT_GET, 'taskId'); 
$distributedDate = filter_input(INPUT_GET, 'distributedDate'); 
$no_pengajuan = filter_input(INPUT_GET, 'no_pengajuan');  
$whr_sql = " task_id='$taskId' ";
if ($no_pengajuan !=="") {
    $whr_sql = " no_pengajuan='$no_pengajuan' ";
}
$condb = connectDB();

$url = $url_api_fin.'/api/Pengajuan/UpdateTaskSLA';

$dateexe = DATE("Y-m-d H:i:s");
$datesla = DATE("Y-m-d");


$arrsubcat = array();
$sqlsubct = " SELECT id, call_status_sub1 FROM cc_ts_call_status_sub1 
WHERE status=1 ORDER BY call_status_sub1 ASC ";
$ressubct   = mysqli_query($condb, $sqlsubct);
while($recsubct = mysqli_fetch_object($ressubct)){
  $arrsubcat[$recsubct["id"]] = $recsubct->call_status_sub1;
}

$sql12->prepare("SELECT * FROM cc_ts_penawaran WHERE $whr_sql");
$res12 = mysqli_query($condb, $sql12);
if($rec12 = mysqli_fetch_object($res12)) {
  $customer_id     = $rec12->customer_id;
  $customer_id_ro     = $rec12->customer_id_ro;
}
$sqlwhr=" (customer_id='$customer_id' OR customer_id_ro='$customer_id_ro') AND call_status > 0 ";
if ($customer_id==='') {
    $sqlwhr=" $whr_sql ";
}
$sqla->prepare("SELECT * FROM cc_ts_penawaran WHERE $sqlwhr");
$resa = mysqli_query($condb,$sqla);
while($reca = mysqli_fetch_object($resa)){
    @extract($reca,EXTR_OVERWRITE);
    if ($no_pengajuan!=="") {
        $taskId=$task_id;
    }
    $taskId=$task_id;
    $num_duplicate=0;
    $paramduplicate = strpos($source_data,"WISE");
    if($paramduplicate >=0){
        $sql12->prepare(" SELECT * FROM cc_ts_simulasi a
                   WHERE a.id_cust_detail='$id' AND a.num_duplicate>0
                   AND a.modif_by='$last_followup_by')";
        $res12 = mysqli_query($condb, $sql12);
        if($rec12 = mysqli_fetch_object($res12)) {
          $id_simulasi     = $rec12->id;
          $num_duplicate   = $rec12->num_duplicate;

          $sqlupall->prepare("UPDATE cc_ts_simulasi SET    
                          num_duplicate = '0',
                          last_num_duplicate = '$num_duplicate'
                   WHERE id ='$id_simulasi'");
          mysqli_query($condb,$sqlupall);
        }
    }


$sqlupall->prepare("UPDATE cc_ts_simulasi SET    
                sla_date = '$datesla'
         WHERE id_cust_detail ='$id'");
mysqli_query($condb,$sqlupall);


        $sql12->prepare(" SELECT a.agent_name, b.emp_name, c.referantor_id, c.referantor_no, c.referantor_name FROM cc_agent_profile a 
                 LEFT JOIN cc_employee b ON a.agent_id=b.ref_no
                 LEFT JOIN cc_master_referantor c ON b.ref_emp_id=c.ref_emp_id WHERE a.id='$last_followup_by' ");
        $res12 = mysqli_query($condb, $sql12);
        if($rec12 = mysqli_fetch_object($res12)) {
          $referantor_id   = $rec12->referantor_id;
          $referantor_no   = $rec12->referantor_no;
          $referantor_name = $rec12->referantor_name;
        }
    
    $sqlcs->prepare("SELECT b.call_status, a.sub_result FROM cc_ts_penawaran_call_session a LEFT JOIN cc_ts_call_status b  ON a.result=b.id WHERE a.task_id='$taskId' ORDER BY a.id DESC LIMIT 1 ");
    $rescs = mysqli_query($condb,$sqlcs);
    if($reccs = mysqli_fetch_object($rescs)){
        $call_status2         = $reccs->call_status;
        $call_status_sub12    = $reccs->call_status_sub1;
        $sub_result           = $reccs->sub_result;
        if ($call_status2==="Prospect") {
            $prospect_stat2 = "Prospek";
        }else if ($call_status2==="Interest") {
            $prospect_stat2 = $call_status2;
        }else if ($call_status2==="Uncontacted") {
            $prospect_stat2 = $call_status2;
        }else if ($call_status2==="Unconnected") {
            $prospect_stat2 = $call_status2;
        }
        else if ($call_status2==="UnConnected") {
            $prospect_stat2 = "Unconnected";
        }else{
            $prospect_stat2 = $call_status2;
        }
    }
    if ($call_status==='5') {
        $prospect_stat2 = "UnAnswer";
    }
    if ($call_status==='6') {
        $prospect_stat2 = "Unconnected";
    }

    $SubStatusCall = $arrsubcat[$sub_result];

    if ($call_status==='4') {
          $sqlcs->prepare("UPDATE cc_call_back SET    
                          notif_flag = '0'
                   WHERE com_ticket ='$id' AND notif_flag='99'");
          mysqli_query($condb,$sqlcallback);
    }


    $sqlcs->prepare("SELECT a.agent_name FROM cc_agent_profile a WHERE a.id='$last_followup_by' ");
    $rescs = mysqli_query($condb,$sqlcs);
    if($reccs = mysqli_fetch_object($rescs)){
        $agent_name         = $reccs->agent_name;
    }
    
    
    $ch = curl_init($url); 
    $monthly_instalment = str_replace(".00", "", $monthly_instalment);
    $plafond        = str_replace(".00", "", $plafond);
    $otr_price    = str_replace(".00", "", $otr_price);
    $emp_position = "TELESALES";
    
    $path = '../../public/konfirm/cust_photo/'.$cust_photo;
    $type = end(explode('.', $path));
    $data = file_get_contents($path);
    $cust_photo = base64_encode($data);


    $path = '../../public/konfirm/id_photo/'.$id_photo;
    $type = end(explode('.', $path));
    $data = file_get_contents($path);
    $id_photo = base64_encode($data);


    $monthly_income    = str_replace(".", "", $monthly_income);
    


$sqlsa->prepare("SELECT 
            a.id, a.id_penawaran, a.assets_type, a.assets_name, a.assets_type_desc, a.assets_desc,
            a.engine_no, a.license_plate, a.chasis_no, a.manufacturing_year, a.asset_ownership, a.product_offering, 
            a.asset_price, a.platfond_max, a.tenor, a.ltv, a.instalment, a.ltv_persen, a.kategori_asset
          FROM 
            cc_ts_penawaran_add_assets a 
          WHERE 
            a.task_id='$taskId'
          ORDER BY a.update_time DESC LIMIT 1");
$ressa = mysqli_query($condb,$sqlsa);
$no=1;
if($recsa = mysqli_fetch_object($ressa)){
    $assets_desc       = $recsa->assets_desc;
}

    $asset_desc=$assets_desc;
    if ($no_mesin==="") {
        $no_mesin=$engine_no;
    }
    if ($no_rangka==="") {
        $no_rangka=$chasis_no;
    }
    
    
    $data ="";
    $data2="";

    if($distributed_date!==''&&$distributed_date !=="0000-00-00 00:00:00"){
            $data2.=',"DistributedDate":"'.$distributed_date.'"';
    }else{
        $data2.=',"DistributedDate":"'.$assign_time.'"';
    }
    if($region_code!==''){ 
            $data2.=',"OfficeRegionCode":"'.$region_code.'"';
    }
    if($region_name!==''){ 
            $data2.=',"OfficeRegionName":"'.$region_name.'"';
    }
    if($cabang_code!==''){ 
            $data2.=',"OfficeCode":"'.$cabang_code.'"';
    }
    if($cabang_name!==''){ 
            $data2.=',"OfficeName":"'.$cabang_name.'"';
    }
    if ($product_offering_code !== '') { 
            $data2.=',"ProdOfferingCode":"'.$product_offering_code.'"';
    }
    if($customer_id!==''){ 
        if($customer_id_ro!==''){ 
            $data2.=',"CustNo":"'.$customer_id_ro.'"';
        }else{
            $data2.=',"CustNo":"'.$customer_id.'"';
        }
    }else{
        if($customer_id_ro!==''){ 
            $data2.=',"CustNo":"'.$customer_id_ro.'"';
        }
    }
    if($customer_name!==''){ 
            $data2.=',"CustName":"'.$customer_name.'"';
    }
    if($nik_ktp!==''){ 
            $data2.=',"IdNo":"'.$nik_ktp.'"';
    }
    if($religion!==''){ 
            $data2.=',"Religion":"'.$religion.'"';
    }
    if($tempat_lahir!==''){ 
            $data2.=',"BirthPlace":"'.$tempat_lahir.'"';
    }
    if($tanggal_lahir!==''&&$tanggal_lahir !=="0000-00-00 00:00:00"){ 
            $data2.=',"BirthDate":"'.$tanggal_lahir.'"';
    }
    if($nama_pasangan!==''){ 
            $data2.=',"SpouseName":"'.$nama_pasangan.'"';
    }
    if($tanggal_lahir_pasangan!==''&&$tanggal_lahir_pasangan !=="0000-00-00 00:00:00"){ 
            $data2.=',"SpouseBirthDate":"'.$tanggal_lahir_pasangan.'"';
    }
    if($last_followup_date!==''&&$last_followup_date !=="0000-00-00 00:00:00"){ 
            $data2.=',"InputDt":"'.$last_followup_date.'"';
    }
    if($waktu_survey!==''&&$waktu_survey !=="0000-00-00 00:00:00"){ 
            $data2.=',"SurveyDt":"'.$waktu_survey.'"';
    }
    if($visit_dt!==''&&$visit_dt !=="0000-00-00 00:00:00"){ 
            $data2.=',"VisitDt":"'.$visit_dt.'"';
    }
    if($spouse_id_photo!==''){ 
            $data2.=',"SpouseIdPhoto":"'.$spouse_id_photo.'"';
    }
    if($spouse_mobile_phone!==''){ 
            $data2.=',"SpouseMobilePhnNo":"'.$spouse_mobile_phone.'"';
    }
    if($negative_cust!==''){ 
            $data2.=',"NegativeCust":"'.$negative_cust.'"';
    }
    
    if($dukcapil_spouse_stat!==''){ 
            $data2.=',"DukcapilSpouseResult":"'.$dukcapil_spouse_stat.'"';
    }
    if($negative_spouse_cust!==''){ 
            $data2.=',"NegativeSpouse":"'.$negative_spouse_cust.'"';
    }
    if($dukcapil_guarantor_stat!==''){ 
            $data2.=',"DukcapilGuarantorResult":"'.$dukcapil_guarantor_stat.'"';
    }
    if($negative_guarantor_cust!==''){ 
            $data2.=',"NegativeGuarantor":"'.$negative_guarantor_cust.'"';
    }

    if($guarantor_birth_date!==''){ 
            $data2.=',"GuarantorBirthDate":"'.$guarantor_birth_date.'"';
    }
    if($guarantor_birth_place!==''){ 
            $data2.=',"GuarantorBirthPlace":"'.$guarantor_birth_place.'"';
    }
    if($guarantor_mobile_phone!==''){ 
            $data2.=',"GuarantorMobilePhoneNo":"'.$guarantor_mobile_phone.'"';
    }

    if($legal_alamat!==''){ 
            $data2.=',"LegalAddr":"'.$legal_alamat.'"';
    }
    if($legal_city!==''){ 
            $data2.=',"LegalCity":"'.$legal_city.'"';
    }
    if($legal_kecamatan!==''){ 
            $data2.=',"LegalSubDistrict":"'.$legal_kecamatan.'"';
    }
    if($legal_kelurahan!==''){ 
            $data2.=',"LegalVillage":"'.$legal_kelurahan.'"';
    }
    if($legal_provinsi!==''){ 
            $data2.=',"LegalProvince":"'.$legal_provinsi.'"';
    }
    if($legal_kabupaten!==''){ 
            $data2.=',"LegalDistrict":"'.$legal_kabupaten.'"';
    }
    if($legal_rt!==''){ 
            $data2.=',"LegalRt":"'.$legal_rt.'"';
    }
    if($legal_rw!==''){ 
            $data2.=',"LegalRw":"'.$legal_rw.'"';
    }
    if($legal_kodepos!==''){ 
            $data2.=',"LegalZipcode":"'.$legal_kodepos.'"';
    }
    if($legal_sub_kodepos!==''){ 
            $data2.=',"LegalSubZipcode":"'.$legal_sub_kodepos.'"';
    }
    if($survey_alamat!==''){ 
            $data2.=',"SurveyAddr":"'.$survey_alamat.'"';
    }
    if($survey_rt!==''){ 
            $data2.=',"SurveyRt":"'.$survey_rt.'"';
    }
    if($survey_rw!==''){ 
            $data2.=',"SurveyRw":"'.$survey_rw.'"';
    }
    if($survey_provinsi!==''){ 
            $data2.=',"SurveyProvince":"'.$survey_provinsi.'"';
    }
    if($survey_kabupaten!==''){ 
            $data2.=',"SurveyCity":"'.$survey_kabupaten.'"';
    }
    if($survey_kecamatan!==''){ 
            $data2.=',"SurveySubDistrict":"'.$survey_kecamatan.'"';
    }
    if($survey_kelurahan!==''){ 
            $data2.=',"SurveyVillage":"'.$survey_kelurahan.'"';
    }
    if($survey_kodepos!==''){ 
            $data2.=',"SurveyZipCode":"'.$survey_kodepos.'"';
    }
    if($survey_sub_kodepos!==''){ 
            $data2.=',"SurveySubZipcode":"'.$survey_sub_kodepos.'"';
    }
    if($survey_kabupaten!==''){ 
            $data2.=',"SurveyDistrict":"'.$survey_kabupaten.'"';
    }
    if($SurveySubDistrict!==''){ 
            $data2.=',"SurveySubDistrict":"'.$SurveySubDistrict.'"';
    }
    if($mobile_1!==''){ 
            $data2.=',"MobilePhoneNo1":"'.$mobile_1.'"';
    }
    if($mobile_2!==''){ 
            $data2.=',"MobilePhoneNo2":"'.$mobile_2.'"';
    }
    if($phone_1!==''){ 
            $data2.=',"Phone1":"'.$phone_1.'"';
    }
    if($phone_2!==''){ 
            $data2.=',"Phone2":"'.$phone_2.'"';
    }
    if($job_phone_1!==''){ 
            $data2.=',"JobPhone1":"'.$job_phone_1.'"';
    }
    if($job_phone_2!==''){ 
            $data2.=',"JobPhone2":"'.$job_phone_2.'"';
    }
    if($profession_name!==''){ 
            $data2.=',"ProfessionName":"'.$profession_name.'"';
    }
    if($profession_cat_name!==''){ 
            $data2.=',"ProfessionCategoryName":"'.$profession_cat_name.'"';
    }
    if($job_position!==''){ 
            $data2.=',"JobPosition":"'.$job_position.'"';
    }
    if($industry_type_name!==''){ 
            $data2.=',"IndustryTypeName":"'.$industry_type_name.'"';
    }
    if($monthly_income!==''){
            if ($monthly_income==='0') {
                $monthly_income=null;
             } 
            $data2.=',"MonthlyIncome":"'.$monthly_income.'"';
    }
    if($monthly_expense!==''){ 
            $data2.=',"MonthlyExpense":"'.$monthly_expense.'"';
    }
    if($plafond!==''&&$plafond!=='0.0'){ 
            $data2.=',"Plafon":"'.$plafond.'"';
    }
    if($oth_biz_name!==''){ 
            $data2.=',"OtherBizName":"'.$oth_biz_name.'"';
    }
    if($customer_rating!==''){ 
            $data2.=',"CustRating":"'.$customer_rating.'"';
    }
    if ($lob==="MGJMTRKON" || $lob==="MGJMBLSYR" || $lob==="MGJMTRSYR" || $lob==="MGJMBLKON" || $lob==="FASDANMBL" || $lob==="SLBINV" || $lob==="FASDANMTR" || $lob==="SLBMBL") {
        $suppl_name="SUPPLIER";
        $suppl_code="DUMMY";
    }
    if($suppl_name!==''){ 
            $data2.=',"SupplBranchName":"'.$suppl_name.'"';
    }
    if($suppl_code!==''){ 
            $data2.=',"SupplBranchCode":"'.$suppl_code.'"';
    }
    if($no_mesin!==''){ 
            $data2.=',"MachineNo":"'.$no_mesin.'"';
    }
    if($no_rangka!==''){ 
            $data2.=',"ChassisNo":"'.$no_rangka.'"';
    }
    if($asset_desc!==''){ 
            $data2.=',"AssetDescription":"'.$asset_desc.'"';
    }
    if($assets_name!==''){ 
            $data2.=',"AssetName":"'.$assets_name.'"';
    }
    if($otr_price!==''){ 
            $data2.=',"OtrPriceAmt":"'.$otr_price.'"';
    }
    if($item_year!==''){ 
            $data2.=',"ManufacturingYear":"'.$item_year.'"';
    }
    
    if($agrmnt_rating!==''){ 
            $data2.=',"AgrmntRating":"'.$agrmnt_rating.'"';
    }
    if($contract_stat!==''){ 
            $data2.=',"ContractStat":"'.$contract_stat.'"';
    }
    if($num_of_dependents!==''){ 
            $data2.=',"NextInstNum":"'.$num_of_dependents.'"';
    }
    if($sisa_tenor!==''&&$sisa_tenor!==0){ 
            $data2.=',"OsTenor":"'.$sisa_tenor.'"';
    }
    if($tenor!==''){ 
            $data2.=',"Tenor":"'.$tenor.'"';
    }
    if($release_date_bpkb!==''&&$release_date_bpkb !=="0000-00-00 00:00:00"){ 
            $data2.=',"BpkbReleaseDt":"'.$release_date_bpkb.'"';
    }
    if($max_past_due_date!==''){ 
            $data2.=',"MaxPastDueDt":"'.$max_past_due_date.'"';
    }
    if($maturity_date!==''&&$maturity_date !=="0000-00-00 00:00:00"){ 
            $data2.=',"MaturityDt":"'.$maturity_date.'"';
    }
    if($product_cat!==''){ 
            $data2.=',"ProdCategory":"'.$product_cat.'"';
    }
    if($jenis_task!==''){ 
            $data2.=',"TaskType":"'.$jenis_task.'"';
    }
    if($soa!==''){ 
            $data2.=',"SOA":"'.$soa.'"';
    }
    if($down_payment!==''){ 
            $data2.=',"DownPayment":"'.$down_payment.'"';
    }
    
    if ($ltv==='.00.00') {
        $ltv=null;
    }
    if ($ltv==='.00.00.00.00.00.00.00.00') {
        $ltv=null;
    }
    if($ltv!==''&&$ltv!=='.00'){ 
            $data2.=',"Ltv":"'.$ltv.'"';
    }
    if($answer_call!==''){ 
            $data2.=',"AnswerCall":"'.$answer_call.'"';
    }
    if($prospect_stat2!==''){ 
            $data2.=',"ProspectStat":"'.$prospect_stat2.'"';
    }
    if($reason_not_prospect!==''){ 
            $data2.=',"ReasonNotProspect":"'.$reason_not_prospect.'"';
    }
    if($remark_desc!==''){ 
            $data2.=',"Note":"'.$remark_desc.'"';
    }
    if($started_date!==''&&$started_date !=="0000-00-00 00:00:00"){
            $data2.=',"StartDt":"'.$started_date.'"';
    }
    if($emp_position!==''){ 
            $data2.=',"EmpPosition":"'.$emp_position.'"';
    }
    if($ia_app!==''){ 
            $data2.=',"IaApp":"'.$ia_app.'"';
    }
    if($cust_photo!==''){ 
            $data2.=',"CustPhoto":"'.$cust_photo.'"';
    }
    if($id_photo!==''){ 
            $data2.=',"IdPhoto":"'.$id_photo.'"';
    }
    if($f_card_photo!==''){ 
            $data2.=',"FCardPhoto":"'.$f_card_photo.'"';
    }
    if($priority_level!==''){ 
            $data2.=',"PriorityLvl":"'.$priority_level.'"';
    }
    if ($dukcapil_stat==='NULL') {
        $dukcapil_stat=null;
    }
    if($dukcapil_stat!==''){ 
            $data2.=',"DukcapilStat":"'.$dukcapil_stat.'"';
    }
    if($agent_name!==''){ 
            $data2.=',"FieldPersonName":"'.$agent_name.'"';
    }
    if($referantor_no!==''){ 
            $data2.=',"ReferantorCode":"'.$referantor_no.'"';
    }
    if($referantor_name!==''){ 
            $data2.=',"ReferantorName":"'.$referantor_name.'"';
    }
    if($pos_dealer!==''){ 
            $data2.=',"PosDealer":"'.$pos_dealer.'"';
    }
    if($nama_ibukandung!==''){ 
            $data2.=',"MotherName":"'.$nama_ibukandung.'"';
    }
    if($house_ownership!==''){ 
            $data2.=',"HomeStat":"'.$house_ownership.'"';
    }
    if($monthly_instalment!==''){ 
            $data2.=',"MonthlyInstallment":"'.$monthly_instalment.'"';
    }
    if($marital_status!==''){ 
            $data2.=',"MaritalStat":"'.$marital_status.'"';
    }
    if($education!==''){ 
            $data2.=',"Education":"'.$education.'"';
    }
    if($length_of_domicile!==''){ 
            $data2.=',"StayLength":"'.$length_of_domicile.'"';
    }
    if($length_of_work!==''){ 
            $data2.=',"LengthOfWork":"'.$length_of_work.'"';
    }
    if($num_duplicate!==''&&$num_duplicate>0){ 
            $data2.=',"IsDuplicate":"T"';
    }
    if($num_duplicate!==''&&$num_duplicate>0){ 
            $data2.=',"DuplicateNum":"'.$num_duplicate.'"';
    }
    if($asset_code!==''){ 
            $data2.=',"AssetCode":"'.$asset_code.'"';
    }else{
        $data2.=',"AssetCode":"'.$item_type.'"';
    }
    if($due_date!==''){ 
            $data2.=',"DueDt":"'.$due_date.'"';
    }
    if($os_installment_amt!==''){ 
            $data2.=',"OsInstallmentAmt":"'.$os_installment_amt.'"';
    }
    if($status_call!==''){ 
            $data2.=',"StatusCall":"'.$status_call.'"';
    }
    if($spouse_nik!==''){ 
            $data2.=',"SpouseNIK":"'.$spouse_nik.'"';
    }
    if($spouse_birth_place!==''){ 
            $data2.=',"SpouseBirthPlace":"'.$spouse_birth_place.'"';
    }
    if($guarantor_name!==''){ 
            $data2.=',"GuarantorName":"'.$guarantor_name.'"';
    }
    if($guarantor_nik!==''){ 
            $data2.=',"GuarantorNIK":"'.$guarantor_nik.'"';
    }
    if($guarantor_phone!==''){ 
            $data2.=',"GuarantorMobilePhoneNo":"'.$guarantor_phone.'"';
    }
    if($guarantor_address!==''){ 
            $data2.=',"GuarantorAddr":"'.$guarantor_address.'"';
    }
    if($guarantor_rt!==''){ 
            $data2.=',"GuarantorRt":"'.$guarantor_rt.'"';
    }
    if($guarantor_rw!==''){ 
            $data2.=',"GuarantorRw":"'.$guarantor_rw.'"';
    }
    if($guarantor_provinsi!==''){ 
            $data2.=',"GuarantorProvince":"'.$guarantor_provinsi.'"';
    }
    if($guarantor_kabupaten!==''){ 
            $data2.=',"GuarantorCity":"'.$guarantor_kabupaten.'"';
    }
    if($guarantor_kecamatan!==''){ 
            $data2.=',"GuarantorKecamatan":"'.$guarantor_kecamatan.'"';
    }
    if($guarantor_kelurahan!==''){ 
            $data2.=',"GuarantorKelurahan":"'.$guarantor_kelurahan.'"';
    }
    if($guarantor_zipcode!==''){ 
            $data2.=',"GuarantorZipcode":"'.$guarantor_zipcode.'"';
    }
    if($GuarantorSubZipcode!==''){ 
            $data2.=',"GuarantorSubZipcode":"'.$GuarantorSubZipcode.'"';
    }
    if($guarantor_relation!==''){ 
            $data2.=',"GuarantorRelationship":"'.$guarantor_relation.'"';
    }
    if($customer_model!==''){ 
            $data2.=',"CustModel":"'.$customer_model.'"';
    }
    if($notes_other_vehicle!==''){ 
            $data2.=',"NotesOtherVehicle":"'.$notes_other_vehicle.'"';
    }
    if($notes_phone_alternative!==''){ 
            $data2.=',"NotesMobilePhoneNo":"'.$notes_phone_alternative.'"';
    }         
    if($source_data!==''){ 
            $data2.=',"SourceData":"'.$source_data.'"';
    }           
    if($agrmnt_no!==''){ 
            $data2.=',"AgrmntNo":"'.$agrmnt_no.'"';
    }           
    if($lob!==''){ 
            $data2.=',"Lob":"'.$lob.'"';
    }           
    if($three_ins_type!==''){ 
            $data2.=',"InsuranceType":"'.$three_ins_type.'"';
    }           
    if($three_ph_yang!==''){ 
            $data2.=',"OsInstallmentAmt":"'.$three_ph_yang.'"';
    }

     
    if($is_pre_approval!==''){ 
            $param_approv = 'PRE APPROVAL';
            $data2.=',"IsPreApproval":"'.$is_pre_approval.'"';
    }   
    if($opsi_penanganan!==''){ 
            $data2.=',"OpsiPenanganan":"'.$opsi_penanganan.'"';
    }   
    if($SubStatusCall!==''){ 
            $data2.=',"SubStatusCall":"'.$SubStatusCall.'"';
    }

    $data = '{"TaskId":"'.$task_id.'"'.$data2.'}';


    
    $payload = $data;

    $sqllog->prepare("INSERT INTO cc_respons_log SET
                    type_api            ='API_UPDATE_Data_To_POLO2', 
                    url_api             ='$url', 
                    post_api            ='$payload', 
                    respon_exe          =now()");
    $reslog = mysqli_query($condb,$sqllog);
    $idlog  = mysqli_insert_id($condb);

    
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);

    $resp = json_decode($result, true);
    
    $result = str_replace("[", "", $result);
    $result = str_replace("]", "", $result);
    
    curl_close($ch);



$responseMessage        = $resp[0]['responseMessage'];
$sqllog->prepare("UPDATE cc_respons_log SET
                respon_status       ='$responseMessage', 
                respon_desc         ='$result',  
                respon_time         =now()
                WHERE id='$idlog'");
$reslog = mysqli_query($condb,$sqllog);
sleep(5);
}
$result = '{"responseCode":"00","responseMessage":"SUCCESS","data":"POL000493995"}';


disconnectDB($condb);
?>
