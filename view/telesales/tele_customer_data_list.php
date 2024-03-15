<?php
include_once "../../sysconf/global_func.php";
include "../../sysconf/session.php";
include_once "../../sysconf/db_config.php";
//include "global_func_ticket.php";


$condb = connectDB();
$v_agentid      = get_session("v_agentid");
$v_agentlevel   = get_session("v_agentlevel");
$v_agentname   = get_session("v_agentname");

$iddet 			= $library['iddet'];

$ffolder		= $library['folder'];
$fmenu_link		= $library['menu_link'];
$fdescription	= $library['description'];
$fmenu_id		= $library['menu_id'];
$ficon			= $library['icon'];
$fiddet			= $library['iddet'];
$fblist			= $library['blist'];

$v 				= get_param("v");

$fmenu_link_back = "tele_customer_data_list";

    	
$blist 			= $library['blist'];
$strblist       = explode(";", $blist); 
$blist_date		= $strblist[0];
$blist_fcount	= $strblist[1];
$blist_csearch0	= $strblist[2];
$blist_tsearch0	= $strblist[3];
$blist_csearch1	= $strblist[4];
$blist_tsearch1	= $strblist[5];
$blist_csearch2	= $strblist[6];
$blist_tsearch2	= $strblist[7];
$blist_csearch3	= $strblist[8];
$blist_tsearch3	= $strblist[9];
$blist_csearch4	= $strblist[10];
$blist_tsearch4	= $strblist[11];


$form_id            = date("Ymdhis").$v_agentid."0";

//file save data
$save_form = "view/telesales/tele_customer_data_new_save.php";
$save_form2= "view/telesales/tele_customer_data_new_save2.php";


$wsql  = "AND a.assign_to = '".$v_agentid."'  AND a.call_status =0 AND a.status < 3 ORDER BY ISNULL(a.priority) ASC, a.priority=0, a.priority  ASC LIMIT 1";

$mode   = get_param("mode");
$param  = get_param("param");

$whereIs = "";
if ($param!='') {
	$iddet=$param;
} 
if(isset($_GET['param'])){
	$whereIs = " AND a.is_eligible_crm=1 AND a.is_process=1 ";
}

if ($mode=="es") {
	// $iddet = "379211"; //diganti ganti aja!
	$iddet = "104809"; //diganti ganti aja!
	$wsql  = " AND a.id='$iddet'";
}

if ($iddet!="") {
	$wsql  = " AND a.id='$iddet'";
}
$iddet = "102964";
if($iddet!=''){
		$txt_campaign_name			= "";
		$txt_customer_name			= "";	
		$txt_customer_no			= "";
		$txt_sumber_data			= "";
		$txt_id_no					= "";
		$txt_mobile_no1				= "";
		$txt_birth_place			= "";	
		$txt_mobile_phone2			= "";
		$txt_birth_date				= "";
		$txt_phone1					= "";
		$txt_religion				= "";
		$txt_phone2					= "";
		$txt_spouse_name			= "";
		$txt_spouse_phone			= "";
		$txt_spouse_nik				= "";
		$txt_spouse_birthdate		= "";
		$txt_spouse_birthplace		= "";
		$txt_guarantor_name			= "";
		$txt_guarantor_phone		= "";
		$txt_guarantor_prov			= "";
		$txt_guarantor_zip			= "";
		$txt_guarantor_nik			= "";
		$txt_guarantor_addr			= "";
		$txt_guarantor_kab			= "";
		$txt_guarantor_relation		= "";
		$txt_guarantor_bod			= "";
		$txt_guarantor_phone1		= "";
		$txt_guarantor_religion		= "";
		$txt_guarantor_phone2		= "";
		$txt_legal_address			= "";
		$txt_legal_kab				= "";
		$txt_legal_zipcode			= "";
		$txt_legal_rt				= "";
		$txt_legal_kec				= "";
		$txt_legal_sub_zipcode		= "";
		$txt_legal_rw				= "";
		$txt_legal_kelurahan		= "";
		$txt_legal_prov				= "";
		$txt_survey_addr			= "";
		$txt_survey_kab				= "";
		$txt_survey_subzipcode		= "";
		$txt_survey_rt				= "";
		$txt_survey_kec				= "";
		$txt_survey_houseowner		= "";
		$txt_survey_rw				= "";
		$txt_survey_kelurahan		= "";
		$txt_survey_domicile		= "";
		$txt_survey_prov			= "";
		$txt_survey_zipcode			= "";
		$txt_job_profname			= "";
		$txt_job_work				= "";
		$txt_job_modelname			= "";
		$txt_job_penghasilan		= "";
		$txt_job_industryname		= "";
		$txt_job_phone1				= "";
		$txt_job_position			= "";
		$txt_job_phone2				= "";
		$txt_other_type				= "";
		$txt_other_alternativephone	= "";
		$txt_other_visitnote		= "";
		$txt_task_id				= "";
		$txt_asset_type             = "";
		$txt_IS_PRE_APPROVAL        = "";
 
	$sqldet = "SELECT a.id,a.AGRMNT_ID,
					a.campaign_id, b.campaign_name, a.task_id,
					a.customer_id,
					a.customer_id_ro,
					a.customer_name,
					a.cabang_code,
					a.total_dial,
					a.source_data,
					a.contact_no, 
					a.tempat_lahir,
					a.tanggal_lahir, 
					a.religion, 
					a.mobile_1,
					a.mobile_2, 
					a.phone_1, 
					a.phone_2, 
					a.spouse_name, 
					a.spouse_nik,
					a.spouse_birth_date,
					a.spouse_birth_place,
					a.spouse_phone,
					a.spouse_mobile_phone,
					a.guarantor_name, 
					a.guarantor_nik, 
					a.guarantor_birth_date,
					a.guarantor_religion,
					a.guarantor_phone,
					a.guarantor_address, 
					a.guarantor_phone1,
					a.guarantor_phone2,
					a.guarantor_provinsi,
					a.guarantor_kabupaten,
					a.guarantor_zipcode,
					a.guarantor_relation,
					a.guarantor_mobile_phone,
					a.legal_alamat,
					a.legal_rt,
					a.legal_rw, 
					a.legal_provinsi,
					a.legal_kabupaten,
					a.legal_kecamatan, 
					a.legal_kelurahan, 
					a.legal_kodepos, 
					a.legal_sub_kodepos,
					a.survey_alamat,
					a.survey_rt,
					a.survey_rw,
					a.survey_provinsi, 
					a.survey_kabupaten,
					a.survey_kecamatan, 
					a.survey_kelurahan,
					a.survey_kodepos,
					a.survey_sub_kodepos, 
					a.ownership, 
					a.length_of_domicile,
					a.profession_name, 
					a.customer_model,
					a.industry_type_name,
					a.job_position,
					a.length_of_work, 
					a.monthly_income,
					a.job_phone_1,
					a.job_phone_2,
					a.other_asset, 
					a.alternative_phone_no,
					a.visit_notes, a.nik_ktp,
                    a.guarantor_rt,
                    a.guarantor_rw, 
                    a.guarantor_kelurahan,
                    a.guarantor_kecamatan,
                    a.guarantor_birth_place,
                    a.tanggal_lahir_pasangan,
                    a.house_ownership,
                    a.item_year,
                    a.otr_price,
                    a.asset_usage,
                    a.tenor,
                    a.asset_type,
                    a.lob,
                    a.agrmnt_no,
                    a.customer_rating,
                    a.item_type,
                    a.marital_status,
                    a.house_stay_length,
                    a.profession_cat_name,
                    a.kepemilikan_rumah,
                    a.product_offering_code,
                    a.IS_PRE_APPROVAL
				FROM 
					cc_ts_penawaran a,
					cc_ts_penawaran_campaign b
				WHERE 
					a.campaign_id=b.id
					AND a.back_flag=1 $whereIs
					$wsql";//]]echo "string2 $sqldet";
					if ($mode=="es") {
						echo "string $sqldet";
					}
	$resdet = mysqli_query($condb,$sqldet);
	if($recdet = mysqli_fetch_array($resdet)){
		$iddet			            = $recdet['id'];
		$agrmntid			        = $recdet['AGRMNT_ID'];
		$txt_campaign_name			= $recdet['campaign_name'];
		$txt_customer_name			= $recdet['customer_name'];
		$txt_total_dial			    = $recdet['total_dial'];	
		$txt_customer_no			= $recdet['customer_id'];	
		$txt_customer_no2			= $recdet['customer_id'];
		$customer_id_ro			    = $recdet['customer_id_ro'];
		if ($customer_id_ro!='') {
			$txt_customer_no2 = $customer_id_ro;
		}
		$txt_sumber_data			= $recdet['source_data'];
		$txt_contact_no				= $recdet['contact_no'];
		$txt_id_no					= $recdet['nik_ktp'];
		$txt_mobile_no1				= $recdet['mobile_1'];
		$txt_birth_place			= $recdet['tempat_lahir'];	
		$txt_mobile_phone2			= $recdet['mobile_2'];
		$txt_birth_date				= $recdet['tanggal_lahir'];
		$txt_phone1					= $recdet['phone_1'];
		$txt_religion				= $recdet['religion'];
		$txt_phone2					= $recdet['phone_2'];
		$txt_spouse_name			= $recdet['spouse_name'];
		$txt_spouse_phone			= $recdet['spouse_phone'];
		$txt_spouse_mobile_phone		= $recdet['spouse_mobile_phone'];
		$txt_spouse_nik				= $recdet['spouse_nik'];
		$txt_spouse_birthdate		= $recdet['spouse_birth_date'];
		if ($txt_spouse_birthdate=='') {
			$txt_spouse_birthdate		= $recdet['tanggal_lahir_pasangan'];
		}
		// if($mode=="es"){ echo $txt_spouse_birthdate; }
		if($txt_spouse_birthdate != "0000-00-00 00:00:00" && $txt_spouse_birthdate != ""){
			$txt_spouse_birthdate 	= date("Y-m-d", strtotime($txt_spouse_birthdate));	
		}
		// if($mode=="es"){ echo $txt_spouse_birthdate; }
		$txt_spouse_birthplace		= $recdet['spouse_birth_place'];
		$txt_guarantor_name			= $recdet['guarantor_name'];
		$txt_guarantor_phone		= $recdet['guarantor_phone'];
		$txt_guarantor_prov			= $recdet['guarantor_provinsi'];
		$txt_guarantor_zip			= $recdet['guarantor_zipcode'];
		$txt_guarantor_nik			= $recdet['guarantor_nik'];
		$txt_guarantor_addr			= $recdet['guarantor_address'];
		$txt_guarantor_kab			= $recdet['guarantor_kabupaten'];
		$txt_guarantor_relation		= $recdet['guarantor_relation'];
		$txt_guarantor_bod			= $recdet['guarantor_birth_date'];
		$txt_guarantor_phone1		= $recdet['guarantor_phone1'];
		$txt_guarantor_religion		= $recdet['guarantor_religion'];
		$txt_guarantor_phone2		= $recdet['guarantor_phone2'];
		$txt_guarantor_mobile_phone		= $recdet['guarantor_mobile_phone'];

        $txt_guarantor_bod_place    = $recdet['guarantor_birth_place'];
        $txt_guarantor_rt           = $recdet['guarantor_rt'];
        $txt_guarantor_rw           = $recdet['guarantor_rw'];
        $txt_guarantor_kelurahan    = $recdet['guarantor_kelurahan'];    
        $txt_guarantor_kecamatan    = $recdet['guarantor_kecamatan'];


		$txt_legal_address			= $recdet['legal_alamat'];
		$txt_legal_kab				= $recdet['legal_kabupaten'];
		$txt_legal_zipcode			= $recdet['legal_kodepos'];
		$txt_legal_rt				= $recdet['legal_rt'];
		$txt_legal_kec				= $recdet['legal_kecamatan'];
		$txt_legal_sub_zipcode		= $recdet['legal_sub_kodepos'];
		$txt_legal_rw				= $recdet['legal_rw'];
		$txt_legal_kelurahan		= $recdet['legal_kelurahan'];
		$txt_legal_prov				= $recdet['legal_provinsi'];
		$txt_survey_addr			= $recdet['survey_alamat'];
		$txt_survey_kab				= $recdet['survey_kabupaten'];
		$txt_survey_subzipcode		= $recdet['survey_sub_kodepos'];
		$txt_survey_rt				= $recdet['survey_rt'];
		$txt_survey_kec				= $recdet['survey_kecamatan'];
		// $txt_survey_houseowner		= $recdet['ownership'];
		// if ($txt_survey_houseowner=='') {
		// 	$txt_survey_houseowner		= $recdet['house_ownership'];
		// }
		$txt_survey_houseowner		= $recdet['house_ownership'];
		$txt_survey_houseowner		= $recdet['kepemilikan_rumah'];
		// if($mode=="es"){ echo $txt_survey_houseowner; }
		$txt_survey_rw				= $recdet['survey_rw'];
		$txt_survey_kelurahan		= $recdet['survey_kelurahan'];
		$txt_survey_domicile		= $recdet['length_of_domicile'];
		$txt_survey_domicile		= $recdet['house_stay_length'];
		$txt_survey_prov			= $recdet['survey_provinsi'];
		$txt_survey_zipcode			= $recdet['survey_kodepos'];
		$txt_job_profname			= $recdet['profession_name'];
		$txt_job_work				= $recdet['length_of_work'];
		$txt_job_modelname			= $recdet['customer_model'];
		$txt_job_modelname			= $recdet['profession_cat_name'];
		$txt_job_penghasilan		= $recdet['monthly_income'];
		$txt_job_industryname		= $recdet['industry_type_name'];
		$txt_job_phone1				= $recdet['job_phone_1'];
		$txt_job_position			= $recdet['job_position'];
		$txt_job_phone2				= $recdet['job_phone_2'];
		$txt_other_type				= $recdet['other_asset'];
		$txt_other_alternativephone	= $recdet['alternative_phone_no'];
		$txt_other_visitnote		= $recdet['visit_notes'];
		$txt_task_id				= $recdet['task_id'];
		$product_offering_code		= $recdet['product_offering_code'];
		$three_mfr_year             = $recdet['item_year'];
		$three_otr                  = $recdet['otr_price'];
		$three_asset_usage          = $recdet['asset_usage'];
		$item_type2			        = $recdet['item_type'];
		$three_tenor                = $recdet['tenor'];
		$txt_asset_type             = $recdet['asset_type'];
		$lob                        = $recdet['lob'];
		$cust_rating                = $recdet['customer_rating'];
		$agrmnt_no2                 = $recdet['agrmnt_no'];
		$marital_status             = $recdet['marital_status'];
		$txt_task_id2               = $txt_task_id;
		$txt_IS_PRE_APPROVAL		= $recdet['IS_PRE_APPROVAL'];
		if ($txt_task_id=="") {
			$txt_task_id2 = $agrmnt_no2;
		}

		$selecteddefaultmar = "";
		$selectedmar 		= "";
		$selectedsin 		= "";
		$selectedwid 		= "";
		if($mode=="es"){ echo "marital ".$marital_status;
			echo "</br>Lenght Of Domicilie: $txt_survey_domicile || $txt_survey_houseowner </br></br>";
		}
		$readonly_spouse="";
		if ($marital_status=='MAR' || $marital_status=='MENIKAH') {
			$selectedmar = "selected";
			$readonly_spouse="readonly";

		}else if ($marital_status=='SIN' || $marital_status=='SINGLE') {
			$selectedsin = "selected";
		}else if ($marital_status=='WID' || $marital_status=='DUDA/JANDA') {
			$selectedwid = "selected";
		}else{
			$selecteddefaultmar = "selected";
		}
		
		if ($marital_status=='MAR') {
			$marital_status='MENIKAH';
		}else if ($marital_status=='SIN') {
			$marital_status='SINGLE';
		}else if ($marital_status=='WID') {
			$marital_status='DUDA/JANDA';
		}

		$cabang_code             = $recdet['cabang_code'];

	}
	$paramdate=0;
	$sqljob = "SELECT a.* FROM cc_ts_simulasi a WHERE a.id_cust_detail='$iddet' ORDER BY a.id DESC LIMIT 1";
	$resjob = mysqli_query($condb,$sqljob);
	// if($mode=="es"){ echo "string2 ".$sqljob; }
	if($recjob = mysqli_fetch_array($resjob)){
		$sla_date = $recjob['sla_date'];
		$sqljob2 = "SELECT a.parm_value FROM cc_parameter_sla a WHERE a.id = 3";
		$resjob2 = mysqli_query($condb,$sqljob2);
		if($recjob2 = mysqli_fetch_array($resjob2)){
			$parm_value = $recjob2['parm_value'];
		}
		// $parm_value = 2;
		$sla_date2   = strtotime($sla_date);
		$param_date = date("Y-m-d", strtotime("+$parm_value day", $sla_date2));
		$sla_date   = $param_date;
		$date_sekarang = date('Y-m-d');
		// $param_date='2019-02-28 17:03:35';
		if($date_sekarang < $sla_date){
			$paramdate=1;
		}

		$three_or_office 		= $recjob["three_or_office"]; 
		$three_admin_fee 		= $recjob["three_admin_fee"];
		$three_add_adminfee 	= $recjob["three_add_adminfee"];
		$three_ltv_maks 		= $recjob["three_ltv_maks"];
		$three_ltv_yang 		= $recjob["three_ltv_yang"];
		$three_biaya_pro 		= $recjob["three_biaya_pro"];
		$three_ph_maks	 		= $recjob["three_ph_maks"];
		$three_ph_yang 			= $recjob["three_ph_yang"];
		$three_ins_type 		= $recjob["three_ins_type"];
		$three_self_ins 		= $recjob["three_self_ins"];
		$three_calcu_budget 	= $recjob["three_calcu_budget"];
		$three_budget_plan		= $recjob["three_budget_plan"];
	}

	$sqljob = "SELECT a.* FROM cc_master_job_pos a WHERE a.master_code='$txt_job_position'";
	$resjob = mysqli_query($condb,$sqljob);
	if($recjob = mysqli_fetch_array($resjob)){
		$txt_job_position = $recjob['desc'];
	}

	$param_pro_offering="0";
	if ($product_offering_code!='') {
		$sqlpot = "SELECT a.id, a.prod_offering_code, a.prod_offering_name FROM cc_prod_offering a
			 WHERE a.prod_offering_code='$product_offering_code'
			 GROUP BY a.prod_offering_code";
		$respot = mysqli_query($condb,$sqlpot);
		if($recpot = mysqli_fetch_array($respot)){
			$prod_offering_name2 	= $recpot['prod_offering_name'];
		}
		if (strpos($prod_offering_name2, 'SPESIAL CASH') || strpos($prod_offering_name2, 'SPECIAL CASH')) { 
		    $param_pro_offering="1";
		}else{
		   $param_pro_offering="0";
		}
	}

	if ($txt_religion!='') {
		$sqlreligion = "SELECT a.religion_name FROM cc_master_religion a WHERE a.religion_code='$txt_religion'";
		$resreligion = mysqli_query($condb,$sqlreligion);
		if($recreligion = mysqli_fetch_array($resreligion)){
			// $txt_religion 	= $recreligion['religion_name'];
		}
	}
	$tot_asset=0;
	if ($txt_asset_type!='') {
		$sqlreligion = "SELECT count(a.id) AS tot_asset FROM cc_ts_penawaran_add_assets a WHERE a.task_id='$txt_task_id'";
		$resreligion = mysqli_query($condb,$sqlreligion);
		if($recreligion = mysqli_fetch_array($resreligion)){
			$tot_asset 	= $recreligion['tot_asset'];
		}

		if ($tot_asset==0) {
			$sql_str12 = "SELECT asset_type_id, asset_type_code, asset_type_name FROM cc_master_type_asset ";
			$sql_res12 = mysqli_query($condb,$sql_str12);
			while($sql_rec12 = mysqli_fetch_array($sql_res12)) {
			    $array_atype_codeid[$sql_rec12["asset_type_id"]]   = $sql_rec12["asset_type_code"];
			    $array_atype_nameid[$sql_rec12["asset_type_code"]]   = $sql_rec12["asset_type_name"];
			}
			freeResSQL($sql_res12);

			$sqlassa = "SELECT 

			            a.*
			          FROM 
			            cc_ts_penawaran a 
			          WHERE 
			            a.task_id='$txt_task_id'";
			 $resassa = mysqli_query($condb,$sqlassa);
			 $no=1;
			 if($recassa = mysqli_fetch_array($resassa)){
			    $ass_id_tel_add_assets2      = $recassa['id'];
			    $task_id2                    = $recassa['task_id'];
			    $assets_type2                = $recassa['asset_type'];
			    $ass_assets_name2            = $array_atype_nameid[$recassa['asset_type']];
			    $ass_assets_type_desc2       = $recassa['asset_type_desc'];
			    $ass_assets_desc2            = $recassa['asset_desc'];
			    $ass_engine_no2              = $recassa['no_mesin'];
			    $ass_license_plate2          = $recassa['license_plate_no'];
			    $ass_chasis_no2              = $recassa['no_rangka'];
			    $ass_manufacturing_year2     = $recassa['item_year'];
			    $ass_asset_ownership2        = $recassa['kepemilikan_bpkb'];
			    $ass_product_offering2       = $recassa['product_offering_code'];
			    $ass_asset_price2            = $recassa['otr_price'];
			    $ass_platfond_max2           = $recassa['plafond'];
			    $ass_tenor2                  = $recassa['tenor'];
			    $ass_ltv2                    = $recassa['ltv'];
			    $ass_instalment2             = $recassa['monthly_instalment'];
			    $ass_ltv_persen2             = $recassa['dp_pct'];
			    $item_type                   = $recassa['item_type'];

			    $sel[$ass_tenor]   = " selected";
			 } 



			$sql_str1 = "SELECT
						b.asset_type_code, #asset_type
						b.asset_type_name, #asset_type
						a.asset_hierarchy_l1_code, 
						a.asset_hierarchy_l1_name,
						c.asset_code , c.asset_name,
						d.asset_category_code, 
						d.asset_category_name,
						e.asset_hierarchy_l2_code,
						e.asset_hierarchy_l2_name 
						FROM cc_master_merk a 
						join cc_master_type_asset b on a.asset_type_id = b.asset_type_id 
						join cc_master_kendaraan c on c.asset_hierarchy_l1_id = a.asset_hierarchy_l1_id 
						join cc_master_kategori_kendaraan d on c.asset_category_id = d.asset_category_id 
						join cc_master_merk_group e on e.asset_hierarchy_l2_id = c.asset_hierarchy_l2_id 
						where c.ASSET_CODE ='$item_type' ";
			$sql_res1 = mysqli_query($condb,$sql_str1);
			while($sql_rec1 = mysqli_fetch_array($sql_res1)) {
			    $asset_kendaraan      = $sql_rec1["asset_code"]." - ".$sql_rec1["asset_name"];
			    $model_kendaraan      = $sql_rec1["asset_hierarchy_l2_code"]." - ".$sql_rec1["asset_hierarchy_l2_name"];
			    $kategori_kendaraan   = $sql_rec1["asset_category_code"]." - ".$sql_rec1["asset_category_name"];
			    $param_asset_code     = $sql_rec1["asset_hierarchy_l1_code"];
			}
			freeResSQL($sql_res1);


			$sql2 = "INSERT INTO cc_ts_penawaran_add_assets SET
                id_penawaran            ='$ass_id_tel_add_assets2',
                task_id                 ='$task_id2',
                assets_type             = '$assets_type2',
                assets_name             = '$model_kendaraan',
                assets_type_desc        = '$param_asset_code',
                assets_desc             = '$item_type',
                kategori_asset          = '$kategori_kendaraan',
                engine_no               = '$ass_engine_no2',
                license_plate           = '$ass_license_plate2',
                chasis_no               = '$ass_chasis_no2',
                manufacturing_year      = '$ass_manufacturing_year2',
                asset_ownership         = '$ass_asset_ownership2',
                product_offering        = '$ass_product_offering2',
                asset_price             = '$ass_asset_price2',
                platfond_max            = '$ass_platfond_max2',
                tenor                   = '$ass_tenor2',
                ltv                     = '$ass_ltv2',
                instalment              = '$ass_instalment2',
                ltv_persen              = '$ass_ltv_persen2',
                create_by               ='$v_agentid',
                create_time             =now()"; //echo $sql2;
    		mysqli_query($condb, $sql2);
    		$tot_asset=$tot_asset+1;
    	}
	}else{
		$sqlreligion = "SELECT count(a.id) AS tot_asset FROM cc_ts_penawaran_add_assets a WHERE a.task_id='$txt_task_id'";
		$resreligion = mysqli_query($condb,$sqlreligion);
		if($recreligion = mysqli_fetch_array($resreligion)){
			$tot_asset 	= $recreligion['tot_asset'];
		}
	}

	$phonecall = "";
	if($txt_mobile_no1!=''){
		$phonecall  .= "<option value='$txt_mobile_no1'>".$txt_mobile_no1." - Cust Mobile 1</option>";
	}
	if($txt_mobile_phone2!=''){
		$phonecall  .= "<option value='$txt_mobile_phone2'>".$txt_mobile_phone2." - Cust Mobile 2</option>";
	}
	if($txt_phone1!=''){
		$phonecall  .= "<option value='$txt_phone1'>".$txt_phone1." - Cust Phone 1</option>";
	}
	if($txt_phone2!=''){
		$phonecall  .= "<option value='$txt_phone2'>".$txt_phone2." - Cust Phone 2</option>";
	}
	if($txt_spouse_phone!=''){
		$phonecall  .= "<option value='$txt_spouse_phone'>".$txt_spouse_phone." - Spouse Phone</option>";
	}
	if($txt_guarantor_phone!=''){
		$phonecall  .= "<option value='$txt_guarantor_phone'>".$txt_guarantor_phone." - Guarantor Phone</option>";
	}
	if($txt_guarantor_phone1!=''){
		$phonecall  .= "<option value='$txt_guarantor_phone1'>".$txt_guarantor_phone1." - Guarantor Phone 1</option>";
	}
	if($txt_guarantor_phone2!=''){
		$phonecall  .= "<option value='$txt_guarantor_phone2'>".$txt_guarantor_phone2." - Guarantor Phone 2</option>";
	}
	if($txt_job_phone1!=''){
		$phonecall  .= "<option value='$txt_job_phone1'>".$txt_job_phone1." - Job Phone 1</option>";
	}
	if($txt_job_phone2!=''){
		$phonecall  .= "<option value='$txt_job_phone2'>".$txt_job_phone2." - Job Phone 2</option>";
	}

	//add phone 
	$add_phone = "";
	$add_desc  = "";
	$sqlaphone = "SELECT a.add_phone, a.add_desc FROM cc_ts_penawaran_add_phone a WHERE a.id_penawaran='$iddet' AND a.task_id='$txt_task_id'";
	$resaphone = mysqli_query($condb,$sqlaphone);
	while($recaphone = mysqli_fetch_array($resaphone)){
		$add_phone 	= $recaphone['add_phone'];
		$add_desc	= $recaphone['add_desc'];

		if($add_phone!=''){
			$phonecall  .= "<option value='$add_phone'>".$add_phone." - ".$add_desc." [add phone]</option>";
		}
		
	}

	// start get master data for option
	$sql_province = "SELECT province_name FROM cc_province WHERE status = 1";
	$res_province = mysqli_query($condb, $sql_province);

	// religion
	$sql_religion = "SELECT religion_code,religion_name FROM cc_master_religion";
	$res_religion = mysqli_query($condb, $sql_religion);

	// start kabupaten
	$sql_kabupaten = "SELECT * FROM cc_master_alamat WHERE is_active=1 GROUP BY city";
	$res_kabupaten = mysqli_query($condb, $sql_kabupaten);

	// if guarantor province != "";
	$txt_guarantor_prov != ""?$provinsi = $txt_guarantor_prov: $provinsi = "";
	$sql_guarantor_kab = get_kabupaten($condb, $provinsi);
	$res_guarantor_kabupaten = mysqli_query($condb, $sql_guarantor_kab);
	
	// if legal province != "";
	$txt_legal_prov != ""?$provinsi = $txt_legal_prov: $provinsi = "";
	$sql_legal_kab = get_kabupaten($condb, $provinsi);
	$res_legal_kabupaten = mysqli_query($condb, $sql_legal_kab);

	// if survey province != "";
	$txt_survey_prov != ""?$provinsi = $txt_survey_prov: $provinsi = "";
	$sql_survey_kab = get_kabupaten($condb, $provinsi);
	$res_survey_kabupaten = mysqli_query($condb, $sql_survey_kab);

	// end kabupaten

	// relation
	$sql_relation = "SELECT descr, master_code FROM cc_master_relation WHERE is_active=1";
	$res_relation = mysqli_query($condb, $sql_relation);

	// ownership
	$sql_ownership = "SELECT master_code,descr FROM cc_master_house_ownership WHERE is_active=1";
	$res_ownership = mysqli_query($condb, $sql_ownership);

	// model customer
	$sql_cust_model = "SELECT cust_model_name FROM cc_master_customer_model";
	$res_cust_model = mysqli_query($condb, $sql_cust_model);

	// industry type
	$sql_industry_type = "SELECT industry_type_name FROM cc_master_industry_type WHERE is_active=1";
	$res_industry_type = mysqli_query($condb, $sql_industry_type);

	// profession
	$sql_profession = "SELECT * FROM cc_master_profession";
	$res_profession = mysqli_query($condb, $sql_profession);


	
	// end get master data
}


function get_kabupaten($conDB, $prov){
	if($provinsi != ""){
		$sql0 = "SELECT b.ref_name AS dis, b.ref_prov_district_id as id, b.ref_name
				FROM 
				cc_master_ref_prov_district a
				JOIN cc_master_ref_prov_district b ON b.parent_id=a.ref_prov_district_id AND b.is_active=1 AND b.ref_type='DIS'
				WHERE 1=1 
				AND a.ref_name='$provinsi'
				GROUP BY a.ref_name, b.ref_prov_district_id
				ORDER BY b.ref_name";
		$res0 = mysqli_query($conDB, $sql0);
		$arr0 = mysqli_fetch_all($res0);
		$iddes0 =  implode(',', array_map(function ($entry) {
		                        return $entry[1];
		                      }
		                    , $arr0 ));
		mysqli_free_result($res0);

		// print_r($iddes);
		$sql = "SELECT a.city as city
				FROM cc_master_alamat a 
				WHERE a.ref_prov_district_id IN ($iddes0) AND a.is_active=1 GROUP BY a.city ORDER BY a.city ASC";
		// if($mode == "es"){ echo $sql_legal_kab."<br><br>"; }
		return $sql;
	}else{
		$sql_kabupaten = "SELECT * FROM cc_master_alamat WHERE is_active=1 GROUP BY city";
		return $sql_kabupaten;
	}
}

?>
<style>
.table-wrapper {
   max-height: 300px;
   overflow: auto;
   display:inline-block; 
}
.table-earnings {
  background: #F3F5F6; 
}

.swal-duplicate .swal-title {
	font-size: 18px;
	width: 80%;
	text-align: center;
	margin: 0 auto;
	padding: 6px 16px 13px 16px;
}
.swal-duplicate .swal-text {
	max-height: 6em;  /* To be adjusted as you like */
	overflow-y: scroll;
	width: 80%;
}

.swal-duplicate .swal-button-container .swal-button--cancel {  
	background: #1572e8 !important;
    border-color: #1572e8 !important;
	color: #ffffff;
}
.swal-duplicate .swal-button-container .swal-button--cancel:hover {
   background-color: #2B7FEA !important;
   border-color: #2B7FEA !important;
   color: #ffffff;
}
</style>
<div class="page-inner">
	<?php if($typecreate==''){ ?>
	<div class="page-header"  style="margin-bottom:0px;margin-top:-15px;padding-left:0px;padding:0px;margin-left:-20px;">
		<ul class="breadcrumbs" style="border-left:0px;margin:0px;">
			<li class="nav-home">
				<a href="index.php">
					<i class="fas fa-home"></i>
				</a>
			</li>
			<li class="separator">
				<i class="fas fa-chevron-right"></i>
			</li>
			<?php
				$menu_tree = explode("|", $library['page']);
				for ($i=0; $i <count($menu_tree) ; $i++) { 
					if ($i != 0) {
						echo "<li class=\"separator\"><i class=\"fas fa-chevron-right\"></i></li>";
					}
					echo "<li class=\"nav-item\">".$menu_tree[$i]."</li>";;
				}
				echo "<li class=\"separator\"><i class=\"fas fa-chevron-right\"></i></li>";
				echo "<li class=\"nav-item\">".$desc_iddet."</li>";;				
			?>
		</ul>
	</div>


	<div style="height:100%;top:0px;left:0px;position: fixed;z-index: 999999;text-align: center;width:100%;display: none" id="tempatLoading">
	 <div style="width:400px;margin:auto;margin-top:200px;padding:10px;">
	 	 <img src="assets/img/elyphsoft.gif" width="140px" style="border: 0px;border-radius: 4px;padding: 1px;border-radius:150px">
	  	<h1 style="font-weight:bold;color: white; text-shadow: -2px -2px 0 <?php echo $dominant_mastercolor_darker ?>, 2px -2px 0 <?php echo $dominant_mastercolor_darker ?>, -2px 2px 0 <?php echo $dominant_mastercolor_darker ?>, 2px 2px 0 <?php echo $dominant_mastercolor_darker ?>;">Please Wait</h1>
	  	<h2 style="font-weight:bold;color: white; text-shadow: -2px -2px 0 <?php echo $dominant_mastercolor_darker ?>, 2px -2px 0 <?php echo $dominant_mastercolor_darker ?>, -2px 2px 0 <?php echo $dominant_mastercolor_darker ?>, 2px 2px 0 <?php echo $dominant_mastercolor_darker ?>;">While We're Hit Your Data</h2>
	 </div>
	</div>

	<div style="height:100%;top:0px;left:0px;position: fixed;z-index: 999999;text-align: center;width:100%;display: none" id="tempatDukcapil">
	 <div style="width:400px;margin:auto;margin-top:200px;padding:10px;">
	 	 <img src="assets/img/elyphsoft.gif" width="140px" style="border: 0px;border-radius: 4px;padding: 1px;border-radius:150px">
	  	<h1 style="font-weight:bold;color: white; text-shadow: -2px -2px 0 <?php echo $dominant_mastercolor_darker ?>, 2px -2px 0 <?php echo $dominant_mastercolor_darker ?>, -2px 2px 0 <?php echo $dominant_mastercolor_darker ?>, 2px 2px 0 <?php echo $dominant_mastercolor_darker ?>;">Please Wait</h1>
	  	<h2 style="font-weight:bold;color: white; text-shadow: -2px -2px 0 <?php echo $dominant_mastercolor_darker ?>, 2px -2px 0 <?php echo $dominant_mastercolor_darker ?>, -2px 2px 0 <?php echo $dominant_mastercolor_darker ?>, 2px 2px 0 <?php echo $dominant_mastercolor_darker ?>;">On Progress Check Dukcapil</h2>
	 </div>
	</div>
	<?php 
	}

	
	?>

<style> 
 .form-group{ 
	line-height: 10%;
	/* margin-top:-10px; */
  }
  .card-title{ 
	line-height: 40%;
  }
  .textwhite{
	  color:white;
  }
  #bgblues{
	background-color: #0080ff ;
  }

  input[readonly] {
	background-color: white !important;
  }
</style> 

<?php 
	if($txt_customer_name !="") { 
?>
<form name="frmDataDet" id="frmDataDet" method="POST"><?php $idsec = get_session('idsec'); ?> <input type="hidden" name="idsec" id="idsec" value="<?php echo $idsec;?>">
<input type="hidden" name="iddet" id="iddet" value="<?php echo $iddet;?>">
<input type="hidden" name="agrmntid" id="agrmntid" value="<?php echo $AGRMNT_ID;?>">
<input type="hidden" name="txt_task_id" id="txt_task_id" value="<?php echo $txt_task_id;?>">
<input type="hidden" name="references_id" id="references_id">
<!-- <input type="hidden" name="add_asset_id" id="add_asset_id"> -->
<input type="hidden" name="dialedno" id="dialedno">
<input type="hidden" name="v" id="v" value="<?php echo $v;?>">
<input type="hidden" name="idgrmnt" id="idgrmnt">
<input type="hidden" name="form_id" id="form_id" value="<?php echo $form_id;?>">
<input type="hidden" name="add_asset_id" id="add_asset_id">
<input type="hidden" name="txt_total_dial" id="txt_total_dial" value="<?php echo $txt_total_dial;?>">
<input type="hidden" name="txt_tot_asset" id="txt_tot_asset" value="<?php echo $tot_asset;?>">
<input type="hidden" name="txt_contact_no" id="txt_contact_no" value="<?php echo $txt_contact_no;?>">
<input type="hidden" name="txt_check_agrmnt" id="txt_check_agrmnt" value="0">
<input type="hidden" name="param_check_agrmnt" id="param_check_agrmnt" value="0">
<input type="hidden" name="param" id="param" value="<?php echo $param;?>">
<input type="hidden" name="agrmnt_no" id="agrmnt_no" value="<?php echo $agrmnt_no2;?>">
<input type="hidden" name="cust_rating" id="cust_rating" value="<?php echo $cust_rating;?>">
<input type="hidden" name="param_pro_offering" id="param_pro_offering" value="<?php echo $param_pro_offering;?>">
<input type="hidden" name="param_num_duplicate" id="param_num_duplicate" value="0">
<input type="hidden" name="sla_date" id="sla_date" value="<?php echo $sla_date;?>">
<input type="hidden" name="paramdate" id="paramdate" value="<?php echo $paramdate;?>">
<input type="hidden" name="txt_IS_PRE_APPROVAL" id="txt_IS_PRE_APPROVAL" value="<?php echo $txt_IS_PRE_APPROVAL;?>">

	<div class="row">
		<!-- start table 9 -->
				<div class="col-md-12"><!-- style="margin-top:-25px;" -->
			<div class="card">
				<div class="card-header" id="bgblues">
					<div class="card-title"><b class="textwhite">List Pengajuan</b></div>
				</div>
				<div class="form-group">
					
				</div>
			<!--	<div class="card-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> -->
						<div class="table-wrapper "><div class="table-responsive">
									<table class="table table-head-bg-primary table-earnings" style="width:100%;height:20px;">
										<thead>
											<tr>
												<th style="width:20px">#<!-- <input type="checkbox" id="checkall"/> --></th>
												<th scope="col">No Kontrak</th>
												<th scope="col">Campaign</th>
												<th scope="col">Eligible</th>
												<th scope="col">Pipeline</th>
												<th scope="col">POT</th>
												<th scope="col">Contract Status</th>
												<th scope="col">Asset Type Desc</th>
												<th scope="col">Status</th>
												<th scope="col">Completion Data</th>
												<!-- <th scope="col">Update History</th> -->
												<!-- <th scope="col">Detail</th> -->
											</tr>
										</thead>
										<tbody>
											<?php 
											// $sqlsa = "SELECT a.*,b.campaign_name FROM cc_ts_penawaran a,
											// 		  cc_ts_penawaran_campaign b
											// 		  WHERE a.customer_id='$txt_customer_no'
											// 		  AND a.customer_id!=''
											// 		  AND a.campaign_id=b.id";
											$sql_whr = " a.is_eligible_crm= '1' AND a.is_process='1' AND (a.customer_id='$txt_customer_no' OR a.customer_id_ro='$txt_customer_no') ";
											if ($txt_customer_no=="") {
												// $sql_whr .= " AND (customer_id!='' AND customer_id_ro!='')";
												$sql_whr .= " AND a.id='$iddet'";
											}
											$sqlsa = "SELECT a.*,b.campaign_name,if(a.is_eligible_crm=1,'Eligible','Non Eligible') AS eligible_flag FROM cc_ts_penawaran a,
													  cc_ts_penawaran_campaign b
													  WHERE $sql_whr
													  AND a.campaign_id=b.id";
													  if ($mode=='es') {
													  	echo $sqlsa;
													  }
											 $ressa = mysqli_query($condb,$sqlsa);
											 $no=1;
											 $tot_on=0;
											 $all_agrmt_on=0;
											 while($recsa = mysqli_fetch_array($ressa)){
												$id_agrmnt		    = $recsa['id'];
												$task_id_agrmnt		= $recsa['task_id'];
												$id_penawaran		= $recsa['id_penawaran'];
												$agrmnt_no			= $recsa['agrmnt_no'];
												$campaign_name		= $recsa['campaign_name'];
												$eligible_flag		= $recsa['eligible_flag'];
												$pipeline			= $recsa['pipeline'];
												$pot				= $recsa['product_offering_code'];
												$contract_status	= $recsa['status_kontrak'];
												$asset_desc			= $recsa['item_type'];
												$status_kontrak		= $recsa['status_kontrak'];
												$completion_data	= $recsa['completion_data'];
												$call_status	    = $recsa['call_status'];
												// $ass_angsuran 				= conv_number($ass_angsuran,0);
												// $ass_otr					= conv_number($ass_otr,0);
												// $ass_estimasi_terima_bersih = conv_number($ass_estimasi_terima_bersih,0);
												$disabled ="";
												$checked="";
												if ($call_status>0) {
													$disabled ="disabled";
												}else{
													$tot_on++;
													$all_agrmt_on .=", $id_agrmnt"; 
												}
												
										?>
											<tr data-id="<?php echo $ass_id_tel_add_assets; ?>">
												<!-- <td><?php echo $no;?></td> -->
												<td>
													<input type='radio' id='check_assign' name='check_assign' value='<?php echo $id_agrmnt; ?>' class='row_bulk' <?php echo $disabled;?> onclick=checkBulk()>
												</td>
												<td>
													<?php echo $agrmnt_no;?>
												</td>
												<!-- <td><?php //echo $ass_assets_type;?></td> -->
												<td><?php echo $campaign_name;?></td>
												<td><?php echo $eligible_flag;?></td>
												<td><?php echo $pipeline;?></td>
												<td><?php echo $pot;?></td>
												<td><?php echo $contract_status;?></td>
												<td><?php echo $asset_desc;?></td>
												<td><?php echo $status_kontrak;?></td>
												<td><?php echo $completion_data;?></td>
												<!-- <td>xx</td> -->
												<!-- <td><a href="javascript: return false;" onclick="return det_agrement('<?php echo $id_agrmnt; ?>','<?php echo $task_id_agrmnt; ?>');">View Detail</a></td> -->
											</tr>
										<?php 
											$no++;
											 }
										?>
										</tbody>
									</table>
					</div></div>
					<!--	</div>

					</div>
				</div> -->
			</div>
		</div>
		<!-- end table 9 -->

		<!-- start table 1 -->
		<div class="col-md-12">
			<div class="card">
				<div class="card-header" id="bgblues">
					<div class="card-title"><b class="textwhite">Customer Detail [ <?php echo $txt_task_id2; ?> ]</b></div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-6 col-lg-4">
							<div class="form-group">
								<label for="txtlabel">Campaign Name</label>
								<input type="text" class="form-control form-control-sm" id="txt_campaign_name" name="txt_campaign_name" value="<?php echo $txt_campaign_name; ?>" readonly>
							</div>
							<div class="form-group">
								<label for="txtlabel">Customer Name</label>
								<input type="text" class="form-control form-control-sm" id="txt_customer_name" name="txt_customer_name" value="<?php echo $txt_customer_name; ?>" >
							</div>
						</div>

						<div class="col-md-6 col-lg-4">
							<div class="form-group">
								<label for="txtlabel">Customer No</label>
								<input type="text" class="form-control form-control-sm" id="txt_customer_no"  name="txt_customer_no" value="<?php echo $txt_customer_no2; ?>" readonly>
							</div>
							<div class="form-group">
								<label for="txtlabel">Sumber Data</label>
								<input type="text" class="form-control form-control-sm" id="txt_sumber_data"  name="txt_sumber_data" value="<?php echo $txt_sumber_data; ?>" readonly>
							</div>
						</div>

						<div class="col-md-6 col-lg-4">
							<div class="form-group">
									<div class="input-group mb-3">
											<select name="cmb_phone_no" id="cmb_phone_no" class="form-control form-control-sm">
  												<option value="">Phone Number</option>
												<?php 
													echo $phonecall;
												?>
											</select>
											<div class="input-group-append ">
												<span class="input-group-text btn-xs btn-success" id="btncallcust">&nbsp;&nbsp;<i class="fas fa-phone"></i>&nbsp;&nbsp;</span>
											</div>
										</div>
							</div>
							<div class="form-group">
								<label for="txtlabel">&nbsp;</label>
								<?php 
		$addbtnphone = "<input type='button' name='btn_add_phone_no' id='btn_add_phone_no' class='btn btn-primary btn-sm' value='Add Phone Number' data-toggle='modal' data-backdrop='false' data-target='#addnewphonepop'>";
		echo $addbtnphone;
								?>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
		<!-- end table 1 -->

		<!-- start table 2 -->
		<div class="col-md-12" style="margin-top:-25px;">
			<div class="card">
				<div class="card-header" id="bgblues">
					<div class="card-title"><b class="textwhite">Customer Info</b></div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-6 col-lg-3">
							<div class="form-group">
								<label for="txtlabel">ID No</label>
								<input type="text" maxlength="16" onkeypress="return isNumberKey(event)" class="form-control form-control-sm" id="txt_id_no" name="txt_id_no" value="<?php echo $txt_id_no; ?>">
							</div>
							<div class="form-group">
								<label for="txtlabel">Mobile Phone 1</label>
								<input type="text" class="form-control form-control-sm" onkeypress="return isNumberKey(event)" id="txt_mobile_no1"  name="txt_mobile_no1" value="<?php echo $txt_mobile_no1; ?>">
							</div>
							<div class="form-group">
								<label for="txtlabel">Marital Status</label>
								<select class="form-control form-control-sm" id="marital_status" name="marital_status">
									<option value="" <?php echo $selecteddefaultmar; ?> >Select Marital Status</option>
									<option value="MENIKAH" <?php echo $selectedmar;  ?> >MENIKAH</option>
									<option value="SINGLE" <?php echo $selectedsin; ?> >SINGLE</option>
									<option value="DUDA/JANDA" <?php echo $selectedwid; ?> >DUDA/JANDA</option>
								</select>
								<!-- <input type="text" class="form-control form-control-sm" id="marital_status" name="marital_status" value="<?php echo $marital_status; ?>"> -->
							</div>
						</div>

						<div class="col-md-6 col-lg-3">
							<div class="form-group">
								<label for="txtlabel">Birth Place</label>
								<input type="text" class="form-control form-control-sm" id="txt_birth_place" name="txt_birth_place" value="<?php echo $txt_birth_place; ?>">
							</div>
							<div class="form-group">
								<label for="txtlabel">Mobile Phone 2</label>
								<input type="text" class="form-control form-control-sm" onkeypress="return isNumberKey(event)" id="txt_mobile_phone2" name="txt_mobile_phone2" value="<?php echo $txt_mobile_phone2; ?>">
							</div>
						</div>

						<div class="col-md-6 col-lg-3">
							<div class="form-group">
								<label for="txtlabel">Birth Date</label>
								<input type="input" class="form-control form-control-sm" id="txt_birth_date" name="txt_birth_date" value="<?php echo $txt_birth_date; ?>">
							</div>
							<div class="form-group">
								<label for="txtlabel">Phone 1</label>
								<input type="text" class="form-control form-control-sm" onkeypress="return isNumberKey(event)" id="txt_phone1" name="txt_phone1" value="<?php echo $txt_phone1; ?>">
							</div>
						</div>
						
						<div class="col-md-6 col-lg-3">
							<div class="form-group">
								<label for="txtlabel">Religion</label>
								<!-- <input type="text" class="form-control form-control-sm" id="txt_religion" name="txt_religion" value="<?php echo $txt_religion; ?>"> -->
								<select class="form-control form-control-sm select2" id="txt_religion" name="txt_religion">
									<option value="" selected>Select Religion</option>
								<?php
									while($row = mysqli_fetch_array($res_religion)){
										if ($row['religion_code'] == $txt_religion && $txt_religion != "") {
											echo "<option value='".$row['religion_code']."' selected>".$row['religion_name']."</option>";
										}else{
											echo "<option value='".$row['religion_code']."'>".$row['religion_name']."</option>";
										}
									}
									mysqli_free_result($res_religion);
									mysqli_data_seek($res_kabupaten, 0);

								?>
								</select>
							</div>
							<div class="form-group">
								<label for="txtlabel">Phone 2</label>
								<input type="text" class="form-control form-control-sm" onkeypress="return isNumberKey(event)" id="txt_phone2" name="txt_phone2" value="<?php echo $txt_phone2; ?>">
							</div>
						</div>

				

					</div>
				</div>
			</div>
		</div>
		<!-- end table 2 -->

		<!-- start table 3 -->
		<div class="col-md-12" style="margin-top:-25px;">
			<div class="card">
				<div class="card-header" id="bgblues">
					<div class="card-title"><b class="textwhite">Spouse Info</b></div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-6 col-lg-3">
							<div class="form-group">
								<label for="txtlabel">Spouse Name</label>
								<input type="text" class="form-control form-control-sm" id="txt_spouse_name" name="txt_spouse_name" value="<?php echo $txt_spouse_name; ?>">
							</div>
							<div class="form-group">
								<label for="txtlabel">Spouse Mobile Phone</label>
								<input type="text" class="form-control form-control-sm" onkeypress="return isNumberKey(event)" maxlength="16" id="txt_spouse_mobile_phone" name="txt_spouse_mobile_phone" value="<?php echo $txt_spouse_mobile_phone; ?>">
							</div>
						</div>

						<div class="col-md-6 col-lg-3">
							<div class="form-group">
								<label for="txtlabel">Spouse NIK</label>
								<input type="text" class="form-control form-control-sm" onkeypress="return isNumberKey(event)" maxlength="16" id="txt_spouse_nik" name="txt_spouse_nik" value="<?php echo $txt_spouse_nik; ?>">
							</div>
							<div class="form-group">
								<label for="txtlabel">Spouse Phone</label>
								<input type="text" class="form-control form-control-sm" onkeypress="return isNumberKey(event)" id="txt_spouse_phone"  name="txt_spouse_phone" value="<?php echo $txt_spouse_phone; ?>">
							</div>

						</div>

						<div class="col-md-6 col-lg-3">
							<div class="form-group">
								<label for="txtlabel">Spouse Birth Date</label>
								<input type="input" class="form-control form-control-sm" id="txt_spouse_birthdate" name="txt_spouse_birthdate" value="<?php echo $txt_spouse_birthdate; ?>">
							</div>
						</div>
						
						<div class="col-md-6 col-lg-3">
							<div class="form-group">
								<label for="txtlabel">Spouse Birth Place</label>
								<input type="text" class="form-control form-control-sm" id="txt_spouse_birthplace" name="txt_spouse_birthplace" value="<?php echo $txt_spouse_birthplace; ?>">
							</div>

						</div>

				

					</div>
				</div>
			</div>
		</div>
		<!-- end table 3-->

				<!-- start table 4 -->
				<div class="col-md-12" style="margin-top:-25px;">
			<div class="card">
				<div class="card-header" id="bgblues">
					<div class="card-title"><b class="textwhite">Guarantor Info</b></div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-6 col-lg-3">
							<div class="form-group">
								<label for="txtlabel">Guarantor Name</label>
								<input type="text" class="form-control form-control-sm" id="txt_guarantor_name" name="txt_guarantor_name" value="<?php echo $txt_guarantor_name; ?>">
							</div>
							<div class="form-group">
								<label for="txtlabel">Guarantor Phone</label>
								<input type="text" class="form-control form-control-sm" onkeypress="return isNumberKey(event)" id="txt_guarantor_phone"  name="txt_guarantor_phone" value="<?php echo $txt_guarantor_phone; ?>">
							</div>
							<div class="form-group">
								<label for="txtlabel">Guarantor Mobile Phone</label>
								<input type="text" class="form-control form-control-sm" onkeypress="return isNumberKey(event)" id="txt_guarantor_mobile_phone"  name="txt_guarantor_mobile_phone" value="<?php echo $txt_guarantor_mobile_phone; ?>">
							</div>
							<div class="form-group">
								<label for="txtlabel">Guarantor Province</label>
								<!-- <input type="text" class="form-control form-control-sm" id="txt_guarantor_prov"  name="txt_guarantor_prov" value="<?php echo $txt_guarantor_prov; ?>"> -->
								<select class="form-control form-control-sm select2" id="txt_guarantor_prov"  name="txt_guarantor_prov">
									<option value="" selected="">Select Province</option>
									<?php
										while($row = mysqli_fetch_array($res_province)){
											if (strtolower($row["province_name"]) == strtolower($txt_guarantor_prov)) {
												echo "<option value='".$row["province_name"]."' selected>".$row["province_name"]."</option>";
											}else{
												echo "<option value='".$row["province_name"]."'>".$row["province_name"]."</option>";
											}
										}
										mysqli_data_seek($res_province, 0);
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="txtlabel">Guarantor Kelurahan</label>
								<!-- <input type="text" class="form-control form-control-sm" id="txt_guarantor_kelurahan" name="txt_guarantor_kelurahan" value="<?php echo $txt_guarantor_kelurahan; ?>"> -->
								<select class="form-control form-control-sm select2" id="txt_guarantor_kelurahan" name="txt_guarantor_kelurahan">
									<option value="" selected>Select Kelurahan</option>
									<?php
										if ($txt_guarantor_kecamatan != "") {
											// kelurahan
											$sql_kelurahan = "SELECT * FROM cc_master_alamat WHERE is_active=1 AND kecamatan='$txt_guarantor_kecamatan' AND city = '$txt_guarantor_kab' GROUP BY kelurahan";
											$res_kelurahan = mysqli_query($condb, $sql_kelurahan);
											while($row = mysqli_fetch_array($res_kelurahan)){
												if (strtolower($row["kelurahan"]) == strtolower($txt_guarantor_kelurahan)) {
													echo "<option value='".$row["kelurahan"]."' selected>".$row["kelurahan"]."</option>";
												}else{
													echo "<option value='".$row["kelurahan"]."'>".$row["kelurahan"]."</option>";
												}
											}
											mysqli_free_result($res_kelurahan, 0);
										}
									?>
								</select>
							</div>
						</div> 

						<div class="col-md-6 col-lg-3">
							<div class="form-group">
								<label for="txtlabel">Guarantor NIK</label>
								<input type="text" class="form-control form-control-sm" maxlength="16" onkeypress="return isNumberKey(event)" id="txt_guarantor_nik" name="txt_guarantor_nik" value="<?php echo $txt_guarantor_nik; ?>">
							</div>
							<div class="form-group">
								<label for="txtlabel">Guarantor Address</label>
								<input type="text" class="form-control form-control-sm" id="txt_guarantor_addr" name="txt_guarantor_addr" value="<?php echo $txt_guarantor_addr; ?>">
							</div>
							<div class="form-group">
								<label for="txtlabel">Guarantor Kabupaten</label>
								<!-- <input type="text" class="form-control form-control-sm" id="txt_guarantor_kab" name="txt_guarantor_kab" value="<?php echo $txt_guarantor_kab; ?>"> -->
								<select class="form-control form-control-sm select2" id="txt_guarantor_kab" name="txt_guarantor_kab">
									<option value="" selected>Select Kabupaten</option>
									<?php
										while($row = mysqli_fetch_array($res_guarantor_kabupaten)){
											if (strtolower($row["city"]) == strtolower($txt_guarantor_kab) && $txt_guarantor_kab != "") {
												echo "<option value='".$row["city"]."' selected>".$row["city"]."</option>";
											}else{
												echo "<option value='".$row["city"]."'>".$row["city"]."</option>";
											}
										}
										mysqli_data_seek($res_guarantor_kabupaten, 0);
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="txtlabel">Guarantor ZIP Code</label>
								<!-- <input type="text" class="form-control form-control-sm" id="txt_guarantor_zip"  name="txt_guarantor_zip" value="<?php echo $txt_guarantor_zip; ?>"> -->
								<select class="form-control form-control-sm select2" id="txt_guarantor_zip"  name="txt_guarantor_zip">
									<option value="" selected>Select ZIPCode</option>
									<?php
										if ($txt_guarantor_kelurahan != "") {
											// kecamatan
											$sql_zipcode = "SELECT * FROM cc_master_alamat WHERE is_active=1 AND city = '$txt_guarantor_kab' AND kecamatan = '$txt_guarantor_kecamatan' AND kelurahan = '$txt_guarantor_kelurahan' GROUP BY zipcode";
											$res_zipcode = mysqli_query($condb, $sql_zipcode);
											while($row = mysqli_fetch_array($res_zipcode)){
												if ($row["zipcode"] == $txt_guarantor_zip) {
													echo "<option value='".$row["zipcode"]."' selected>".$row["zipcode"]."</option>";
												}else{
													echo "<option value='".$row["zipcode"]."'>".$row["zipcode"]."</option>";
												}
											}
											mysqli_free_result($res_zipcode, 0);
										}
									?>
								</select>
							</div>
						</div>

						<div class="col-md-6 col-lg-3">
              <div class="form-group">
								<label for="txtlabel">Guarantor RT</label>
								<input type="text" maxlength="3" class="form-control form-control-sm" onkeypress="return isNumberKey(event)" id="txt_guarantor_rt" name="txt_guarantor_rt" value="<?php echo $txt_guarantor_rt; ?>">
							</div>
              <div class="form-group">
								<label for="txtlabel">Guarantor RW</label>
								<input type="text" maxlength="3" class="form-control form-control-sm" onkeypress="return isNumberKey(event)" id="txt_guarantor_rw" name="txt_guarantor_rw" value="<?php echo $txt_guarantor_rw; ?>">
							</div>
              <div class="form-group">
								<label for="txtlabel">Guarantor Kecamatan</label>
								<!-- <input type="text" class="form-control form-control-sm" id="txt_guarantor_kecamatan" name="txt_guarantor_kecamatan" value="<?php echo $txt_guarantor_kecamatan; ?>"> -->
								<select class="form-control form-control-sm select2" id="txt_guarantor_kecamatan" name="txt_guarantor_kecamatan">
									<option value="" selected>Select Kecamatan</option>
									<?php
										if ($txt_guarantor_kab != "") {
											// kecamatan
											$sql_kecamatan = "SELECT * FROM cc_master_alamat WHERE is_active=1 AND city = '$txt_guarantor_kab' GROUP BY kecamatan";
											$res_kecamatan = mysqli_query($condb, $sql_kecamatan);
											while($row = mysqli_fetch_array($res_kecamatan)){
												if (strtolower($row["kecamatan"]) == strtolower($txt_guarantor_kecamatan)) {
													echo "<option value='".$row["kecamatan"]."' selected>".$row["kecamatan"]."</option>";
												}else{
													echo "<option value='".$row["kecamatan"]."'>".$row["kecamatan"]."</option>";
												}
											}
											mysqli_free_result($res_kecamatan, 0);
										}
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="txtlabel">Relation</label>
								<!-- <input type="text" class="form-control form-control-sm" id="txt_guarantor_relation" name="txt_guarantor_relation" value="<?php echo $txt_guarantor_relation; ?>"> -->
								<select class="form-control form-control-sm select2" id="txt_guarantor_relation" name="txt_guarantor_relation">
									<option value="" selected>Select Relation</option>
									<?php
										while($row = mysqli_fetch_array($res_relation)){
											if (strtolower($row['descr']) == strtolower($txt_guarantor_relation) || strtolower($row['master_code']) == strtolower($txt_guarantor_relation)) {
												echo "<option value='".$row['descr']."' selected>".$row['descr']."</option>";
											}else{
												echo "<option value='".$row['descr']."' >".$row['descr']."</option>";
											}
										}
										mysqli_data_seek($res_relation, 0);
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="txtlabel">Birth Date</label>
								<input type="input" class="form-control form-control-sm" id="txt_guarantor_bod" name="txt_guarantor_bod" value="<?php echo $txt_guarantor_bod; ?>">
							</div>
              <div class="form-group">
								<label for="txtlabel">Birth Place</label>
								<input type="text" class="form-control form-control-sm" id="txt_guarantor_bod_place" name="txt_guarantor_bod_place" value="<?php echo $txt_guarantor_bod_place; ?>">
							</div>
							<!-- <div class="form-group">
								<label for="txtlabel">Phone 1</label>
								<input type="text" class="form-control form-control-sm" id="txt_guarantor_phone1" name="txt_guarantor_phone1" value="<?php echo $txt_guarantor_phone1; ?>">
							</div> -->
						</div>
						
						<div class="col-md-6 col-lg-3">
							<!-- <div class="form-group">
								<label for="txtlabel">Religion</label>
								<input type="text" class="form-control form-control-sm" id="txt_guarantor_religion" name="txt_guarantor_religion" value="<?php echo $txt_guarantor_religion; ?>">
							</div> -->
							<!-- <div class="form-group">
								<label for="txtlabel">Phone 2</label>
								<input type="text" class="form-control form-control-sm" id="txt_guarantor_phone2" name="txt_guarantor_phone2" value="<?php echo $txt_guarantor_phone2; ?>">
							</div> -->
						</div>

				

					</div>
				</div>
			</div>
		</div>
		<!-- end table 4 -->

		<!-- start table 5 -->
		<div class="col-md-12" style="margin-top:-25px;">
			<div class="card">
				<div class="card-header" id="bgblues">
					<div class="card-title"><b class="textwhite">Legal Address</b></div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-6 col-lg-3">
							<div class="form-group">
								<label for="txtlabel">Legal Address</label>
								<input type="text" class="form-control form-control-sm" id="txt_legal_address" name="txt_legal_address" value="<?php echo $txt_legal_address; ?>">
							</div>
							<div class="form-group">
								<label for="txtlabel">Legal Kabupaten</label>
								<!-- <input type="text" class="form-control form-control-sm" id="txt_legal_kab"  name="txt_legal_kab" value="<?php echo $txt_legal_kab; ?>"> -->
								<select class="form-control form-control-sm select2" id="txt_legal_kab"  name="txt_legal_kab">
									<option value="" selected>Select Kabupaten</option>
									<?php
										if($res_legal_kab != ""){
											while($row = mysqli_fetch_array($res_legal_kab)){
												if (strtolower($row["city"]) == strtolower($txt_legal_kab) && $txt_legal_kab != "") {
													echo "<option value='".$row["city"]."' selected>".$row["city"]."</option>";
												}else{
													echo "<option value='".$row["city"]."'>".$row["city"]."</option>";
												}
											}
											mysqli_data_seek($res_legal_kab, 0);
										}else{
											while($row = mysqli_fetch_array($res_kabupaten)){
												if (strtolower($row["city"]) == strtolower($txt_legal_kab) && $txt_legal_kab != "") {
													echo "<option value='".$row["city"]."' selected>".$row["city"]."</option>";
												}else{
													echo "<option value='".$row["city"]."'>".$row["city"]."</option>";
												}
											}
											mysqli_data_seek($res_kabupaten, 0);
										}
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="txtlabel">Legal Zip Code</label>
								<!-- <input type="text" class="form-control form-control-sm" id="txt_legal_zipcode"  name="txt_legal_zipcode" value="<?php echo $txt_legal_zipcode; ?>"> -->
								<select class="form-control form-control-sm select2" id="txt_legal_zipcode"  name="txt_legal_zipcode">
									<option value="" selected>Select ZIPCode</option>
									<?php
										if ($txt_legal_kelurahan != "") {
											// kecamatan
											$sql_zipcode = "SELECT * FROM cc_master_alamat WHERE is_active=1 AND city = '$txt_legal_kab' AND kecamatan = '$txt_legal_kec' AND kelurahan = '$txt_legal_kelurahan' GROUP BY zipcode";
											$res_zipcode = mysqli_query($condb, $sql_zipcode);
											while($row = mysqli_fetch_array($res_zipcode)){
												if ($row["zipcode"] == $txt_legal_zipcode) {
													echo "<option value='".$row["zipcode"]."' selected>".$row["zipcode"]."</option>";
												}else{
													echo "<option value='".$row["zipcode"]."'>".$row["zipcode"]."</option>";
												}
											}
											mysqli_free_result($res_zipcode, 0);
										}
									?>
								</select>
							</div>
						</div>

						<div class="col-md-6 col-lg-3">
							<div class="form-group">
								<label for="txtlabel">Legal RT</label>
								<input type="text" maxlength="3" class="form-control form-control-sm" onkeypress="return isNumberKey(event)" id="txt_legal_rt" name="txt_legal_rt" value="<?php echo $txt_legal_rt; ?>">
							</div>
							<div class="form-group">
								<label for="txtlabel">Legal Kecamatan</label>
								<!-- <input type="text" class="form-control form-control-sm" id="txt_legal_kec" name="txt_legal_kec" value="<?php echo $txt_legal_kec; ?>"> -->
								<select class="form-control form-control-sm select2" id="txt_legal_kec" name="txt_legal_kec">
									<option value="" selected>Select Kecamatan</option>
									<?php
										if ($txt_legal_kab != "") {
											// kecamatan
											$sql_kecamatan = "SELECT * FROM cc_master_alamat WHERE is_active=1 AND city = '$txt_legal_kab' GROUP BY kecamatan";
											$res_kecamatan = mysqli_query($condb, $sql_kecamatan);
											while($row = mysqli_fetch_array($res_kecamatan)){
												if (strtolower($row["kecamatan"]) == strtolower($txt_legal_kec)) {
													echo "<option value='".$row["kecamatan"]."' selected>".$row["kecamatan"]."</option>";
												}else{
													echo "<option value='".$row["kecamatan"]."'>".$row["kecamatan"]."</option>";
												}
											}
											mysqli_free_result($res_kecamatan, 0);
										}
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="txtlabel">Legal Sub Zip Code</label>
								<input type="text" class="form-control form-control-sm" id="txt_legal_sub_zipcode" name="txt_legal_sub_zipcode" value="<?php echo $txt_legal_sub_zipcode; ?>">
							</div>
						</div>

						<div class="col-md-6 col-lg-3">
							<div class="form-group">
								<label for="txtlabel">Legal RW</label>
								<input type="text" maxlength="3" class="form-control form-control-sm" onkeypress="return isNumberKey(event)" id="txt_legal_rw" name="txt_legal_rw" value="<?php echo $txt_legal_rw; ?>">
							</div>
							<div class="form-group">
								<label for="txtlabel">Legal Kelurahan</label>
								<!-- <input type="text" class="form-control form-control-sm" id="txt_legal_kelurahan" name="txt_legal_kelurahan" value="<?php echo $txt_legal_kelurahan; ?>"> -->
								<select class="form-control form-control-sm select2" id="txt_legal_kelurahan" name="txt_legal_kelurahan">
									<option value="" selected>Select Kelurahan</option>
									<?php
										if ($txt_legal_kec != "") {
											// kelurahan
											$sql_kelurahan = "SELECT * FROM cc_master_alamat WHERE is_active=1 AND kecamatan='$txt_legal_kec' AND city = '$txt_legal_kab' GROUP BY kelurahan";
											$res_kelurahan = mysqli_query($condb, $sql_kelurahan);
											while($row = mysqli_fetch_array($res_kelurahan)){
												if (strtolower($row["kelurahan"]) == strtolower($txt_legal_kelurahan)) {
													echo "<option value='".$row["kelurahan"]."' selected>".$row["kelurahan"]."</option>";
												}else{
													echo "<option value='".$row["kelurahan"]."'>".$row["kelurahan"]."</option>";
												}
											}
											mysqli_free_result($res_kelurahan, 0);
										}
									?>
								</select>
							</div>
						</div>
						
						<div class="col-md-6 col-lg-3">
							<div class="form-group">
								<label for="txtlabel">Legal Province</label>
								<!-- <input type="text" class="form-control form-control-sm" id="txt_legal_prov" name="txt_legal_prov" value="<?php echo $txt_legal_prov; ?>"> -->
								<select class="form-control form-control-sm select2" id="txt_legal_prov"  name="txt_legal_prov">
									<option value="" selected="">Select Province</option>
									<?php
										while($row = mysqli_fetch_array($res_province)){
											if (strtolower($row["province_name"]) == strtolower($txt_legal_prov)) {
												echo "<option value='".$row["province_name"]."' selected>".$row["province_name"]."</option>";
											}else{
												echo "<option value='".$row["province_name"]."'>".$row["province_name"]."</option>";
											}
										}
										mysqli_data_seek($res_province, 0);
									?>
								</select>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
		<!-- end table 5 -->


		<!-- start table 6 -->
		<div class="col-md-12" style="margin-top:-25px;">
			<div class="card">
				<div class="card-header" id="bgblues">
					<div class="card-title"><b class="textwhite">Survey Address</b></div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-6 col-lg-3">
							<div class="form-group">
								<label for="txtlabel">Survey Address</label>
								<input type="text" class="form-control form-control-sm" id="txt_survey_addr" name="txt_survey_addr" value="<?php echo $txt_survey_addr; ?>">
							</div>
							<div class="form-group">
								<label for="txtlabel">Survey Kabupaten</label>
								<!-- <input type="text" class="form-control form-control-sm" id="txt_survey_kab"  name="txt_survey_kab" value="<?php echo $txt_survey_kab; ?>"> -->
								<select class="form-control form-control-sm select2" id="txt_survey_kab"  name="txt_survey_kab">
									<option value="" selected>Select Kabupaten</option>
									<?php
										while($row = mysqli_fetch_array($res_survey_kabupaten)){
											if (strtolower($row["city"]) == strtolower($txt_survey_kab) && $txt_survey_kab != "") {
												echo "<option value='".$row["city"]."' selected>".$row["city"]."</option>";
											}else{
												echo "<option value='".$row["city"]."'>".$row["city"]."</option>";
											}
										}
										mysqli_data_seek($res_survey_kabupaten, 0);
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="txtlabel">Survey Sub Zip Code</label>
								<input type="text" class="form-control form-control-sm" id="txt_survey_subzipcode"  name="txt_survey_subzipcode" value="<?php echo $txt_survey_subzipcode; ?>">
							</div>
						</div>

						<div class="col-md-6 col-lg-3">
							<div class="form-group">
								<label for="txtlabel">Survey RT</label>
								<input type="text" maxlength="3" class="form-control form-control-sm" onkeypress="return isNumberKey(event)" id="txt_survey_rt" name="txt_survey_rt" value="<?php echo $txt_survey_rt; ?>">
							</div>
							<div class="form-group">
								<label for="txtlabel">Survey Kecamatan</label>
								<!-- <input type="text" class="form-control form-control-sm" id="txt_survey_kec" name="txt_survey_kec" value="<?php echo $txt_survey_kec; ?>"> -->
								<select class="form-control form-control-sm select2" id="txt_survey_kec" name="txt_survey_kec">
									<option value="" selected>Select Kecamatan</option>
									<?php
										if ($txt_survey_kab != "") {
											// kecamatan
											$sql_kecamatan = "SELECT * FROM cc_master_alamat WHERE is_active=1 AND city = '$txt_survey_kab' GROUP BY kecamatan";
											$res_kecamatan = mysqli_query($condb, $sql_kecamatan);
											while($row = mysqli_fetch_array($res_kecamatan)){
												if (strtolower($row["kecamatan"]) == strtolower($txt_survey_kec)) {
													echo "<option value='".$row["kecamatan"]."' selected>".$row["kecamatan"]."</option>";
												}else{
													echo "<option value='".$row["kecamatan"]."'>".$row["kecamatan"]."</option>";
												}
											}
											mysqli_free_result($res_kecamatan, 0);
										}
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="txtlabel">House Ownership</label>
								<!-- <input type="text" class="form-control form-control-sm" id="txt_survey_houseowner" name="txt_survey_houseowner" value="<?php echo $txt_survey_houseowner; ?>"> -->
								<select class="form-control form-control-sm select2" id="txt_survey_houseowner" name="txt_survey_houseowner">
									<option value="" selected>Select House Ownership</option>
									<?php
										while($row = mysqli_fetch_array($res_ownership)){
											if ($row['master_code'] == $txt_survey_houseowner || $row['descr'] == $txt_survey_houseowner) {
												echo "<option value='".$row['master_code']."' selected>".$row['descr']."</option>";
											}else{
												echo "<option value='".$row['master_code']."' >".$row['descr']."</option>";
											}
										}
										mysqli_data_seek($res_ownership, 0);
									?>
								</select>
							</div>
						</div>

						<div class="col-md-6 col-lg-3">
							<div class="form-group">
								<label for="txtlabel">Survey RW</label>
								<input type="text" maxlength="3" class="form-control form-control-sm" onkeypress="return isNumberKey(event)" id="txt_survey_rw" name="txt_survey_rw" value="<?php echo $txt_survey_rw; ?>">
							</div>
							<div class="form-group">
								<label for="txtlabel">Survey Kelurahan</label>
								<!-- <input type="text" class="form-control form-control-sm" id="txt_survey_kelurahan" name="txt_survey_kelurahan" value="<?php echo $txt_survey_kelurahan; ?>"> -->
								<select class="form-control form-control-sm select2" id="txt_survey_kelurahan" name="txt_survey_kelurahan">
									<option value="" selected>Select Kelurahan</option>
									<?php
										if ($txt_survey_kec != "") {
											// kelurahan
											$sql_kelurahan = "SELECT * FROM cc_master_alamat WHERE is_active=1 AND kecamatan='$txt_survey_kec' AND city = '$txt_survey_kab' GROUP BY kelurahan";
											$res_kelurahan = mysqli_query($condb, $sql_kelurahan);
											while($row = mysqli_fetch_array($res_kelurahan)){
												if (strtolower($row["kelurahan"]) == strtolower($txt_survey_kelurahan)) {
													echo "<option value='".$row["kelurahan"]."' selected>".$row["kelurahan"]."</option>";
												}else{
													echo "<option value='".$row["kelurahan"]."'>".$row["kelurahan"]."</option>";
												}
											}
											mysqli_free_result($res_kelurahan, 0);
										}
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="txtlabel">Length of Domicile</label>
								<input type="text" class="form-control form-control-sm" id="txt_survey_domicile" name="txt_survey_domicile" value="<?php echo $txt_survey_domicile; ?>">
							</div>
						</div>
						
						<div class="col-md-6 col-lg-3">
							<div class="form-group">
								<label for="txtlabel">Survey Province</label>
								<!-- <input type="text" class="form-control form-control-sm" id="txt_survey_prov" name="txt_survey_prov" value="<?php echo $txt_survey_prov; ?>"> -->
								<select class="form-control form-control-sm select2" id="txt_survey_prov"  name="txt_survey_prov">
									<option value="" selected="">Select Province</option>
									<?php
										while($row = mysqli_fetch_array($res_province)){
											if (strtolower($row["province_name"]) == strtolower($txt_survey_prov)) {
												echo "<option value='".$row["province_name"]."' selected>".$row["province_name"]."</option>";
											}else{
												echo "<option value='".$row["province_name"]."'>".$row["province_name"]."</option>";
											}
										}
										mysqli_data_seek($res_province, 0);
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="txtlabel">Survey Zip Code</label>
								<!-- <input type="text" class="form-control form-control-sm" id="txt_survey_zipcode" name="txt_survey_zipcode" value="<?php echo $txt_survey_zipcode; ?>"> -->
								<select class="form-control form-control-sm select2" id="txt_survey_zipcode" name="txt_survey_zipcode">
									<option value="" selected>Select ZIPCode</option>
									<?php
										if ($txt_survey_kelurahan != "") {
											// kecamatan
											$sql_zipcode = "SELECT * FROM cc_master_alamat WHERE is_active=1 AND city = '$txt_survey_kab' AND kecamatan = '$txt_survey_kec' AND kelurahan = '$txt_survey_kelurahan' GROUP BY zipcode";
											$res_zipcode = mysqli_query($condb, $sql_zipcode);
											while($row = mysqli_fetch_array($res_zipcode)){
												if ($row["zipcode"] == $txt_survey_zipcode) {
													echo "<option value='".$row["zipcode"]."' selected>".$row["zipcode"]."</option>";
												}else{
													echo "<option value='".$row["zipcode"]."'>".$row["zipcode"]."</option>";
												}
											}
											mysqli_free_result($res_zipcode, 0);
										}
									?>
								</select>
							</div>
						</div>

				

					</div>
				</div>
			</div>
		</div>
		<!-- end table 6 -->

				<!-- start table 7 -->
				<div class="col-md-12" style="margin-top:-25px;">
			<div class="card">
				<div class="card-header" id="bgblues">
					<div class="card-title"><b class="textwhite">Job Info</b></div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-6 col-lg-3">
							<div class="form-group">
								<label for="txtlabel">Profession Name</label>
								<!-- <input type="text" class="form-control form-control-sm" id="txt_job_profname" name="txt_job_profname" value="<?php echo $txt_job_profname; ?>"> -->
								<select class="form-control form-control-sm select2" id="txt_job_profname" name="txt_job_profname">
									<option value="" selected>Select Profession</option>
									<?php
										while($row = mysqli_fetch_array($res_profession)){
											if ($row['profession_name'] == $txt_job_profname && $txt_job_profname != "") {
												echo "<option value='".$row["profession_name"]."' selected>".$row["profession_name"]."</option>";
											}else{
												echo "<option value='".$row["profession_name"]."'>".$row["profession_name"]."</option>";
											}
										}
										mysqli_data_seek($res_profession, 0);
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="txtlabel">Length of Work</label>
								<input type="text" class="form-control form-control-sm" onkeypress="return isNumberKey(event)" id="txt_job_work"  name="txt_job_work" value="<?php echo $txt_job_work; ?>">
							</div>
						</div>

						<div class="col-md-6 col-lg-3">
							<div class="form-group">
								<label for="txtlabel">Customer Model Name</label>
								<!-- <input type="text" class="form-control form-control-sm" id="txt_job_modelname" name="txt_job_modelname" value="<?php echo $txt_job_modelname; ?>"> -->
								<select class="form-control form-control-sm select2" id="txt_job_modelname" name="txt_job_modelname">
									<option value="" selected>Select Customer Model</option>
									<?php
										while($row = mysqli_fetch_array($res_cust_model)){
											if ($row['cust_model_name'] == $txt_job_modelname) {
												echo "<option value='".$row['cust_model_name']."' selected>".$row['cust_model_name']."</option>";
											}else{
												echo "<option value='".$row['cust_model_name']."' >".$row['cust_model_name']."</option>";
											}
										}
										mysqli_data_seek($res_ownership, 0);
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="txtlabel">Penghasilan/Bulan</label>
								<input type="text" class="form-control form-control-sm" id="txt_job_penghasilan" name="txt_job_penghasilan" value="<?php echo $txt_job_penghasilan; ?>">
							</div>
						</div>

						<div class="col-md-6 col-lg-3">
							<div class="form-group">
								<label for="txtlabel">Industri Type Name</label>
								<!-- <input type="text" class="form-control form-control-sm" id="txt_job_industryname" name="txt_job_industryname" value="<?php echo $txt_job_industryname; ?>"> -->
								<select class="form-control form-control-sm select2" id="txt_job_industryname" name="txt_job_industryname">
									<option value="" selected>Select Industry Type</option>
									<?php
										while($row = mysqli_fetch_array($res_industry_type)){
											if ($row['industry_type_name'] == $txt_job_industryname) {
												echo "<option value='".$row['industry_type_name']."' selected>".$row['industry_type_name']."</option>";
											}else{
												echo "<option value='".$row['industry_type_name']."' >".$row['industry_type_name']."</option>";
											}
										}
										mysqli_data_seek($res_ownership, 0);
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="txtlabel">Job Phone 1</label>
								<input type="text" class="form-control form-control-sm" onkeypress="return isNumberKey(event)" id="txt_job_phone1" name="txt_job_phone1" value="<?php echo $txt_job_phone1; ?>">
							</div>
						</div>
						
						<div class="col-md-6 col-lg-3">
							<div class="form-group">
								<label for="txtlabel">Job Position</label>
								<input type="text" class="form-control form-control-sm" id="txt_job_position" name="txt_job_position" value="<?php echo $txt_job_position; ?>">
							</div>
							<div class="form-group">
								<label for="txtlabel">Job Phone 2</label>
								<input type="text" class="form-control form-control-sm" onkeypress="return isNumberKey(event)" id="txt_job_phone2" name="txt_job_phone2" value="<?php echo $txt_job_phone2; ?>">
							</div>
						</div>

				

					</div>
				</div>
			</div>
		</div>
		<!-- end table 7 -->


			<!-- start table 8 -->
			<div class="col-md-12" style="margin-top:-25px;">
			<div class="card">
				<div class="card-header" id="bgblues">
					<div class="card-title"><b class="textwhite">Other Notes</b></div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-6 col-lg-3">
							<div class="form-group">
								<label for="txtlabel">Other Asset Type</label>
								<input type="text" class="form-control form-control-sm" id="txt_other_type" name="txt_other_type" value="<?php echo $txt_other_type; ?>">
							</div>
						</div>

						<div class="col-md-6 col-lg-3">
							<div class="form-group">
								<label for="txtlabel">Alternative Phone No</label>
								<input type="text" class="form-control form-control-sm" id="txt_other_alternativephone" name="txt_other_alternativephone" value="<?php echo $txt_other_alternativephone; ?>">
							</div>
						</div>

						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label for="txtlabel">Visit Notes</label>
								<input type="text" class="form-control form-control-sm" id="txt_other_visitnote" name="txt_other_visitnote" value="<?php echo $txt_other_visitnote; ?>">
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<!-- end table 8 -->


			<!-- start table 8,5 -->
			<div class="col-md-12" style="margin-top:-25px;">
			<div class="card">
				<div class="card-header" id="bgblues">
					<div class="card-title"><b class="textwhite">Simulasi Pinjaman</b></div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-6 col-lg-3">
							<div class="form-group">
								<?php
									$x				   = 0;
		        					
		        					
		        					function get_select_master_cabang($conDB, $id, $name, $required, $product_id) {
											$sel = "<SELECT id=\"$id\" name=\"$name\" class=\"form-control form-control-sm select2\" style=\"width:100%;\" \"$required\" >";
											$sql_str1 = " SELECT a.id, a.office_code, a.office_name FROM cc_master_cabang a ";
											$sel .= "<option value='' selected>-- Select Original Office --</option>";  
											$sql_res1  = execSQL($conDB, $sql_str1);
											while ($sql_rec1 = mysqli_fetch_array($sql_res1)) {
											  if($sql_rec1['office_code'] == $product_id) {
												$sel .= "<option value=\"".$sql_rec1['id']."\" selected>".$sql_rec1['office_code']." / ".$sql_rec1['office_name']."</option>";  
											  } else {
												$sel .= "<option value=\"".$sql_rec1['id']."\" >".$sql_rec1['office_code']." / ".$sql_rec1['office_name']."</option>";  
										  
											  }
											}
											$sel .= "</SELECT>";
										  
											return $sel;
										  }

		                    		$txtlabel[$x]      = "Original Office <span class='required-label'>*</span>";
		                    		$bodycontent[$x]   = get_select_master_cabang($condb, "three_or_office", "three_or_office", "required", $cabang_code);
		                    		$x++;

								                	        					
					        		function get_select_master_lob($conDB, $id, $name, $required, $mlob,$asset_type,$param_lob) {
					        			// $param_dis="";

					        			// $sql_whr = "WHERE a.lob_name LIKE '%Mobil%' ";
					        			// if ($param_lob==0) {
					        			// 	$param_dis = "disabled";
					        			// 	$sql_whr="";
					        			// }
										$sel = "<SELECT id=\"$id\" name=\"$name\" class=\"form-control form-control-sm select2\" style=\"width:100%;\" \"$required\" $param_dis>";//disabled
										$sel .= "<option value=\"\" >-- Select LOB --</option>";
										$sql_str1 = " SELECT a.lob_code, a.lob_name FROM cc_ts_lob a $sql_whr GROUP BY a.lob_code ";
										$sql_res1  = execSQL($conDB, $sql_str1);
										while ($sql_rec1 = mysqli_fetch_array($sql_res1)) {
										  if($sql_rec1['lob_code'] == $mlob) {
											$sel .= "<option value=\"".$sql_rec1['lob_code']."\" selected>".$sql_rec1['lob_code']." / ".$sql_rec1['lob_name']."</option>";  
										  } else {
											$sel .= "<option value=\"".$sql_rec1['lob_code']."\" >".$sql_rec1['lob_code']." / ".$sql_rec1['lob_name']."</option>";
										  }
										}
										$sel .= "</SELECT>";
										  
										return $sel;
									}

					                $txtlabel[$x]      = "LOB <span class='required-label'>*</span>";
					                $bodycontent[$x]   = get_select_master_lob($condb, "mlob", "mlob", "required", $lob, $asset_type, $param_lob);
					                $x++;
		        					
		        					function get_select_master_product_offer($conDB, $id, $name, $required, $product_id, $mlob) {
											$sel = "<SELECT id=\"$id\" name=\"$name\" class=\"form-control form-control-sm select2 val-prospect\" style=\"width:100%;\" \"$required\" >";//disabled
											$sel .= "<option value=\"\" >-- Select --</option>";
											$sql_str1 = " SELECT a.id, a.prod_offering_code, a.prod_offering_name, b.lob_name FROM cc_prod_offering a
														 LEFT JOIN cc_ts_lob b ON a.prod_offering_code=b.prod_offering_code
														 WHERE b.lob_code='$mlob' AND a.status='1'
														 GROUP BY a.prod_offering_code ";
											$sql_res1  = execSQL($conDB, $sql_str1);
											while ($sql_rec1 = mysqli_fetch_array($sql_res1)) {
											  if($sql_rec1['prod_offering_code'] == $product_id) {
												$sel .= "<option value=\"".$sql_rec1['prod_offering_code']."\" selected>".$sql_rec1['prod_offering_code']." / ".$sql_rec1['prod_offering_name']."</option>";  
											  } else {
												$sel .= "<option value=\"".$sql_rec1['prod_offering_code']."\" >".$sql_rec1['prod_offering_code']." / ".$sql_rec1['prod_offering_name']."</option>";  
										  
											  }
											}
											$sel .= "</SELECT>";
										  
											return $sel;
										  }

		                    		$txtlabel[$x]      = "Product Offering <span class='required-label stat-prospect' style='display:none;'>*</span>";
		                    		$bodycontent[$x]   = get_select_master_product_offer($condb, "three_pro_offering", "three_pro_offering", "", $product_offering_code, $lob);
		                    		$x++;
		        					
		        					function get_select_master_kendaraan($conDB, $id, $name, $required, $product_id) {
											$sel = "<SELECT id=\"$id\" name=\"$name\" class=\"form-control form-control-sm select2 val-prospect\" style=\"width:100%;\" \"$required\" >";//disabled
											// $sql_str1 = " SELECT a.id, a.asset_code, a.asset_full_name FROM cc_master_kendaraan a ";
											// $sql_res1  = execSQL($conDB, $sql_str1);
											// while ($sql_rec1 = mysqli_fetch_array($sql_res1)) {
											//   if($sql_rec1['asset_code'] == $product_id) {
											// 	$sel .= "<option value=\"".$sql_rec1['id']."\" selected>".$sql_rec1['asset_code']." / ".$sql_rec1['asset_full_name']."</option>";  
											//   } else {
											// 	$sel .= "<option value=\"".$sql_rec1['id']."\" >".$sql_rec1['asset_code']." / ".$sql_rec1['asset_full_name']."</option>";  
										  
											//   }
											// }

											$sql_str1 = " SELECT a.id, a.asset_code, a.asset_full_name FROM cc_master_kendaraan a WHERE a.asset_code = '".$product_id."' LIMIT 1 ";
											$sql_res1  = execSQL($conDB, $sql_str1);
											while ($sql_rec1 = mysqli_fetch_array($sql_res1)) {
											  $sel .= "<option value=\"".$sql_rec1['id']."\" selected>".$sql_rec1['asset_code']." / ".$sql_rec1['asset_full_name']."</option>";
											}

											$sql_str1 = " SELECT a.id, a.asset_code, a.asset_full_name FROM cc_master_kendaraan a WHERE a.asset_code != '".$product_id."' ";
											$sql_res1  = execSQL($conDB, $sql_str1);
											while ($sql_rec1 = mysqli_fetch_array($sql_res1)) {
											  $sel .= "<option value=\"".$sql_rec1['id']."\" >".$sql_rec1['asset_code']." / ".$sql_rec1['asset_full_name']."</option>";
											}
											$sel .= "</SELECT>";
										  
											return $sel;
										  }
		        					
		                    		$txtlabel[$x]      = "Asset Name <span class='required-label stat-prospect' style='display:none;'>*</span>";
		                    		$bodycontent[$x]   = get_select_master_kendaraan($condb, "three_asset_name", "three_asset_name", "", $item_type2);
		                    		$x++;
		        					
		                    		$txtlabel[$x]      = "Manufacturing Year <span class='required-label stat-prospect' style='display:none;'>*</span>";
		                    		$bodycontent[$x]   = input_text_temp_keypress("three_mfr_year","three_mfr_year",$three_mfr_year,"","","form-control form-control-sm val-prospect","return validate_number(event)");
		                    		$x++;
		        					
		                    		$txtlabel[$x]      = "OTR <span class='required-label stat-prospect' style='display:none;'>*</span>";
		                    		$bodycontent[$x]   = input_text_temp_keypress("three_otr","three_otr",$three_otr,"","","form-control form-control-sm val-prospect","return validate_number(event)");
		                    		//$bodycontent[$x]   = "<input type='text' id='three_otr' name='three_otr' class='number-separator' value='$three_otr'>";
									$x++;
		                    		
		                    		echo label_form_det($txtlabel,$bodycontent,$x);
								?>
							</div>
						</div>

						<div class="col-md-6 col-lg-3">
							<div class="form-group">
								<?php

									$x				   = 0;
		        					
		                    		// $txtlabel[$x]      = "Asset Usage";
		                    		// $bodycontent[$x]   = input_text_temp("three_asset_usage","three_asset_usage",$three_asset_usage,"","","form-control form-control-sm","");
		                    		// $x++;

		        					
		        					function get_select_master_usage($conDB, $id, $name, $required, $product_id) {
											$sel = "<SELECT id=\"$id\" name=\"$name\" class=\"form-control form-control-sm select2 val-prospect\" style=\"width:100%;\" \"$required\" >";//disabled
											$sql_str1 = " SELECT a.id, a.usage_code, a.usage_desc FROM cc_master_asset_usage a ";
											$sql_res1  = execSQL($conDB, $sql_str1);
											$sel .= "<option value=''>-- Select Asset Usage --</option>";
											while ($sql_rec1 = mysqli_fetch_array($sql_res1)) {
												$param = $sql_rec1['usage_code']." - ".$sql_rec1['usage_desc'];
											  if($sql_rec1['usage_code'] == $product_id) {
												$sel .= "<option value=\"".$sql_rec1['usage_code']."\" selected>".$sql_rec1['usage_code']." - ".$sql_rec1['usage_desc']."</option>";  
											  } else {
												$sel .= "<option value=\"".$sql_rec1['usage_code']."\" >".$sql_rec1['usage_code']." - ".$sql_rec1['usage_desc']."</option>";  
										  
											  }
											}
											$sel .= "</SELECT>";
										  
											return $sel;
										  }
		        					
		                    		$txtlabel[$x]      = "Asset Usage <span class='required-label stat-prospect' style='display:none;'>*</span>";
		                    		$bodycontent[$x]   = get_select_master_usage($condb, "three_asset_usage", "three_asset_usage", "", $three_asset_usage);
		                    		$x++;
		        					
		                    		$txtlabel[$x]      = "Admin Fee <span class='required-label stat-prospect' style='display:none;'>*</span>";
		                    		$bodycontent[$x]   = input_text_temp_oninput("three_admin_fee","three_admin_fee",$three_admin_fee,"","","form-control form-control-sm val-prospect","return isMoney(event, this)");
		                    		$x++;
		        					
		                    		$txtlabel[$x]      = "Additional Admin Fee <span class='required-label stat-prospect' style='display:none;'>*</span>";
		                    		$bodycontent[$x]   = input_text_temp_oninput("three_add_adminfee","three_add_adminfee",$three_add_adminfee,"","","form-control form-control-sm val-prospect","return isMoney(event, this)");
		                    		$x++;
		                    			//.input_text_temp("three_ltv_maks","three_ltv_maks",$three_ltv_maks,"","","form-control form-control-sm","return validate_number(event)")
		                    		$ltvnya = "
										<div class=\"input-group mb-3\">
											".
											input_text_temp("three_ltv_maks","three_ltv_maks",$three_ltv_maks,"","","form-control form-control-sm","")."
											<div class=\"input-group-append\">
												<span class=\"input-group-text\"  >%</span>
											</div>
										</div>";

		                    		$txtlabel[$x]      = "LTV  Maksimal <span class='required-label stat-prospect val-prospect' style='display:none;'>*</span>";
		                    		$bodycontent[$x]   = $ltvnya;
		                    		$x++;
		                    		//input_text_temp_keypress("three_ltv_yang","three_ltv_yang",$three_ltv_yang,"","","form-control form-control-sm","return validate_number(event)")
		                    		$ltvnya = "
										<div class=\"input-group mb-3\">
											".input_text_temp("three_ltv_yang","three_ltv_yang",$three_ltv_yang,"","","form-control form-control-sm val-prospect","")."
											<div class=\"input-group-append\">
												<span class=\"input-group-text\"  >%</span>
											</div>
										</div>";
		                    		$txtlabel[$x]      = "LTV Yang Diberikan <span class='required-label stat-prospect' style='display:none;'>*</span>";
		                    		$bodycontent[$x]   = $ltvnya;
		                    		$x++;
		                    		
		                    		echo label_form_det($txtlabel,$bodycontent,$x);
								?>
							</div>
						</div>

						<div class="col-md-6 col-lg-3">
							<div class="form-group">
								<?php

									$x				   = 0;
		        					
		        					
		                    		$txtlabel[$x]      = "Biaya Provisi <span class='required-label stat-prospect' style='display:none;'>*</span>";
		                    		$bodycontent[$x]   = input_text_temp_oninput("three_biaya_pro","three_biaya_pro",$three_biaya_pro,"","","form-control form-control-sm val-prospect","return isMoney(event, this)");
		                    		$x++;
		                    		
		                    		$txtlabel[$x]      = "PH Maksimal <span class='required-label stat-prospect' style='display:none;'>*</span>";
		                    		$bodycontent[$x]   = input_text_temp_keypress("three_ph_maks","three_ph_maks",$three_ph_maks,"","","form-control form-control-sm val-prospect","return validate_number(event)");
		                    		$x++;
		                    		
		                    		$txtlabel[$x]      = "PH Yang Diberikan <span class='required-label stat-prospect' style='display:none;'>*</span>";
		                    		$bodycontent[$x]   = input_text_temp_keypress("three_ph_yang","three_ph_yang",$three_ph_yang,"","","form-control form-control-sm val-prospect","return validate_number(event)");
		                    		$x++;
		                    		
		                    		// $txtlabel[$x]      = "Insurance Type";
		                    		// $bodycontent[$x]   = input_text_temp("three_ins_type","three_ins_type",$three_ins_type,"","","form-control form-control-sm","");
		                    		// $x++;

		        					
		        					function get_select_master_ins($conDB, $id, $name, $required, $product_id) {
											$sel = "<SELECT id=\"$id\" name=\"$name\" class=\"form-control form-control-sm select2 val-prospect\" style=\"width:100%;\" \"$required\" >";//disabled
											$sql_str1 = " SELECT a.id, a.ins_code, a.ins_desc FROM cc_master_insurance a ";
											$sql_res1  = execSQL($conDB, $sql_str1);
											$sel .= "<option value=''>-- Select Asset Insurance --</option>";
											while ($sql_rec1 = mysqli_fetch_array($sql_res1)) {
												$param = $sql_rec1['ins_code']." - ".$sql_rec1['ins_desc'];
											  if($sql_rec1['ins_code'] == $product_id) {
												$sel .= "<option value=\"".$sql_rec1['ins_code']."\" selected>".$sql_rec1['ins_code']." - ".$sql_rec1['ins_desc']."</option>";  
											  } else {
												$sel .= "<option value=\"".$sql_rec1['ins_code']."\" >".$sql_rec1['ins_code']." - ".$sql_rec1['ins_desc']."</option>";  
										  
											  }
											}
											$sel .= "</SELECT>";
										  
											return $sel;
										  }
		        					
		                    		$txtlabel[$x]      = "Insurance Type <span class='required-label stat-prospect' style='display:none;'>*</span>";
		                    		$bodycontent[$x]   = get_select_master_ins($condb, "three_ins_type", "three_ins_type", "", $three_ins_type);
		                    		$x++;
		                    		
		                    		$txtlabel[$x]      = "Calculate Insurance <span class='required-label stat-prospect' style='display:none;'>*</span>";
		                    		$bodycontent[$x]   = input_text_temp_keypress("three_calcu_ins","three_calcu_ins",$three_calcu_ins,"","","form-control form-control-sm val-prospect","return validate_number(event)");
		                    		$x++;
		                    		
		                    		echo label_form_det($txtlabel,$bodycontent,$x);
								?>
							</div>
						</div>

						<div class="col-md-6 col-lg-3">
							<div class="form-group">
								<?php
													
									$x				   = 0;
		                    		
		                    		$txtlabel[$x]      = "Self Insurance <span class='required-label stat-prospect' style='display:none;'>*</span>";
		                    		$bodycontent[$x]   = input_text_temp_keypress("three_self_ins","three_self_ins",$three_self_ins,"","","form-control form-control-sm val-prospect","return validate_number(event)");
		                    		$x++;
		        					
		                    		$txtlabel[$x]      = "Tenor <span class='required-label stat-prospect' style='display:none;'>*</span>";
		                    		$bodycontent[$x]   = input_text_temp_keypress("three_tenor","three_tenor",$three_tenor,"","","form-control form-control-sm val-prospect","return validate_number(event)");
		                    		$x++;
		                    		
		                    		$txtlabel[$x]      = "Calculate Budget Plan Amount <span class='required-label stat-prospect' style='display:none;'>*</span>";
		                    		$bodycontent[$x]   = input_text_temp_keypress("three_calcu_budget","three_calcu_budget",$three_calcu_budget,"","","form-control form-control-sm val-prospect","return validate_number(event)");
		                    		$x++;
		                    		
		                    		$txtlabel[$x]      = "Budget Plan Amount Yang Diberikan <span class='required-label stat-prospect' style='display:none;'>*</span>";
		                    		$bodycontent[$x]   = input_text_temp_keypress("three_budget_plan","three_budget_plan",$three_budget_plan,"","","form-control form-control-sm val-prospect","return validate_number(event)");
		                    		$x++;
		                    		
		                    		$txtlabel[$x]      = "Calculate Installment <span class='required-label stat-prospect' style='display:none;'>*</span>";
		                    		$bodycontent[$x]   = input_text_temp_keypress("three_calcu_install","three_calcu_install",$three_calcu_install,"","","form-control form-control-sm val-prospect","return validate_number(event)");
		                    		$x++;
		                    		
		                    		echo label_form_det($txtlabel,$bodycontent,$x);
								?>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<!-- end table 8,5 -->
	

				<!-- start table 9 -->
				<div class="col-md-12" style="margin-top:-25px;">
			<div class="card">
				<div class="card-header" id="bgblues">
					<div class="card-title"><b class="textwhite">Asset List New</b></div>
				</div>
				<div class="form-group">
				<?php 
					$addbtnasset = "<input type='button' name='btn_add_new_asset' id='btn_add_new_asset' class='btn btn-primary btn-sm' value='Add New Asset' data-toggle='modal' data-backdrop='false' data-target='#addnewassetpop' hidden>";
					echo $addbtnasset;
				 ?>
				</div>
			<!--	<div class="card-body">
					<div class="row">
						<div class="col-md-12 col-lg-12"> -->
						<div class="table-wrapper "><div class="table-responsive">
                            <div id="tableassetsload">
									<table id="tableAssetList" class="table table-head-bg-primary table-earnings" style="width:100%;height:20px;">
										<thead>
											<tr>
												<th scope="col">Asset Type</th>
												<th scope="col">Merk Kendaraan</th>
												<th scope="col">Asset Desc</th>
												<th scope="col">Model Kendaraan</th>
												<th scope="col">Kategori Kendaraan</th>
												<!-- <th scope="col">Machine No</th> -->
												<th scope="col">Machine No</th>
												<th scope="col">Chasis No</th>
												<th scope="col">License Plate</th>
												<th scope="col">Manufacturing Year</th>
												<th scope="col">Asset Ownership</th>
												<th scope="col">Asset Price AMT</th>
												<th scope="col">Product Offering</th>
												<th scope="col">Plafond Max</th>
												<th scope="col">Tenor</th>
												<th scope="col">Installment AMT</th>
												<th scope="col">DP/LTV Amount</th>
												<th scope="col">DP/LTV % Amount</th>
											</tr>
										</thead>

										<!--Table body-->
										<tbody>
										<?php 
											$sqlsa = "SELECT 
														a.id, a.id_penawaran, a.assets_type, a.assets_name, a.assets_type_desc, a.assets_desc,
														a.engine_no, a.license_plate, a.chasis_no, a.manufacturing_year, a.asset_ownership, a.product_offering, 
														a.asset_price, a.platfond_max, a.tenor, a.ltv, a.instalment, a.ltv_persen, a.kategori_asset
											 		  FROM 
													   	cc_ts_penawaran_add_assets a 
													  WHERE 
													  	a.task_id='$txt_task_id'";
											 $ressa = mysqli_query($condb,$sqlsa);
											 $no=1;
											 while($recsa = mysqli_fetch_array($ressa)){
												$ass_id_tel_add_assets		= $recsa['id'];
												$id_penawaran		= $recsa['id_penawaran'];
												$assets_type		= $recsa['assets_type'];
												$assets_name		= $recsa['assets_name'];
												$assets_type_desc	= $recsa['assets_type_desc'];
												$assets_desc		= $recsa['assets_desc'];
												$engine_no			= $recsa['engine_no'];
												$license_plate		= $recsa['license_plate'];
												$chasis_no			= $recsa['chasis_no'];
												$manufacturing_year	= $recsa['manufacturing_year'];
												$asset_ownership	= $recsa['asset_ownership'];
												$product_offering	= $recsa['product_offering'];
												$asset_price		= $recsa['asset_price'];
												$platfond_max		= $recsa['platfond_max'];
												$tenor				= $recsa['tenor'];
												$ltv				= $recsa['ltv'];
												$instalment			= $recsa['instalment'];
												$ltv_persen			= $recsa['ltv_persen'];
												$kategori_asset		= $recsa['kategori_asset'];
												// $ass_angsuran 				= conv_number($ass_angsuran,0);
												// $ass_otr					= conv_number($ass_otr,0);
												// $ass_estimasi_terima_bersih = conv_number($ass_estimasi_terima_bersih,0);
										?>
											<tr data-id="<?php echo $ass_id_tel_add_assets; ?>">
												<!-- <td><?php echo $no;?></td> -->
												<td>
													<?php echo $assets_type;?>
												</td>
												<!-- <td><?php //echo $ass_assets_type;?></td> -->
												<td><?php echo $assets_type_desc;?></td>
												<td><?php echo $assets_desc;?></td>
												<td><?php echo $assets_name;?></td>
												<td><?php echo $kategori_asset;?></td>
												<td><?php echo $engine_no;?></td>		
												<td><?php echo $chasis_no;?></td>
                                                <td><?php echo $license_plate;?></td>
												<td><?php echo $manufacturing_year;?></td>
												<td><?php echo $asset_ownership;?></td>
                                                <td><?php echo $asset_price;?></td>
												<td><?php echo $product_offering;?></td>
												
												<td><?php echo $platfond_max;?></td>
												<td><?php echo $tenor;?></td>
												
												<td><?php echo $instalment;?></td>
                                                <td><?php echo $ltv;?></td>
												<td><?php echo $ltv_persen;?></td>
											</tr>
										<?php 
											$no++;
											 }
										?>
										</tbody>
										<!--Table body-->
									</table>
                                            </div>
					</div></div>
					<!--	</div>

					</div>
				</div> -->
			</div>
		</div>
		<!-- end table 9 -->

				
							 
		
		<!-- start table 10 -->
		<div class="col-md-12" style="margin-top:-25px;">
			<div class="card">
				<div class="card-header" id="bgblues">
					<div class="card-title"><b class="textwhite">Activity</b></div>
				</div>
				<div id="divactivity">
					<div class="card-body">
	                    <div class="row">
	                        <div class="col-md-6 col-lg-6">
	                            <div class="form-group">
	                                <label for="txtlabel">Result</label>
	                                <!-- <input type="text" class="form-control form-control-sm" id="txt_activity_result" name="txt_activity_result" value="<?php //echo $txt_activity_result; ?>"> -->
	                                <select name='txt_activity_result' id='txt_activity_result' class='form-control form-control-sm'>
	                                    <option value=''>-- Select --</option>
	                                    <?php 
	                                        $sqlcs = "SELECT id, call_status FROM cc_ts_call_status ORDER BY call_status ASC ";//WHERE id > 2 
	                                        $rescs = mysqli_query($condb,$sqlcs);
	                                        while($reccs = mysqli_fetch_array($rescs)){
	                                            $id         = $reccs['id'];
	                                            $cstatus    = $reccs['call_status'];
	                                    ?>
	                                        <option value="<?php echo $id;?>"><?php echo $cstatus; ?></option>;
	                                    <?php 
	                                        }
	                                    ?>
	                                </select>
	                            </div>
	                            <div class="form-group">
	                                <label for="txtlabel">Sub Status Call</label>
	                                <!-- <input type="text" class="form-control form-control-sm" id="txt_activity_substatuscall"  name="txt_activity_substatuscall" value="<?php echo $txt_activity_substatuscall; ?>"> -->

	                                <select name='txt_activity_substatuscall' id='txt_activity_substatuscall' class='form-control form-control-sm'>
	                                    <option value=''>-- Select --</option>
	                                    <?php 
	                                        $sqlcs = "SELECT id, call_status_sub1 
	                                                          FROM cc_ts_call_status_sub1
	                                                          WHERE id='$call_status_sub1'
	                                                          ORDER BY call_status_sub1 ASC";
	                                        $rescs = mysqli_query($condb,$sqlcs);
	                                        while($reccs = mysqli_fetch_array($rescs)){
	                                            $id         = $reccs['id'];
	                                            $cstatus    = $reccs['call_status_sub1'];
	                                    ?>
	                                        <option value="<?php echo $id;?>"><?php echo $cstatus; ?></option>;
	                                    <?php 
	                                        }
	                                    ?>
	                                </select>
	                            </div>
	                            <div class="form-group">
	                                <label for="txtlabel">Dukcapil Result Pemohon</label>
	                                <input type="text" class="form-control form-control-sm" id="txt_activity_ducapil"  name="txt_activity_ducapil" value="<?php echo $txt_activity_ducapil; ?>" readonly>
	                            </div>
	                            <div class="form-group">
	                                <label for="txtlabel">Neglist Result Pemohon</label>
	                                <input type="text" class="form-control form-control-sm" id="txt_activity_neglist"  name="txt_activity_neglist" value="<?php echo $txt_activity_neglist; ?>" readonly>
	                            </div>
	                            <div class="form-group">
	                                <label for="txtlabel">Dukcapil Result Pasangan</label>
	                                <input type="text" class="form-control form-control-sm" id="txt_activity_pasangan_ducapil"  name="txt_activity_pasangan_ducapil" value="<?php echo $txt_activity_pasangan_ducapil; ?>" readonly>
	                            </div>
	                            <div class="form-group">
	                                <label for="txtlabel">Neglist Result Pasangan</label>
	                                <input type="text" class="form-control form-control-sm" id="txt_activity_pasangan_neglist"  name="txt_activity_pasangan_neglist" value="<?php echo $txt_activity_pasangan_neglist; ?>" readonly>
	                            </div>
	                            <div class="form-group">
	                                <label for="txtlabel">Dukcapil Result Guarantor</label>
	                                <input type="text" class="form-control form-control-sm" id="txt_activity_guarantor_ducapil"  name="txt_activity_guarantor_ducapil" value="<?php echo $txt_activity_guarantor_ducapil; ?>" readonly>
	                            </div>
	                            <div class="form-group">
	                                <label for="txtlabel">Neglist Result Guarantor</label>
	                                <input type="text" class="form-control form-control-sm" id="txt_activity_guarantor_neglist"  name="txt_activity_guarantor_neglist" value="<?php echo $txt_activity_guarantor_neglist; ?>" readonly>
	                            </div>
	                        </div>

	                        <div class="col-md-6 col-lg-6">
	                            <div class="form-group">
	                                <label for="txtlabel">Notes</label>
	                                <input type="text" class="form-control form-control-sm" id="txt_activity_notes" name="txt_activity_notes" value="<?php echo $txt_activity_notes; ?>">
	                            </div>
	                            <div class="form-group">
	                                <label for="txtlabel">Opsi Waktu Visit/Survey</label>
	                                <input type="text" class="form-control form-control-sm" id="txt_activity_waktuvisit" name="txt_activity_waktuvisit" value="<?php echo $txt_activity_waktuvisit; ?>">
	                            </div>
	                            <?php 
	                            	if ($txt_IS_PRE_APPROVAL=='1') {
	                            ?>
	                            <div class="form-group">
								<label for="txtlabel">Opsi Penanganan</label>
									<select class="form-control form-control-sm" id="opsi_penanganan" name="opsi_penanganan">
										<option value="" >Select Opsi Penanganan</option>
										<option value="Di Rumah" >Di Rumah</option>
										<option value="Di Cabang" >Di Cabang</option>
									</select>
								</div>
	                            <?php 
	                            	}
	                            ?>
								<div class="form-group" id="div_followup" style="display: none;">
									<label for="txtlabel">Follow Up</label>
										<input type="text" class="form-control" id="txtfollowup" name="txtfollowup"  value="<?php echo $txtfollowup;?>">
								</div>
	                            <div class="form-group">
	                                <label for="txtlabel">&nbsp;</label>
	                                <?php 
	            $btnduckcapil = "<input type='button' name='btn_duckcapil' id='btn_duckcapil' class='btn btn-secondary btn-sm' value='Check Dukcapil'>";
	            echo $btnduckcapil;
	                    ?>
	                            </div>
	                        </div>

	                        <div class="card-action">
	                            <button class="btn btn-success" id="btnSaveForm">Submit</button>
	                            <button class="btn btn-danger" id="btnSaveCustomer">Save Customer Info</button>
	                        </div>


	                    </div>
	                </div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div id="detailagrement" name="detailagrement"></div>
		</div>
		
	</div>
</form>
<?php
	} else {
?>
	<div id="page1">
		<div class="row">
			<div class="wizard-container wizard-round col-md-12">
				<div class="wizard-header text-center">
					<h3 class="wizard-title"><b>Blank</b> # Data </h3>
				</div>
				<div class="wizard-body">
					<div class="text-center">
						<img src="assets/img/empty-data.png" style="width:400px; height: 400px;">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php	
}
disconnectDB($condb);
?>
</div>
<!--   Core JS Files   -->
	<script src="assets/js/core/jquery.3.2.1.min.js"></script>
	<script src="assets/js/core/popper.min.js"></script>
	<script src="assets/js/core/bootstrap.min.js"></script>
	<!-- jQuery UI -->
	<script src="assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<script src="assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
	
	<script src="assets/number-thousand-separator/easy-number-separator.js"></script>

	<!-- Sweet Alert -->
	<script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>
	<!-- Bootstrap Toggle -->
	<script src="assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>
	<!-- jQuery Scrollbar -->
	<script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
	<!-- Select2 -->
	<script src="assets/js/plugin/select2/select2.full.min.js"></script>
	<!-- jQuery Validation -->
	<script src="assets/js/plugin/jquery.validate/jquery.validate.min.js"></script>
	<!-- Bootstrap Tagsinput -->
	<script src="assets/js/plugin/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
	<!-- Atlantis JS -->
	<script src="assets/js/atlantis.min.js"></script>
	<script src="assets/js/setting.js"></script>

	<script src="library/easy-number-separator.js"></script>
	

	
	<!-- <script src="assets/js/core/jquery.3.2.1.min.js"></script> -->
	<link rel="stylesheet" type="text/css" href="assets/css/pickers/daterange/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="assets/css/pickers/datetime/bootstrap-datetimepicker.css">
    <link rel="stylesheet" type="text/css" href="assets/css/pickers/pickadate/pickadate.css">
    
    <script src="assets/js/plugin/pickers/dateTime/moment-with-locales.min.js" type="text/javascript"></script>
    <script src="assets/js/plugin/pickers/dateTime/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
    <script src="assets/js/plugin/pickers/pickadate/picker.js" type="text/javascript"></script>
    <script src="assets/js/plugin/pickers/pickadate/picker.date.js" type="text/javascript"></script>
    <script src="assets/js/plugin/pickers/pickadate/picker.time.js" type="text/javascript"></script>
    <script src="assets/js/plugin/pickers/pickadate/legacy.js" type="text/javascript"></script>
    <script src="assets/js/plugin/pickers/daterange/daterangepicker.js" type="text/javascript"></script>
    

	<script src="library/datetimepick/js/moment.min.js"></script>
    <link rel="stylesheet" href="library/datetimepick/css/bootstrap-datetimepicker.min.css"> 
    <script src="library/datetimepick/js/bootstrap-datetimepicker.min.js"></script>
    <!-- <script src="assets/js/plugin/ESScreenCap/screencap.js"></script> -->
	<!-- Datatables -->
	<script src="assets/js/plugin/datatables/datatables.min.js"></script>

  	<script>
	$("#btn_add_new_asset").click(function(){
		 var taskid_asset = document.getElementById("txt_task_id").value;
		 $('#main_addnewasset').load('view/telesales/get_add_new_assets.php');//?taskid_asset='+taskid_asset
	});
	$("#btn_add_phone_no").click(function(){
		 var v 			 = document.getElementById("v").value;
		 var txt_task_id = document.getElementById("txt_task_id").value;
		 $('#main_addnewphone').load('view/telesales/get_add_new_phone.php?txt_task_id='+txt_task_id+'&v='+v);
	});

	function save_addphone_dialog(){ 
		var txtphonenoadd1		= document.getElementById("txt_add_phone_no1").value;
		var txtphonenoadd2		= document.getElementById("txt_add_phone_no2").value;
		var txtphonenoteadd1	= document.getElementById("txt_add_desc_no1").value;
		var txtphonenoteadd2	= document.getElementById("txt_add_desc_no2").value;
		var txtphonenoadd3		= document.getElementById("txt_add_phone_no3").value;
		var txtphonenoadd4		= document.getElementById("txt_add_phone_no4").value;
		var txtphonenoteadd3	= document.getElementById("txt_add_desc_no3").value;
		var txtphonenoteadd4	= document.getElementById("txt_add_desc_no4").value;
		var txtphonenoadd5		= document.getElementById("txt_add_phone_no5").value;
		var txtphonenoadd6		= document.getElementById("txt_add_phone_no6").value;
		var txtphonenoteadd5	= document.getElementById("txt_add_desc_no5").value;
		var txtphonenoteadd6	= document.getElementById("txt_add_desc_no6").value;

		var txt_task_id 	  	= document.getElementById("txt_task_id").value;
		var iddet	  			= document.getElementById("iddet").value;
		var v  					= document.getElementById("v").value;
        
if(txtphonenoadd1!='' )

		if((txtphonenoadd1!='' && txtphonenoteadd1=='') || (txtphonenoadd1=='' && txtphonenoteadd1!='')){
			alert("Phone 1 / Desc Empty !");
			return false;
		}else
		if((txtphonenoadd2!='' && txtphonenoteadd2=='') || (txtphonenoadd2=='' && txtphonenoteadd2!='')){
			alert("Phone 2 / Desc Empty !");
			return false;
		}else
		if((txtphonenoadd3!='' && txtphonenoteadd3=='') || (txtphonenoadd3=='' && txtphonenoteadd3!='')){
			alert("Phone 3 / Desc Empty !");
			return false;
		}else
		if((txtphonenoadd4!='' && txtphonenoteadd4=='') || (txtphonenoadd4=='' && txtphonenoteadd4!='')){
			alert("Phone 4 / Desc Empty !");
			return false;
		}else
		if((txtphonenoadd5!='' && txtphonenoteadd5=='') || (txtphonenoadd5=='' && txtphonenoteadd5!='')){
			alert("Phone 5 / Desc Empty !");
			return false;
		}else
		if((txtphonenoadd6!='' && txtphonenoteadd6=='') || (txtphonenoadd6=='' && txtphonenoteadd6!='')){
			alert("Phone 6 / Desc Empty !");
			return false;
		}else{

			var data = "?txt_task_id="+txt_task_id+"&txtphonenoadd1="+txtphonenoadd1+"&txtphonenoteadd1="+txtphonenoteadd1+"&txtphonenoadd2="+txtphonenoadd2+"&txtphonenoteadd2="+txtphonenoteadd2+"&txtphonenoadd3="+txtphonenoadd3+"&txtphonenoteadd3="+txtphonenoteadd3+"&txtphonenoadd4="+txtphonenoadd4+"&txtphonenoteadd4="+txtphonenoteadd4+"&txtphonenoadd5="+txtphonenoadd5+"&txtphonenoteadd5="+txtphonenoteadd5+"&txtphonenoadd6="+txtphonenoadd6+"&txtphonenoteadd6="+txtphonenoteadd6+"&iddet="+iddet+"&v="+v;
			$.ajax({
				type: 'POST',
				url: "view/telesales/tele_penawaran_addon_phone_save.php"+data,
				success: function(hv) {
					//alert(hv);
					alert("Insert Add Phone No Success");
					window.location.href = "index.php?v="+hv;

					return false;
				}
			});

		}

		return false;

	}

	function save_addassets_dialog(){
		    var txt_asset_type        	= $('#txt_asset_type').val();
		    var txt_asset_name        	= $('#txt_asset_name').val();
		    var txt_asset_type_desc     = $('#txt_asset_type_desc').val();
		    var txt_asset_desc        	= $('#txt_asset_desc').val();
		    var txt_mesin_no        	= $('#txt_mesin_no').val();
		    var txt_license_plate       = $('#txt_license_plate').val();
		    var txt_chasis_no        	= $('#txt_chasis_no').val();
		    var txt_manufacturing_year  = $('#txt_manufacturing_year').val();
		    var txt_asset_ownership     = $('#txt_asset_ownership').val();
		    var txt_prod_offering       = $('#txt_prod_offering').val();
		    var txt_price_amt        	= $('#txt_price_amt').val();
		    var txt_platfond_max        = $('#txt_platfond_max').val();
		    var txt_tenor        		= $('#txt_tenor').val();
		    var txt_ltv        			= $('#txt_ltv').val();
		    var txt_installment        	= $('#txt_installment').val();
		    var txt_ltv_persen        	= $('#txt_ltv_persen').val();
		    var iddata					= "<?php echo $iddet; ?>";
		    var task_id        	        = $('#txt_task_id').val();
	 //        var num1 = parseInt(txtestimasiterima.replace(/\D/g,''));
	 //        var num2 = parseInt(txtotr.replace(/\D/g,''));
	        
	 //        if(num1>num2){
	 //            // alert("Estimasi Terima Bersih harus lebih dari nilai OTR");
	 //            alert("Estimasi Terima Bersih tidak boleh lebih dari nilai OTR");
	 //        }else{

	 //        if(cmbkategoryproduct!="" && txtassetname!="" && txtbpkbname!=""
	 //        && txtitemyear!="" && txtotr!="" && txtestimasiterima!="" && txttenor!="" && txtangsuran!=""){
				$.ajax({
					url: "view/telesales/save_add_assets.php",
					type: "POST",
					data: {
	                    iddata					: iddata,
	                    task_id                 : task_id,
						txt_asset_type        	: txt_asset_type,
					    txt_asset_name        	: txt_asset_name,
					    txt_asset_type_desc     : txt_asset_type_desc,
					    txt_asset_desc        	: txt_asset_desc,
					    txt_mesin_no        	: txt_mesin_no,
					    txt_license_plate       : txt_license_plate,
					    txt_chasis_no        	: txt_chasis_no,
					    txt_manufacturing_year  : txt_manufacturing_year,
					    txt_asset_ownership     : txt_asset_ownership,
					    txt_prod_offering       : txt_prod_offering,
					    txt_price_amt        	: txt_price_amt,
					    txt_platfond_max        : txt_platfond_max,
					    txt_tenor        		: txt_tenor,
					    txt_ltv        			: txt_ltv,
					    txt_installment        	: txt_installment,
					    txt_ltv_persen        	: txt_ltv_persen		
					},
					cache: false,
					success: function(dataResult){
						var dataResult = JSON.parse(dataResult);
                      // alert(dataResult.id_add_asset);
						if(dataResult.statusCode==200){
							//$("#btnsaveassetsadd").removeAttr("disabled");
							//$('#fupForm').find('input:text').val('');
	                        var id_add_asset = dataResult.id_add_asset;
                        // alert(id_add_asset);
	                        var add_asset_id= document.getElementById("add_asset_id").value;
	                        if (add_asset_id=="") {
	                            document.getElementById("add_asset_id").value=id_add_asset; 
	                       }else{
	                            id_add_asset = add_asset_id+","+id_add_asset;
	                            document.getElementById("add_asset_id").value=id_add_asset;
	                       }
	                        alert("Data added successfully !");
							$("#success").show();
							$('#success').html('Data added successfully !'); 	
	                        var iddata = dataResult.iddata;
                            var txt_task_id = dataResult.txt_task_id;
                           // alert(iddata);
	                        $("#tableassetsload").load("view/telesales/get_asset_list.php?txt_task_id="+txt_task_id);

						}
						else if(dataResult.statusCode==201){
						   alert("Error occured !");
						}
						//return false;
					}
				});
		// 	}
		// 	else{
		// 		alert('Please fill all the field !');
		// 	}

	 //    }

		// return false;
		// alert("xxx");
	};

	
	function call_execute(AssignId){
		var ipserver	    = '<?php echo $ws_ip?>';
		var SesExt   	  	= '<?php echo get_session("v_extension")?>';
		var SesLoginId    	= '<?php echo get_session("v_agentlogin")?>';
		var SesClientId   	= '<?php echo $ws_cliendID?>';
		//var AssignId      = 
		var PhoneNoCall     = document.getElementById("cmb_phone_no").value;
		var PhoneNoCall     = PhoneNoCall.trim();
		document.getElementById("dialedno").value = PhoneNoCall;
		/*
		var urlser = ipserver+"/makecall?loginid="+SesLoginId+"&phoneno="+PhoneNoCall+"&assignid="+AssignId
	   	$.ajax({
			type: "POST",
			url: urlser
		});
		*/
		var userstatusid = document.getElementById("userstatusid").value;
		var urlser = ipserver+"/makecall?loginid="+SesLoginId+"&phoneno="+PhoneNoCall+"&assignid="+AssignId
		var urlout = ipserver+"/outbound?loginid="+SesLoginId
		alert(PhoneNoCall);
		if(isNaN(PhoneNoCall)){
			    alert("inputan salah: harus angka");
			}
		if(userstatusid==10){
			//jika sudah outbound 
			if(isNaN(PhoneNoCall)){
			    alert("inputan salah: harus angka");
			}else{
				$.ajax({
				    type: "POST",
					url: urlser
				});
			}
			

		}else{
			//jika belum outbound 
			$.ajax({
				url: urlout,
				type: "POST",
				dataType: 'json',
				success: function(data){
					var datares = data.RespondStatus;
					if(datares=="Success"){
						$.ajax({
							type: "POST",
							url: urlser
						});
					}
				}
			});

		}
	
	}
	$("#btncallcust").click(function(){
		var ref 	  = document.getElementById("txt_task_id").value;
		var iddet	  = document.getElementById("iddet").value;
		var v_agentid = '<?php echo get_session("v_agentid") ?>';
		$.ajax({
			type:'GET',
			url:'view/telesales/out_tele_call_generator.php',
			data:'ref=' + ref + '&iddet=' + iddet + '&agentid='+v_agentid,
			success:function(html){
				if (html == 'false') {
					alert('Failed');
				}else{
					document.getElementById('references_id').value = html;
					call_execute(html);
				}
				
			}
		});
	    	 
    });

	var form = $( "#frmDataDet" );
	form.validate();

    $("#btnSaveForm").click(function(){ 
		var fvalid = form.valid();
		var param_warm = "Please fill in all mandatory";

		var prm_pro_offering= document.getElementById("param_pro_offering").value;
		var prm_IS_PRE_APPROVAL= document.getElementById("txt_IS_PRE_APPROVAL").value;
		var param_agrmnt = "<?php echo $all_agrmt_on ?>";
		var param_iddet = document.getElementById("iddet").value;
		var cmbcallstatus= document.getElementById("txt_activity_result").value;
		var check_agrmnt = document.getElementById("txt_check_agrmnt").value;
		var param_check_agrmnt = document.getElementById("param_check_agrmnt").value;
		var url = "http://10.1.49.250/wom/index.php?v=dGVsZXNhbGVzfHRlbGVfY3VzdG9tZXJfZGF0YV9saXN0fEN1c3RvbWVyIERhdGF8MTU2fA%3D%3D";  
		var url2=url;  
		url += '&param='+param_iddet;
		var param_total = <?php echo $tot_on ?>;
		var param_call=0;
		if (cmbcallstatus=="5"||cmbcallstatus=="6") {
			param_call=1;
		}
    	if (cmbcallstatus=="1"||cmbcallstatus=="2") {
    	 	if (check_agrmnt ==0) {
    	 		if (param_check_agrmnt==1) {
    	 			fvalid=false;
    	 			param_warm = "Please check Agreement List";
    	 		}
    	 	}

    	 	var txt_tot_asset= document.getElementById("txt_tot_asset").value;
    	 	var add_asset_id= document.getElementById("add_asset_id").value;
    	 	if (add_asset_id!='' && txt_tot_asset ==0) {
    	 		txt_tot_asset =1;
    	 	}
    	 	if (txt_tot_asset ==0) {
    	 		// fvalid=false;
    	 		// param_warm = "Please add asset first";
    	 		// $('#addnewassetpop').modal('show');
    	 		// var taskid_asset = document.getElementById("txt_task_id").value;
		 		// $('#main_addnewasset').load('view/telesales/get_add_new_assets.php?taskid_asset='+taskid_asset);
    	 	}

    	 	var txt_legal_address= document.getElementById("txt_legal_address").value;
    	 	var txt_survey_addr= document.getElementById("txt_survey_addr").value;
    	 	var three_pro_offering= document.getElementById("three_pro_offering").value;
    	 	var mlob= document.getElementById("mlob").value;
    	 	if (txt_legal_address=='') {// && !='' && !='' && !=''
    	 		fvalid=false;
    	 		param_warm = "Please input Legal Address";
    	 	}

    	 	var txt_legal_kab= document.getElementById("txt_legal_kab").value;
    	 	if (txt_legal_kab=='') {// && !='' && !='' && !=''
    	 		fvalid=false;
    	 		param_warm = "Please input Legal Kabupaten";
    	 	}
    	 	var txt_legal_zipcode= document.getElementById("txt_legal_zipcode").value;
    	 	if (txt_legal_zipcode=='') {// && !='' && !='' && !=''
    	 		fvalid=false;
    	 		param_warm = "Please input Legal Zip Code";
    	 	}
    	 	var txt_legal_rt= document.getElementById("txt_legal_rt").value;
    	 	if (txt_legal_rt=='') {// && !='' && !='' && !=''
    	 		fvalid=false;
    	 		param_warm = "Please input Legal RT";
    	 	}
    	 	var txt_legal_kec= document.getElementById("txt_legal_kec").value;
    	 	if (txt_legal_kec=='') {// && !='' && !='' && !=''
    	 		fvalid=false;
    	 		param_warm = "Please input Legal Kecamatan";
    	 	}
    	 	var txt_legal_sub_zipcode= document.getElementById("txt_legal_sub_zipcode").value;
    	 	if (txt_legal_sub_zipcode=='') {// && !='' && !='' && !=''
    	 		fvalid=false;
    	 		param_warm = "Please input Legal Sub Zip Code";
    	 	}
    	 	var txt_legal_rw= document.getElementById("txt_legal_rw").value;
    	 	if (txt_legal_rw=='') {// && !='' && !='' && !=''
    	 		fvalid=false;
    	 		param_warm = "Please input Legal RW";
    	 	}
    	 	var txt_legal_kelurahan= document.getElementById("txt_legal_kelurahan").value;
    	 	if (txt_legal_kelurahan=='') {// && !='' && !='' && !=''
    	 		fvalid=false;
    	 		param_warm = "Please input Legal Kelurahan";
    	 	}
    	 	var txt_legal_prov= document.getElementById("txt_legal_prov").value;
    	 	if (txt_legal_prov=='') {// && !='' && !='' && !=''
    	 		fvalid=false;
    	 		param_warm = "Please input Legal Province";
    	 	}

    	 	if (txt_survey_addr=='') {
    	 		fvalid=false;
    	 		param_warm = "Please input Survey Address";
    	 	}
    	 	var txt_survey_kab= document.getElementById("txt_survey_kab").value;
    	 	if (txt_survey_kab=='') {// && !='' && !='' && !=''
    	 		fvalid=false;
    	 		param_warm = "Please input Survey Kabupaten";
    	 	}
    	 	var txt_survey_subzipcode= document.getElementById("txt_survey_subzipcode").value;
    	 	if (txt_survey_subzipcode=='') {// && !='' && !='' && !=''
    	 		fvalid=false;
    	 		param_warm = "Please input Survey Sub Zip Code";
    	 	}
    	 	var txt_survey_rt= document.getElementById("txt_survey_rt").value;
    	 	if (txt_survey_rt=='') {// && !='' && !='' && !=''
    	 		fvalid=false;
    	 		param_warm = "Please input Survey RT";
    	 	}
    	 	var txt_survey_kec= document.getElementById("txt_survey_kec").value;
    	 	if (txt_survey_kec=='') {// && !='' && !='' && !=''
    	 		fvalid=false;
    	 		param_warm = "Please input Survey Kecamatan";
    	 	}
    	 	var txt_survey_houseowner= document.getElementById("txt_survey_houseowner").value;
    	 	if (txt_survey_houseowner=='') {// && !='' && !='' && !=''
    	 		fvalid=false;
    	 		param_warm = "Please input House Ownership";
    	 	}
    	 	var txt_survey_rw= document.getElementById("txt_survey_rw").value;
    	 	if (txt_survey_rw=='') {// && !='' && !='' && !=''
    	 		fvalid=false;
    	 		param_warm = "Please input Survey RW";
    	 	}
    	 	var txt_survey_kelurahan= document.getElementById("txt_survey_kelurahan").value;
    	 	if (txt_survey_kelurahan=='') {// && !='' && !='' && !=''
    	 		fvalid=false;
    	 		param_warm = "Please input Survey Kelurahan";
    	 	}
    	 	var txt_survey_domicile= document.getElementById("txt_survey_domicile").value;
    	 	if (txt_survey_domicile=='') {// && !='' && !='' && !=''
    	 		fvalid=false;
    	 		param_warm = "Please input Length of Domicile";
    	 	}
    	 	var txt_survey_prov= document.getElementById("txt_survey_prov").value;
    	 	if (txt_survey_prov=='') {// && !='' && !='' && !=''
    	 		fvalid=false;
    	 		param_warm = "Please input >Survey Province";
    	 	}
    	 	var txt_survey_zipcode= document.getElementById("txt_survey_zipcode").value;
    	 	if (txt_survey_zipcode=='') {// && !='' && !='' && !=''
    	 		fvalid=false;
    	 		param_warm = "Please input Survey Zip Code";
    	 	}


    	 	if (three_pro_offering=='') {
    	 		fvalid=false;
    	 		param_warm = "Please input Product Offering";
    	 	}
    	 	if (mlob=='') {
    	 		fvalid=false;
    	 		param_warm = "Please input LOB";
    	 	}
    	}
		var cmbphoneno= document.getElementById("cmb_phone_no").value;
		if (cmbphoneno =="") {
			fvalid=false;
			param_warm = "Please choice phone no";
		}
    	 
    	 // if (prm_pro_offering=='1') {
    	 	prm_IS_PRE_APPROVAL=0;
    	if (prm_IS_PRE_APPROVAL=='1') {
    		console.log("approve");

    	 	var prm_agrmnt_no      = document.getElementById("agrmnt_no").value;
    	 	var prm_install        = document.getElementById("three_calcu_install").value;
    	 	var prm_houseowner     = document.getElementById("txt_survey_houseowner").value;
    	 	var prm_cust_rating    = document.getElementById("cust_rating").value;
    	 	var prm_mfr_year    = document.getElementById("three_mfr_year").value;
    	 								


			// var urlduplicate	   = "service/wom/check_duplicate.php?nik="+nik+"&nama_lengkap="+nama_lengkap+"&tempat_lahir="+tempat_lahir+"&tgl_lahir="+tgl_lahir;
			document.getElementById('tempatLoading').style.display = "";
			var urlduplicate	   = "service/wom/check_validate_wsc.php?agrmnt_no="+prm_agrmnt_no+"&cust_rating="+prm_cust_rating+"&instamt="+prm_install+"&houseowner="+prm_houseowner+"&mfr_year="+prm_mfr_year;
			if("<?php echo $mode; ?>"=="es"){
				alert(urlduplicate);
			}
	    	 
					// fvalid=true;//alert("xx");
					// xx		
					if(fvalid==true){
						document.getElementById('tempatLoading').style.display = "none";

				    	swal({
										title: 'Are you sure want to save?',
										text: "",
										type: 'warning',
										buttons:{
											confirm: {
												text : 'Yes',
												className : 'btn btn-success'
											},
											cancel: {
												visible: true,
												className: 'btn btn-danger'
											}
										}
									}).then((Save) => {
										if (Save) {
											document.getElementById('tempatLoading').style.display = "";
											 var data = new FormData();
											 var form_data = $('#frmDataDet').serializeArray();
											 $.each(form_data, function (key, input) {
											    data.append(input.name, input.value);
											 });

											 data.append('key', 'value');
											 data.append('param_agrmnt', param_agrmnt);	
											 // document.getElementById('tempatLoading').style.display = "";
											 $.ajax({
										        url: "<?php echo $save_form; ?>",
										        type: "post",
										        data: data,
											    processData: false,
											    contentType: false,
										        success: function(d) {
										        	var warn = d;
									            	if(warn=="Success!") {
									            		var nik            = document.getElementById("txt_id_no").value;
														var nama_lengkap   = document.getElementById("txt_customer_name").value;
														var tempat_lahir   = document.getElementById("txt_birth_place").value;
														var tgl_lahir      = document.getElementById("txt_birth_date").value;
														var check_agrmnt   = document.getElementById("txt_check_agrmnt").value; 
				    	 								var param_check_agrmnt = document.getElementById("param_check_agrmnt").value;
				    	 								var prm_agrmnt_no      = document.getElementById("agrmnt_no").value;
				    	 								var prm_install        = document.getElementById("three_calcu_install").value;
				    	 								var prm_houseowner     = document.getElementById("txt_survey_houseowner").value;
				    	 								var prm_cust_rating    = document.getElementById("cust_rating").value;
				    	 								var prm_mfr_year    = document.getElementById("three_mfr_year").value;
				    	 								


														// var urlduplicate	   = "service/wom/check_duplicate.php?nik="+nik+"&nama_lengkap="+nama_lengkap+"&tempat_lahir="+tempat_lahir+"&tgl_lahir="+tgl_lahir;
														var urlduplicate	   = "service/wom/check_validate_wsc.php?agrmnt_no="+prm_agrmnt_no+"&cust_rating="+prm_cust_rating+"&instamt="+prm_install+"&houseowner="+prm_houseowner+"&mfr_year="+prm_mfr_year;
																		var taskid         = "<?=$txt_task_id;?>";
																		var agrmntid       = "<?=$agrmntid;?>";
														            	if (taskid != "") {
									            							
															            	var urlupdatepolo  = "service/wom/api_fin_update_data_new.php?taskId="+taskid+"&check_agrmnt="+check_agrmnt;
																			$.ajax({
																					url: urlupdatepolo,
																					type: "POST",
																					dataType: 'json',
																					success: function(data){ 
																						document.getElementById('tempatLoading').style.display = "none";
																						var datares = data.responseMessage; 
																						var datares2 = data.errorMessage;
																						if (datares=='SUCCESS') {
																							// alert(datares);
																							var vtype = "success";
																							swal({ title: "Save Data!", type: vtype,  text: warn,   timer: 1000,   showConfirmButton: false });
																							if (param_total>1) {
																								if (param_call==1) {
																									setTimeout(function(){ window.location.href = url2; }, 1500);
																								}else{
																									setTimeout(function(){ window.location.href = url; }, 1500);
																								}
																							}else{
																								setTimeout(function(){ window.location.href = url2; }, 1500);//document.location.reload();
																							}
															            					
						 																	 
																						}else{
																							alert(datares);
																							document.getElementById('tempatLoading').style.display = "none";
																							swal({ title: "Save Data!", type: vtype,  text: datares,   timer: 1500,   showConfirmButton: false });
																						}		
																						// document.location.reload();																	
																					}
																			});		
														            	}else{
																			var urlinsertpolo  = "service/wom/api_fin_insert_data_new.php?agrmntid="+agrmntid+"&check_agrmnt="+check_agrmnt;
																			$.ajax({
																					url: urlinsertpolo,
																					type: "POST",
																					dataType: 'json',
																					success: function(data){ 
																						document.getElementById('tempatLoading').style.display = "none";
																						var datares = data.responseMessage; 
																						var datares2 = data.errorMessage;
																						if (datares=='SUCCESS') {
																							// alert(datares);
																							var vtype = "success";
																							swal({ title: "Save Data!", type: vtype,  text: warn,   timer: 1000,   showConfirmButton: false });
															            					// setTimeout(function(){ document.location.reload(); }, 1500);
																							if (param_total>1) {
																								setTimeout(function(){ window.location.href = url; }, 1500);
																							}else{
																								setTimeout(function(){ window.location.href = url2; }, 1500);//document.location.reload();
																							}
															            					
																						}else{
																							// alert(datares2);
																							document.getElementById('tempatLoading').style.display = "none";
																							swal({ title: "Save Data!", type: vtype,  text: datares2,   timer: 1500,   showConfirmButton: false });
																						}		
																						// document.location.reload();																	
																					}
																			});
														            	}
														// 			}												
														// 		}
														// });	
									            		var vtype = "success";
									            	} else {
														var vtype = "error";
														swal({ title: "Save Data!", type: vtype,  text: warn,   timer: 1000,   showConfirmButton: false });
									            	}
										        }
											  });
										} else {
											swal.close();
										}
									});
							
						}else{
							document.getElementById('tempatLoading').style.display = "none";
							swal({ title: "Info!", type: "error",  text: param_warm,   timer: 1000,   showConfirmButton: false });
						}										
			//  	}
			// });		
    	 }
    	 else{
	    	 if(fvalid==true){

	    	swal({
							title: 'Are you sure want to save?',
							text: "",
							type: 'warning',
							buttons:{
								confirm: {
									text : 'Yes',
									className : 'btn btn-success'
								},
								cancel: {
									visible: true,
									className: 'btn btn-danger'
								}
							}
						}).then((Save) => {
							if (Save) {
								 var data = new FormData();
								 var form_data = $('#frmDataDet').serializeArray();
								 $.each(form_data, function (key, input) {
								    data.append(input.name, input.value);
								 });

								 data.append('key', 'value');
								 data.append('param_agrmnt', param_agrmnt);	
								 document.getElementById('tempatLoading').style.display = "";
								 $.ajax({
							        url: "<?php echo $save_form; ?>",
							        type: "post",
							        data: data,
								    processData: false,
								    contentType: false,
							        success: function(d) {
							        	var warn = d;
						            	if(warn=="Success!") {
						            		var nik            = document.getElementById("txt_id_no").value;
											var nama_lengkap   = document.getElementById("txt_customer_name").value;
											var tempat_lahir   = document.getElementById("txt_birth_place").value;
											var tgl_lahir      = document.getElementById("txt_birth_date").value;
											var check_agrmnt   = document.getElementById("txt_check_agrmnt").value; 
	    	 								var param_check_agrmnt = document.getElementById("param_check_agrmnt").value;
	    	 								var prm_agrmnt_no      = document.getElementById("agrmnt_no").value;
	    	 								var prm_install        = document.getElementById("three_calcu_install").value;
	    	 								var prm_houseowner     = document.getElementById("txt_survey_houseowner").value;
	    	 								var prm_cust_rating    = document.getElementById("cust_rating").value;
	    	 								var prm_mfr_year    = document.getElementById("three_mfr_year").value;
	    	 								


											// var urlduplicate	   = "service/wom/check_duplicate.php?nik="+nik+"&nama_lengkap="+nama_lengkap+"&tempat_lahir="+tempat_lahir+"&tgl_lahir="+tgl_lahir;
											var urlduplicate	   = "service/wom/check_validate_wsc.php?agrmnt_no="+prm_agrmnt_no+"&cust_rating="+prm_cust_rating+"&instamt="+prm_install+"&houseowner="+prm_houseowner+"&mfr_year="+prm_mfr_year;
											// $.ajax({
											// 		url: urlduplicate,
											// 		type: "POST",
											// 		dataType: 'json',
											// 		success: function(data){ 
											// 			var datares  = data.duplicateStatus;
											// 			var datares2 = data.responseMessage;
											// 			var datares3 = data.data;
											// 			var datares4 = datares3.duplicateStatus;
											// 			if (datares3=='NOT ELIGIBLE WSC') {
											// 				document.getElementById('tempatLoading').style.display = "none";
											// 				var vtype = "error";
											// 				swal({ title: "Save Data!", type: vtype,  text: "Warning Notification: NOT ELIGIBLE WSC",   timer: 1000,   showConfirmButton: false });

											// 			}//else if (datares4=='NOT MATCH'){
											// 				else{
															var taskid         = "<?=$txt_task_id;?>";
															var agrmntid       = "<?=$agrmntid;?>";
    	 													var paramdate= document.getElementById("paramdate").value;
    	 													// if (paramdate==0) {
	    	 													if (taskid != "") {
							            							
													            	var urlupdatepolo  = "service/wom/api_fin_update_cust_data_new.php?taskId="+taskid+"&check_agrmnt="+check_agrmnt;
																	$.ajax({
																			url: urlupdatepolo,
																			type: "POST",
																			dataType: 'json',
																			success: function(data){ 
																				document.getElementById('tempatLoading').style.display = "none";
																				var datares = data.responseMessage; 
																				var datares2 = data.errorMessage;
																				if (datares=='SUCCESS') {
																					// alert(datares);
																					var vtype = "success";
																					swal({ title: "Save Data!", type: vtype,  text: warn,   timer: 1000,   showConfirmButton: false });
																					if (param_total>1) {
																						if (param_call==1) {
																							setTimeout(function(){ window.location.href = url2; }, 1500);
																						}else{
																							setTimeout(function(){ window.location.href = url; }, 1500);
																						}
																					}else{
																						setTimeout(function(){ window.location.href = url2; }, 1500);//document.location.reload();
																					}
													            					
				 																	 
																				}else if(datares=="STATE_NOT_TASK_SLA"){
																					var urlupdatepolo  = "service/wom/api_fin_update_crm_sla.php?taskId="+taskid+"&check_agrmnt="+check_agrmnt;
																					$.ajax({
																							url: urlupdatepolo,
																							type: "POST",
																							dataType: 'json',
																							success: function(data){ 
																								document.getElementById('tempatLoading').style.display = "none";
																								var datares = data.responseMessage; 
																								var datares2 = data.errorMessage;
																								if (datares=='SUCCESS') {
																									// alert(datares);
																									var vtype = "success";
																									swal({ title: "Save Data!", type: vtype,  text: warn,   timer: 1000,   showConfirmButton: false });
																									if (param_total>1) {
																										if (param_call==1) {
																											setTimeout(function(){ window.location.href = url2; }, 1500);
																										}else{
																											setTimeout(function(){ window.location.href = url; }, 1500);
																										}
																									}else{
																										setTimeout(function(){ window.location.href = url2; }, 1500);//document.location.reload();
																									}
																	            					
								 																	 
																								}else{
																									// alert("datares2");
																									document.getElementById('tempatLoading').style.display = "none";
																									swal({ title: "Save Data!", type: vtype,  text: datares2,   timer: 1500,   showConfirmButton: false });
																								}	
																								// document.location.reload();																	
																							}
																					});	
																				}else{
																					// alert("datares2");
																					document.getElementById('tempatLoading').style.display = "none";
																					swal({ title: "Save Data!", type: vtype,  text: datares2,   timer: 1500,   showConfirmButton: false });
																				}	
																				// document.location.reload();																	
																			}
																	});		
												            	}else{
													    //         	var urlinsertpolo  = "service/wom/api_fin_insert_data_new.php?agrmntid="+agrmntid;
																	// $.ajax({
																	// 		url: urlinsertpolo,
																	// 		type: "POST",
																	// 		dataType: 'json',
																	// 		success: function(data){ 
																	// 			// document.getElementById('tempatLoading').style.display = "none";
																	// 			var datares = data.responseMessage; 
																	// 			var datares2 = data.errorMessage;
																	// 			var datares3 = data.data;
																	// 			if (datares=='SUCCESS') {
																	//             	var urlupdatepolo  = "service/wom/api_fin_update_data_new.php?taskId="+datares3;
																	// 				$.ajax({
																	// 						url: urlupdatepolo,
																	// 						type: "POST",
																	// 						dataType: 'json',
																	// 						success: function(data){ 
																	// 							document.getElementById('tempatLoading').style.display = "none";
																	// 							var datares = data.responseMessage; 
																	// 							var datares2 = data.errorMessage;
																	// 							if (datares=='SUCCESS') {
																	// 								// alert(datares);
																	// 								var vtype = "success";
																	// 								swal({ title: "Save Data!", type: vtype,  text: warn,   timer: 1000,   showConfirmButton: false });
																	//             					setTimeout(function(){ document.location.reload(); }, 1500);
																	// 							}else{
																	// 								// alert(datares2);
																	// 								document.getElementById('tempatLoading').style.display = "none";
																	// 								swal({ title: "Save Data!", type: vtype,  text: datares2,   timer: 1500,   showConfirmButton: false });
																	// 							}		
																	// 							// document.location.reload();																	
																	// 						}
																	// 				});	
																	// 			}else{
																	// 				// alert(datares2);
																	// 				document.getElementById('tempatLoading').style.display = "none";
																	// 				swal({ title: "Save Data!", type: vtype,  text: datares2,   timer: 1500,   showConfirmButton: false });
																	// 			}		
																	// 			// document.location.reload();																	
																	// 		}
																	// });
																	var urlinsertpolo  = "service/wom/api_fin_insert_data_new.php?agrmntid="+agrmntid+"&check_agrmnt="+check_agrmnt;
																	$.ajax({
																			url: urlinsertpolo,
																			type: "POST",
																			dataType: 'json',
																			success: function(data){ 
																				document.getElementById('tempatLoading').style.display = "none";
																				var datares = data.responseMessage; 
																				var datares2 = data.errorMessage;
																				if (datares=='SUCCESS') {
																					// alert(datares);
																					var vtype = "success";
																					swal({ title: "Save Data!", type: vtype,  text: warn,   timer: 1000,   showConfirmButton: false });
													            					// setTimeout(function(){ document.location.reload(); }, 1500);
																					if (param_total>1) {
																						setTimeout(function(){ window.location.href = url; }, 1500);
																					}else{
																						setTimeout(function(){ window.location.href = url2; }, 1500);//document.location.reload();
																					}
													            					
																				}else{
																					// alert(datares2);
																					document.getElementById('tempatLoading').style.display = "none";
																					swal({ title: "Save Data!", type: vtype,  text: datares2,   timer: 1500,   showConfirmButton: false });
																				}		
																				// document.location.reload();																	
																			}
																	});
												            	}	
    	 													// }else{
    	 													// 	document.getElementById('tempatLoading').style.display = "none";
    	 													// }
											            	
											// 			}												
											// 		}
											// });	
						            		var vtype = "success";
						            	} else {
											var vtype = "error";
											swal({ title: "Save Data!", type: vtype,  text: warn,   timer: 1000,   showConfirmButton: false });
						            	}
							        }
								  });
							} else {
								swal.close();
							}
						});
				
			}else{
				swal({ title: "Info!", type: "error",  text: param_warm,   timer: 1000,   showConfirmButton: false });
			}
			}
	        return false;
		}) 


    $("#btnSaveCustomer").click(function(){ 
    	 var fvalid = form.valid();
    	 if(fvalid==true){

    	swal({
						title: 'Are you sure want to save?',
						text: "",
						type: 'warning',
						buttons:{
							confirm: {
								text : 'Yes',
								className : 'btn btn-success'
							},
							cancel: {
								visible: true,
								className: 'btn btn-danger'
							}
						}
					}).then((Save) => {
						if (Save) {
							 var data = new FormData();
							 var form_data = $('#frmDataDet').serializeArray();
							 $.each(form_data, function (key, input) {
							    data.append(input.name, input.value);
							 });

							 data.append('key', 'value');	
							
							 $.ajax({
						        url: "<?php echo $save_form2; ?>",
						        type: "post",
						        data: data,
							    processData: false,
							    contentType: false,
						        success: function(d) {
						        	var warn = d;
					            	if(warn=="Success!") {
					            		var vtype = "success";
					            	} else {
										var vtype = "error";	
					            	}
						            swal({ title: "Save Data!", type: vtype,  text: warn,   timer: 1000,   showConfirmButton: false });
						            if(warn=="Success") {
						            	//setTimeout(function(){history.back();}, 1500);
						            	setTimeout(function(){ document.location.reload(); }, 1500);
						            } 
						        }
							  });
						} else {
							swal.close();
						}
					});
			
		}else{
			swal({ title: "Info!", type: "error",  text: "Please fill in all mandatory",   timer: 1000,   showConfirmButton: false });
		}
        return false;
	}) 

	$("#txt_activity_result").change(function() {
			  var call_status    = $("#txt_activity_result").val();
			  var dataString = 'call_statusid='+call_status+'&v=call_status';
			  	if(call_status==1) {
					var stat = document.getElementsByClassName('stat-prospect');
					var sval = document.getElementsByClassName('val-prospect');
					$('.val-prospect').attr('required', true)[0]; 
					for (let index = 0; index < stat.length; index++) {
						stat[index].style.display = "contents";
					}
				} else {
					var stat = document.getElementsByClassName('stat-prospect');
					$('.val-prospect').attr('required', false)[0]; 
					for (let index = 0; index < stat.length; index++) {
						stat[index].style.display = "none";
					}
				}
			  if (call_status==4) {
			  	$("#div_followup").show();
			  }else{
			  	$("#div_followup").hide();
			  }
				$.ajax({ 
			      type: 'POST', 
			      url: 'view/telesales/get_data_value.php', 
			      data: dataString, 
			      dataType:'json',
			      success: function (data) { 
			        $('#txt_activity_substatuscall').html(data.arr_category);
					document.getElementById('txtcalllater').parentNode.parentNode.style.display = "none";
			      }
			      
			  });
		 });


	$("#mlob").change(function() {
		var mlob    = $("#mlob").val();
		var dataString = 'mlob='+mlob+'&v=mlob';
		$.ajax({ 
		    type: 'POST', 
		    url: 'view/telesales/get_data_value.php', 
		    data: dataString, 
		    dataType:'json',
		    success: function (data) { 
				$('#three_pro_offering').html(data.arr_category);
		    }
			      
		});
	});


	$("#three_pro_offering").change(function() {
		var pro_offering    = $("#three_pro_offering").val();
		var dataString = 'pro_offering='+pro_offering+'&v=pro_offering2';
		$.ajax({ 
		    type: 'POST', 
		    url: 'view/telesales/get_data_value.php', 
		    data: dataString, 
		    dataType:'json',
		    success: function (data) { 
				document.getElementById("param_pro_offering").value = data;
		    }
			      
		});
	});



		$("#btn_duckcapil").click(function() {
			var nik            = document.getElementById("txt_id_no").value;
			var nama_lengkap   = document.getElementById("txt_customer_name").value;
			var tempat_lahir   = document.getElementById("txt_birth_place").value;
			var tgl_lahir      = document.getElementById("txt_birth_date").value; //06-07-1987
			var user_name      = document.getElementById("txt_spouse_name").value;
			var emp_name       = document.getElementById("txt_job_profname").value;
			var office_code    = '';//document.getElementById("two_cabang_code").value;
			var office_name    = '';//document.getElementById("two_cabang_name").value;
			var region         = '';//document.getElementById("two_region_name").value; //1
			var cust_no        = document.getElementById("txt_customer_no").value;
			var IS_PRE_APPROVAL= document.getElementById("txt_IS_PRE_APPROVAL").value;
			// var app_no         = '';
			var app_no         = document.getElementById("txt_task_id").value;
			var ip_user        = '';
			var source         = document.getElementById("txt_sumber_data").value;

			document.getElementById('tempatDukcapil').style.display = "";

			var urldukcapil	   = "service/wom/check_dukcapil_new.php?nik="+nik+"&nama_lengkap="+nama_lengkap+"&tempat_lahir="+tempat_lahir+"&tgl_lahir="+tgl_lahir+"&user_name="+user_name+"&emp_name="+emp_name+"&office_code="+office_code+"&office_name="+office_name+"&region="+region+"&cust_no="+cust_no+"&app_no="+app_no+"&ip_user="+ip_user+"&source="+source+"&PreApproval="+IS_PRE_APPROVAL;
			if (nik.length == 16) {
			// document.getElementById('tempatDukcapil').style.display = "";
				$.ajax({
						url: urldukcapil,
						type: "POST",
						dataType: 'json',
						success: function(data){ 
							var urlcheckcust	   = "service/wom/check_negative.php?nik="+nik+"&nama_lengkap="+nama_lengkap+"&tempat_lahir="+tempat_lahir+"&tgl_lahir="+tgl_lahir+"&customer_id="+cust_no+"&source="+source+"&PreApproval="+IS_PRE_APPROVAL+"&app_no="+app_no;
							$.ajax({
									url: urlcheckcust,
									type: "POST",
									dataType: 'json',
									success: function(data2){ 
										// document.getElementById('tempatDukcapil').style.display = "none";
										var datares = data.FinalResult; 
										var datares2 = data.ResponseMessage;
										if (datares == 'Match') {
											alert("Result Dukcapil : "+datares);
											document.getElementById("txt_activity_ducapil").value = datares;
										}else if (datares == 'Not Match'){
											alert("Result Dukcapil : "+datares);
											document.getElementById("txt_activity_ducapil").value = datares;
										}else{
											alert("Result Dukcapil : "+datares);
											document.getElementById("txt_activity_ducapil").value = datares;
										}		

										var datarnegres  = data2.result; 
										var datarnegres2 = data2.negativeType;
										datarnegres      = datarnegres.replace("CUstomer", "Customer");
										if (datarnegres == 'Match') {
											alert("Result Neglist : "+datarnegres);
											document.getElementById("txt_activity_neglist").value = datarnegres;
										}else if (datarnegres == 'Not Match'){
											alert("Result Neglist : "+datarnegres);
											document.getElementById("txt_activity_neglist").value = datarnegres;
										}else{
											alert("Result Neglist : "+datarnegres);
											document.getElementById("txt_activity_neglist").value = datarnegres;
										}					
									}
							});	
													
						}
				});	

			}else{
				// document.getElementById('tempatDukcapil').style.display = "none";
				swal("NIK Tidak Sesuai", "NIK kurang/lebih dari 16 digit", "warning");
			}
			// wait(1);
			//start spouse
			var spouse_nik= document.getElementById("txt_spouse_nik").value;
			var spouse_name= document.getElementById("txt_spouse_name").value;
			var spouse_bod= document.getElementById("txt_spouse_birthdate").value;
			var spouse_bod_place= document.getElementById("txt_spouse_birthplace").value;

			if (spouse_nik!='') {
				var urldukcapil	   = "service/wom/check_dukcapil_new.php?nik="+spouse_nik+"&nama_lengkap="+spouse_name+"&tempat_lahir="+spouse_bod_place+"&tgl_lahir="+spouse_bod+"&app_no="+app_no+"&ip_user="+ip_user+"&source="+source+"&PreApproval="+IS_PRE_APPROVAL+"&app_no="+app_no;
				setTimeout(function() { 
				$.ajax({
						url: urldukcapil,
						type: "POST",
						dataType: 'json',
						success: function(data){ 
							var urlcheckcust	   = "service/wom/check_negative.php?nik="+spouse_nik+"&nama_lengkap="+spouse_name+"&tempat_lahir="+spouse_bod_place+"&tgl_lahir="+spouse_bod+"&source="+source+"&PreApproval="+IS_PRE_APPROVAL+"&app_no="+app_no;
							$.ajax({
									url: urlcheckcust,
									type: "POST",
									dataType: 'json',
									success: function(data2){ 
										// document.getElementById('tempatDukcapil').style.display = "none";
										var datares = data.FinalResult; 
										var datares2 = data.ResponseMessage;
										if (datares == 'Match') {
											alert("Result Spouse Dukcapil : "+datares);
											document.getElementById("txt_activity_pasangan_ducapil").value = datares;
										}else if (datares == 'Not Match'){
											alert("Result Spouse Dukcapil : "+datares);
											document.getElementById("txt_activity_pasangan_ducapil").value = datares;
										}else{
											// alert("Result Dukcapil : "+datares);
											document.getElementById("txt_activity_pasangan_ducapil").value = datares;
										}		

										var datarnegres  = data2.result; 
										var datarnegres2 = data2.negativeType;
										datarnegres      = datarnegres.replace("CUstomer", "Customer");
										// alert(datarnegres);
										if (datarnegres == 'Match') {
											alert("Result Spouse Neglist : "+datarnegres);
											document.getElementById("txt_activity_pasangan_neglist").value = datarnegres;
										}else if (datarnegres == 'Not Match' || datarnegres == 'NOT MATCH'){
											alert("Result Spouse Neglist : "+datarnegres);
											document.getElementById("txt_activity_pasangan_neglist").value = datarnegres;
										}else{
											// alert("Result Neglist : "+datarnegres);
											document.getElementById("txt_activity_pasangan_neglist").value = datarnegres;
										}					
									}
							});	
													
						}
				});	
				}, 1500);
			}
			
			//end spouse
			//start guarantor
			var guarantor_nik= document.getElementById("txt_guarantor_nik").value;
			var guarantor_name= document.getElementById("txt_guarantor_name").value;
			var guarantor_bod= document.getElementById("txt_guarantor_bod").value;
			var guarantor_bod_place= document.getElementById("txt_guarantor_bod_place").value;

			if (guarantor_nik!='') {
				var urldukcapil	   = "service/wom/check_dukcapil_new.php?nik="+guarantor_nik+"&nama_lengkap="+guarantor_name+"&tempat_lahir="+guarantor_bod_place+"&tgl_lahir="+guarantor_bod+"&app_no="+app_no+"&ip_user="+ip_user+"&source="+source+"&PreApproval="+IS_PRE_APPROVAL+"&app_no="+app_no;
				setTimeout(function() {
				$.ajax({
						url: urldukcapil,
						type: "POST",
						dataType: 'json',
						success: function(data){ 
							var urlcheckcust	   = "service/wom/check_negative.php?nik="+guarantor_nik+"&nama_lengkap="+guarantor_name+"&tempat_lahir="+guarantor_bod_place+"&tgl_lahir="+guarantor_bod+"&source="+source+"&PreApproval="+IS_PRE_APPROVAL+"&app_no="+app_no;
							$.ajax({
									url: urlcheckcust,
									type: "POST",
									dataType: 'json',
									success: function(data2){ 
										// document.getElementById('tempatDukcapil').style.display = "none";
										var datares = data.FinalResult; 
										var datares2 = data.ResponseMessage;
										if (datares == 'Match') {
											alert("Result Guarantor Dukcapil : "+datares);
											document.getElementById("txt_activity_guarantor_ducapil").value = datares;
										}else if (datares == 'Not Match'){
											alert("Result Guarantor Dukcapil : "+datares);
											document.getElementById("txt_activity_guarantor_ducapil").value = datares;
										}else{
											// alert("Result Dukcapil : "+datares);
											document.getElementById("txt_activity_guarantor_ducapil").value = datares;
										}		

										var datarnegres  = data2.result; 
										var datarnegres2 = data2.negativeType;
										datarnegres      = datarnegres.replace("CUstomer", "Customer");
										if (datarnegres == 'Match') {
											alert("Result Guarantor Neglist : "+datarnegres);
											document.getElementById("txt_activity_guarantor_neglist").value = datarnegres;
										}else if (datarnegres == 'Not Match' || datarnegres == 'NOT MATCH'){
											alert("Result Guarantor Neglist : "+datarnegres);
											document.getElementById("txt_activity_guarantor_neglist").value = datarnegres;
										}else{
											// alert("Result Neglist : "+datarnegres);
											document.getElementById("txt_activity_guarantor_neglist").value = datarnegres;
										}					
									}
							});	
													
						}
				});	}, 1500);
			}

			//end guarantor
			document.getElementById('tempatDukcapil').style.display = "none";
			// alert("xx");
		    return false;
		});

		// $("#btn_duckcapil").click(function() {
			
		// 	var nik            = document.getElementById("txt_id_no").value;
		// 	var nama_lengkap   = document.getElementById("txt_customer_name").value;
		// 	var tempat_lahir   = document.getElementById("txt_birth_place").value;
		// 	var tgl_lahir      = document.getElementById("txt_birth_date").value; //06-07-1987
		// 	// var user_name      = document.getElementById("txt_spouse_name").value;
		// 	// var emp_name       = document.getElementById("txt_job_profname").value;
		// 	// var office_code    = document.getElementById("two_cabang_code").value;
		// 	// var office_name    = document.getElementById("two_cabang_name").value;
		// 	// var region         = document.getElementById("two_region_name").value; //1
		// 	// var cust_no        = document.getElementById("two_cust_no").value;
		// 	// var app_no         = '';
		// 	// var ip_user        = '';
		// 	// var source         = document.getElementById("two_source_data").value;

		// 	var urldukcapil	   = "service/wom/check_dukcapil_new.php?nik="+nik+"&nama_lengkap="+nama_lengkap+"&tempat_lahir="+tempat_lahir+"&tgl_lahir="+tgl_lahir;
		// 	// // +"&nama_lengkap="+nama_lengkap+"&tempat_lahir="+tempat_lahir+"&tgl_lahir="+tgl_lahir+"&user_name="+user_name+"&emp_name="+emp_name+"&office_code="+office_code+"&office_name="+office_name+"&region="+region+"&cust_no="+cust_no+"&app_no="+app_no+"&ip_user="+ip_user+"&source="+source
		// 	$.ajax({
		// 			url: urldukcapil,
		// 			type: "POST",
		// 			dataType: 'json',
		// 			success: function(data){ 
		// 				// var datares = data.FinalResult; 
		// 				var datares  = data.duplicateStatus;
		// 				var datares2 = data.responseMessage;
		// 				var datares3 = data.data;
		// 				var datares4 = datares3.duplicateStatus;
		// 				// alert(datares4);
		// 				// if (datares == 'Match') {
		// 				// 	alert(datares);
		// 				// 	document.getElementById("txtdukcapil").value = datares;

		// 				// 	var dataString = 'status_dukcapil=1&v=call_status_dukcapil';
		// 				// 	$.ajax({ 
		// 				// 	    type: 'POST', 
		// 				// 	    url: 'view/telesales/get_data_value.php', 
		// 				// 	    data: dataString, 
		// 				// 	    dataType:'json',
		// 				// 	    success: function (data) { 
		// 				// 	        $('#call_status').html(data.arr_status_call_dukcapil);
		// 				// 	    }
							      
		// 				// 	});
		// 				// }else if (datares == 'Not Match'){
		// 				// 	alert(datares);
		// 				// 	document.getElementById("txtdukcapil").value = datares;

		// 				// 	var dataString = 'status_dukcapil=2&v=call_status_dukcapil';
		// 				// 	$.ajax({ 
		// 				// 	    type: 'POST', 
		// 				// 	    url: 'view/telesales/get_data_value.php', 
		// 				// 	    data: dataString, 
		// 				// 	    dataType:'json',
		// 				// 	    success: function (data) { 
		// 				// 	        $('#call_status').html(data.arr_status_call_dukcapil);
		// 				// 	    }
							      
		// 				// 	});
		// 				// }else{
		// 				// 	alert(datares2);
		// 				// 	document.getElementById("txtdukcapil").value = datares2;

		// 				// 	var dataString = 'status_dukcapil=2&v=call_status_dukcapil';
		// 				// 	$.ajax({ 
		// 				// 	    type: 'POST', 
		// 				// 	    url: 'view/telesales/get_data_value.php', 
		// 				// 	    data: dataString, 
		// 				// 	    dataType:'json',
		// 				// 	    success: function (data) { 
		// 				// 	        $('#call_status').html(data.arr_status_call_dukcapil);
		// 				// 	    }
							      
		// 				// 	});
		// 				// }
												
		// 			}
		// 	});	
		// 	// alert("xx");
		//     return false;
		// });

		function det_agrement(id_agrmnt,task_id_agrmnt){
			// $('#divactivity').load('view/telesales/get_activity.php?iddata='+id_agrmnt);
			// document.getElementById("txt_activity_result").reset(); 
			document.getElementById("idgrmnt").value=id_agrmnt;
			select_box = document.getElementById("txt_activity_result");
			select_box.selectedIndex = 0;
			select_box = document.getElementById("txt_activity_substatuscall");
			select_box.selectedIndex = 0;
			document.getElementById("txt_activity_notes").value="";
			document.getElementById("txt_activity_ducapil").value="";
			document.getElementById("txt_activity_waktuvisit").value="";
			// alert(id_agrmnt);
			$('#detailagrement').load('view/telesales/tele_cust_agrement.php?idagrmnt='+id_agrmnt+'&taskid_agrmnt='+task_id_agrmnt);
		    return false;
		}

	</script>
	<script type="text/javascript">
		$('#txt_activity_waktuvisit').datetimepicker({
			format: 'YYYY-MM-DD HH:ss',
		});

		$('#txt_birth_date').datetimepicker({
			format: 'YYYY-MM-DD',
			maxDate : 'now'
		});

		$('#txt_spouse_birthdate').datetimepicker({
			format: 'YYYY-MM-DD',
			maxDate : 'now'
		});

		$('#txt_guarantor_bod').datetimepicker({
			format: 'YYYY-MM-DD',
		});


		$('#txtfollowup').datetimepicker({
			format: 'YYYY-MM-DD HH:ss',
		});
	</script>

	<script type="text/javascript">
		
		// guarantor
		$("#txt_guarantor_prov").change(function(){
			var prov = $("#txt_guarantor_prov").val();
			var dataString = 'v=get_kabupaten&prov='+prov;
			// console.log(prov);

			$.ajax({
				type 	: 'POST',
				url 	: 'view/telesales/get_data_value.php',
				data 	: dataString,
				dataType: 'json',
				success: function(data){
					// console.log(data)
					$('#txt_guarantor_kab').html(data.arr_category);
				}
			})
		})

		$("#txt_guarantor_kab").change(function(){
			var city   	= $("#txt_guarantor_kab option:selected").text();
			// console.log(city);
			var dataString 	= 'city='+city+'&v=get_kecamatan';
			$.ajax({ 
				type: 'POST', 
				url: 'view/telesales/get_data_value.php', 
				data: dataString, 
				dataType:'json',
				success: function (data) { 
					$('#txt_guarantor_kecamatan').html(data.arr_category);
				}
			});
		});

		$("#txt_guarantor_kecamatan").change(function(){
			var kecamatan   = $("#txt_guarantor_kecamatan option:selected").text();
			var city   	= $("#txt_guarantor_kab option:selected").text();
			var dataString 	= 'city='+city+'&kecamatan='+kecamatan+'&v=get_kelurahan';
			$.ajax({ 
				type: 'POST', 
				url: 'view/telesales/get_data_value.php', 
				data: dataString, 
				dataType:'json',
				success: function (data) { 
					$('#txt_guarantor_kelurahan').html(data.arr_category);
				}
			});
		});

		$("#txt_guarantor_kelurahan").change(function(){
			var kelurahan   = $("#txt_guarantor_kelurahan option:selected").text();
			var kecamatan   = $("#txt_guarantor_kecamatan option:selected").text();
			var city   	= $("#txt_guarantor_kab option:selected").text();
			var dataString 	=  'city='+city+'&kecamatan='+kecamatan+'&kelurahan='+kelurahan+'&v=get_zipcode_survey';
			$.ajax({ 
				type: 'POST', 
				url: 'view/telesales/get_data_value.php', 
				data: dataString, 
				dataType:'json',
				success: function (data) { 
					$('#txt_guarantor_zip').html(data.arr_category);
				}
			});
		});

		$("#zipcode_survey").change(function(){
			var zipcode = $("#zipcode_survey option:selected").text();
			var kelurahan   = $("#kel_survey option:selected").text();
			var kecamatan   = $("#kec_survey option:selected").text();
			var city   	= $("#kab_survey option:selected").text();
			var dataString 	= 'city='+city+'&kecamatan='+kecamatan+'&kelurahan='+kelurahan+'&zipcode='+zipcode+'&v=get_subzipcode_survey';
			$.ajax({ 
				type: 'POST', 
				url: 'view/telesales/get_data_value.php', 
				data: dataString, 
				dataType:'json',
				success: function (data) { 
					// console.log(data);
					// $('#subzipcode_survey').val(data.arr_category);
				}
			});
		});

		// legal
		$("#txt_legal_prov").change(function(){
			var prov = $("#txt_legal_prov").val();
			var dataString = 'v=get_kabupaten&prov='+prov;
			// console.log(prov);

			$.ajax({
				type 	: 'POST',
				url 	: 'view/telesales/get_data_value.php',
				data 	: dataString,
				dataType: 'json',
				success: function(data){
					// console.log(data)
					$('#txt_legal_kab').html(data.arr_category);
				}
			})
		})

		$("#txt_legal_kab").change(function(){
			var city   	= $("#txt_legal_kab option:selected").text();
			// console.log(city);
			var dataString 	= 'city='+city+'&v=get_kecamatan';
			$.ajax({ 
				type: 'POST', 
				url: 'view/telesales/get_data_value.php', 
				data: dataString, 
				dataType:'json',
				success: function (data) { 
					$('#txt_legal_kec').html(data.arr_category);
				}
			});
		});

		$("#txt_legal_kec").change(function(){
			var kecamatan   = $("#txt_legal_kec option:selected").text();
			var city   	= $("#txt_legal_kab option:selected").text();
			var dataString 	= 'city='+city+'&kecamatan='+kecamatan+'&v=get_kelurahan';
			$.ajax({ 
				type: 'POST', 
				url: 'view/telesales/get_data_value.php', 
				data: dataString, 
				dataType:'json',
				success: function (data) { 
					$('#txt_legal_kelurahan').html(data.arr_category);
				}
			});
		});

		$("#txt_legal_kelurahan").change(function(){
			var kelurahan   = $("#txt_legal_kelurahan option:selected").text();
			var kecamatan   = $("#txt_legal_kec option:selected").text();
			var city   	= $("#txt_legal_kab option:selected").text();
			var dataString 	=  'city='+city+'&kecamatan='+kecamatan+'&kelurahan='+kelurahan+'&v=get_zipcode_survey';
			$.ajax({ 
				type: 'POST', 
				url: 'view/telesales/get_data_value.php', 
				data: dataString, 
				dataType:'json',
				success: function (data) { 
					$('#txt_legal_zipcode').html(data.arr_category);
				}
			});
		});

		$("#txt_legal_zipcode").change(function(){
			var zipcode = $("#txt_legal_zipcode option:selected").text();
			var kelurahan   = $("#txt_legal_kelurahan option:selected").text();
			var kecamatan   = $("#txt_legal_kec option:selected").text();
			var city   	= $("#txt_legal_kab option:selected").text();
			var dataString 	= 'city='+city+'&kecamatan='+kecamatan+'&kelurahan='+kelurahan+'&zipcode='+zipcode+'&v=get_subzipcode_survey';
			$.ajax({ 
				type: 'POST', 
				url: 'view/telesales/get_data_value.php', 
				data: dataString, 
				dataType:'json',
				success: function (data) { 
					// console.log(data);
					$('#txt_legal_sub_zipcode').val(data.arr_category);
				}
			});
		});


		// survey 

		$("#txt_survey_prov").change(function(){
			var prov = $("#txt_survey_prov").val();
			var dataString = 'v=get_kabupaten&prov='+prov;
			// console.log(prov);

			$.ajax({
				type 	: 'POST',
				url 	: 'view/telesales/get_data_value.php',
				data 	: dataString,
				dataType: 'json',
				success: function(data){
					// console.log(data)
					$('#txt_survey_kab').html(data.arr_category);
				}
			})
		})

		$("#txt_survey_kab").change(function(){
			var city   	= $("#txt_survey_kab option:selected").text();
			// console.log(city);
			var dataString 	= 'city='+city+'&v=get_kecamatan';
			$.ajax({ 
				type: 'POST', 
				url: 'view/telesales/get_data_value.php', 
				data: dataString, 
				dataType:'json',
				success: function (data) { 
					$('#txt_survey_kec').html(data.arr_category);
				}
			});
		});

		$("#txt_survey_kec").change(function(){
			var kecamatan   = $("#txt_survey_kec option:selected").text();
			var city   	= $("#txt_survey_kab option:selected").text();
			var dataString 	= 'city='+city+'&kecamatan='+kecamatan+'&v=get_kelurahan';
			$.ajax({ 
				type: 'POST', 
				url: 'view/telesales/get_data_value.php', 
				data: dataString, 
				dataType:'json',
				success: function (data) { 
					$('#txt_survey_kelurahan').html(data.arr_category);
				}
			});
		});

		$("#txt_survey_kelurahan").change(function(){
			var kelurahan   = $("#txt_survey_kelurahan option:selected").text();
			var kecamatan   = $("#txt_survey_kec option:selected").text();
			var city   	= $("#txt_survey_kab option:selected").text();
			var dataString 	=  'city='+city+'&kecamatan='+kecamatan+'&kelurahan='+kelurahan+'&v=get_zipcode_survey';
			$.ajax({ 
				type: 'POST', 
				url: 'view/telesales/get_data_value.php', 
				data: dataString, 
				dataType:'json',
				success: function (data) { 
					$('#txt_survey_zipcode').html(data.arr_category);
				}
			});
		});

		$("#txt_survey_zipcode").change(function(){
			var zipcode = $("#txt_survey_zipcode option:selected").text();
			var kelurahan   = $("#txt_survey_kelurahan option:selected").text();
			var kecamatan   = $("#txt_survey_kec option:selected").text();
			var city   	= $("#txt_survey_kab option:selected").text();
			var dataString 	= 'city='+city+'&kecamatan='+kecamatan+'&kelurahan='+kelurahan+'&zipcode='+zipcode+'&v=get_subzipcode_survey';
			$.ajax({ 
				type: 'POST', 
				url: 'view/telesales/get_data_value.php', 
				data: dataString, 
				dataType:'json',
				success: function (data) { 
					// console.log(data);
					$('#txt_survey_subzipcode').val(data.arr_category);
				}
			});
		});



		$('#tableAssetList tbody').on('dblclick', 'tr', function () {
			var idIndex = $(this).find("td:first").html(); 
			var iddata = $(this).data('id');
			$("#modal_editasset").modal('toggle'); 
			$('#editassetdiv').load('view/telesales/get_edit_assets.php?iddata='+iddata);
		})
	</script>

	<script>
		$( document ).ready(function() {

			//start spose

		    var param_marital         = document.getElementById("marital_status").value;
		    if (param_marital=='MENIKAH') {
		    	document.getElementById("txt_spouse_name").readOnly = false;
		    	document.getElementById("txt_spouse_mobile_phone").readOnly = false;
		    	document.getElementById("txt_spouse_nik").readOnly = false;
		    	document.getElementById("txt_spouse_phone").readOnly = false;
		    	document.getElementById("txt_spouse_birthdate").readOnly = false;
		    	document.getElementById("txt_spouse_birthplace").readOnly = false;
		    }else{
		    	document.getElementById("txt_spouse_name").readOnly = true;
		    	document.getElementById("txt_spouse_mobile_phone").readOnly = true;
		    	document.getElementById("txt_spouse_nik").readOnly = true;
		    	document.getElementById("txt_spouse_phone").readOnly = true;
		    	document.getElementById("txt_spouse_birthdate").readOnly = true;
		    	document.getElementById("txt_spouse_birthplace").readOnly = true;
		    }
			//  
			//end spouse
		    var row_bulk         = document.getElementsByName("check_assign");
		    var iddet_param      = <?php echo $iddet; ?>;
		    var capture = "0";
		    for (var i = 0; i < row_bulk.length; i++) {
            	if (row_bulk[i].value == iddet_param) {
            		row_bulk[i].checked = true;
            		row_bulk[i].parentNode.parentNode.style.backgroundColor = "#cfbdd1"; 
		            capture = capture + "," + row_bulk[i].value; 
             	}
            
        	}
        	document.getElementById('txt_check_agrmnt').value=capture;
        	if (capture!='0') {
        		document.getElementById('param_check_agrmnt').value='1';
        	}

        	var id_agrmnt      = document.getElementById("iddet").value;
        	var task_id_agrmnt = document.getElementById("txt_task_id").value;
			$('#detailagrement').load('view/telesales/tele_cust_agrement.php?idagrmnt='+id_agrmnt+'&taskid_agrmnt='+task_id_agrmnt);

			$(document).on('input', '#txt_job_penghasilan', function (e) {
				if (/^[0-9.,]+$/.test($(this).val())) {
				$(this).val(
					parseFloat($(this).val().replace(/,/g, '')).toLocaleString('en')
				);
				} else {
				$(this).val(
					$(this)
					.val()
					.substring(0, $(this).val().length - 1)
				);
				}
			});
			
			$(document).on('input', '#txt_job_penghasilan', function (e) {
				if (/^[0-9.,]+$/.test($(this).val())) {
				$(this).val(
					parseFloat($(this).val().replace(/,/g, '')).toLocaleString('en')
				);
				} else {
				$(this).val(
					$(this)
					.val()
					.substring(0, $(this).val().length - 1)
				);
				}
			});

			$(document).on('input', '#txt_job_penghasilan', function (e) {
				if (/^[0-9.,]+$/.test($(this).val())) {
				$(this).val(
					parseFloat($(this).val().replace(/,/g, '')).toLocaleString('en')
				);
				} else {
				$(this).val(
					$(this)
					.val()
					.substring(0, $(this).val().length - 1)
				);
				}
			});
			
			$(document).on('input', '#txt_job_penghasilan', function (e) {
				if (/^[0-9.,]+$/.test($(this).val())) {
				$(this).val(
					parseFloat($(this).val().replace(/,/g, '')).toLocaleString('en')
				);
				} else {
				$(this).val(
					$(this)
					.val()
					.substring(0, $(this).val().length - 1)
				);
				}
			});

			var nik            = document.getElementById("txt_id_no").value;
			var nama_lengkap   = document.getElementById("txt_customer_name").value;
			var tempat_lahir   = document.getElementById("txt_birth_place").value;
			var tgl_lahir      = document.getElementById("txt_birth_date").value;
			var urlduplicate	   = "service/wom/check_duplicate.php?nik="+nik+"&nama_lengkap="+nama_lengkap+"&tempat_lahir="+tempat_lahir+"&tgl_lahir="+tgl_lahir; 
			if (nik!='') {
				document.getElementById('tempatLoading').style.display = "";
		    	 $.ajax({
					url: urlduplicate,
					type: "POST",
					dataType: 'json',
					success: function(data){ 
						var datares  = data.duplicateStatus;
						var datares2 = data.responseMessage;
						var datares_total  = data.responseTotal;
						var datares_cabang = data.responseCabang;
						var datares3 = data.data;
						if (datares3 !=null) {
							var dataresmsg = datares3.duplicateMessage;
							var datares4   = datares3.duplicateStatus;
							var datares5   = datares3.isActive;
							var datares6   = datares3.numOfDuplicate;
							var dataresnum = datares3.numOfDuplicate;

							var cabang = datares_cabang.replaceAll('</br>', '\n');
							console.log(datares4)
							// console.log(cabang);
							var atares6 ='';
							if (datares4=='MATCH' && datares5=='1') {
								datares6='MATCH';
							}
							if (datares6=='MATCH') {
								var titles = "This Data is Duplicate, Want to Proccess? "+dataresnum;
								swal({
								  title: titles, 
								  text: cabang,
								  icon: "warning",
								  html: true,
								  buttons: true,
								  dangerMode: true,
								  allowClickOutside: false,
								  closeOnClickOutside: false,
								  className: "swal-duplicate",
								  buttons: ["Yes", "No"],
								})
								.then((willDelete) => {
								  if (willDelete) {
								  	document.getElementById('tempatLoading').style.display = "";
								  	var iddet      = document.getElementById("iddet").value;
									var taskid         = "<?=$txt_task_id;?>";
									var urlupdatepolo  = "service/wom/api_fin_update_data_duplicate.php?taskId="+taskid+"&param=1";
									$.ajax({
										url: urlupdatepolo,
										type: "POST",
										dataType: 'json',
										success: function(data){ 
											$.ajax({
												type: 'POST',
												url: "view/telesales/tele_next_data.php?iddet="+iddet,
												success: function(hv) {
												    var url = "http://10.1.49.250/wom/index.php?v=dGVsZXNhbGVzfHRlbGVfY3VzdG9tZXJfZGF0YV9saXN0fEN1c3RvbWVyIERhdGF8MTU2fA%3D%3D";  
											    	var url2=url; 
											    	setTimeout(function(){ window.location.href = url2; }, 1500);
												}
											});																	
										}
									});
								  } else {
									var datares5   = datares3.numOfDuplicate+1;
									document.getElementById('param_num_duplicate').value=datares5;
								    // swal("Your imaginary file is safe!");
								  }
								});

							}
						}
						document.getElementById('tempatLoading').style.display = "none";
					}
				});	
			}
			
        	
		});
		function isNumberKey(evt)
		{
			var charCode = (evt.which) ? evt.which : event.keyCode
			if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;

			return true;
		}

		function isMoney(evt, res){
			var charCode = (evt.which) ? evt.which : event.keyCode
			if (charCode > 31 && (charCode < 48 || charCode > 57)){
				return false
			}else{
				var value = $(res).val();
				// var value = $(res).val().replaceAll('.', '');
				value = formatRupiah(value);
				$(res).val(value)
			}

		}

		function formatRupiah(angka, prefix)
    {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split    = number_string.split(','),
            sisa     = split[0].length % 3,
            rupiah     = split[0].substr(0, sisa),
            ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
            // console.log(sisa+"|"+rupiah+"|"+ribuan);
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    	$('#checkall').click(function(e){
		   var i = '';
		   var capture = "0";
		    if (document.getElementById('checkall').checked == true) {
		       var row_bulk   = document.getElementsByName("check_assign");

		       var chklength = row_bulk.length;             
		       for(k=0;k<chklength;k++) {
		       //  // var chk_arr2 = document.getElementById("comid[]").value;

		          row_bulk[k].checked = true;
		          row_bulk[k].parentNode.parentNode.style.backgroundColor = "#cfbdd1";
		          capture = capture + "," + row_bulk[k].value;
		       // alert(chklength);

		       } 
		       
		    } else if (document.getElementById('checkall').checked == false) {
		       var row_bulk   = document.getElementsByName("check_assign");
		       var chklength = row_bulk.length;             
		       for(k=0;k< chklength;k++) {
		       //    row_bulk[k].checked = false;
		        // alert("NON SUKS");
		         row_bulk[k].checked = false;
		         row_bulk[k].parentNode.parentNode.style.backgroundColor = "transparent";
		       }    
		      }
		      document.getElementById('txt_check_agrmnt').value=capture;
        	if (capture!='0') {
        		document.getElementById('param_check_agrmnt').value='1';
        	}
		});

		$("#three_tenor").attr("maxlength", "2");

    	function checkBulk(){
            var row_bulk = document.getElementsByClassName("row_bulk");
  			var capture = "0";
        	for (var i = 0; i < row_bulk.length; i++) {
            	if (row_bulk[i].checked == true) {
            		capture = capture + "," + row_bulk[i].value; 
            		row_bulk[i].parentNode.parentNode.style.backgroundColor = "#cfbdd1"; 
            		var url = "http://10.1.49.250/wom/index.php?v=dGVsZXNhbGVzfHRlbGVfY3VzdG9tZXJfZGF0YV9saXN0fEN1c3RvbWVyIERhdGF8MTU2fA%3D%3D";    
					url += '&param='+row_bulk[i].value;
					window.location.href = url; 
             	}
             	else{
                    row_bulk[i].parentNode.parentNode.style.backgroundColor = "transparent";
            		//          // alert("2"+row_bulk.value);
                }
            
        	}
        	document.getElementById('txt_check_agrmnt').value=capture;
        	if (capture!='0') {
        		document.getElementById('param_check_agrmnt').value='1';
        	}
        }


		$("#marital_status").change(function() {
			var param_marital         = document.getElementById("marital_status").value;
			if (param_marital=='MENIKAH') {
		    	document.getElementById("txt_spouse_name").readOnly = false;
		    	document.getElementById("txt_spouse_mobile_phone").readOnly = false;
		    	document.getElementById("txt_spouse_nik").readOnly = false;
		    	document.getElementById("txt_spouse_phone").readOnly = false;
		    	document.getElementById("txt_spouse_birthdate").readOnly = false;
		    	document.getElementById("txt_spouse_birthplace").readOnly = false;
		    }else{
		    	document.getElementById("txt_spouse_name").readOnly = true;
		    	document.getElementById("txt_spouse_mobile_phone").readOnly = true;
		    	document.getElementById("txt_spouse_nik").readOnly = true;
		    	document.getElementById("txt_spouse_phone").readOnly = true;
		    	document.getElementById("txt_spouse_birthdate").readOnly = true;
		    	document.getElementById("txt_spouse_birthplace").readOnly = true;
		    }
		 });
        	
	</script>

	<!-- modal add assets --> 
		<div class="modal fade addnewassetpop" id="addnewassetpop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
		  <div class="modal-dialog modal-lg" role="document" style="border: 2px solid #0a4fa7;border-radius:10px 10px 0px 0px;">
			<div class="modal-content" class="border border-primary">
			  <div class="modal-header">
				<h4 class="modal-title" id="myModalLabel4"> New Asset</h4>
			  </div>
			  <div class="modal-body" style="background:white;height:400px;overflow-y:auto">
  				<div id="main_addnewasset"></div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn grey btn-outline-secondary" onclick="save_addassets_dialog();return false;">Save</button>
			  </div>
			</div>
		  </div>
		</div>

			<!-- modal add phone --> 
	<div class="modal fade addnewphonepop" id="addnewphonepop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel46" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document" style="border: 2px solid #0a4fa7;border-radius:10px 10px 0px 0px;">
		<div class="modal-content" class="border border-primary">
			<div class="modal-header">
			<h4 class="modal-title" id="myModalLabel46"> New Phone</h4>
			</div>
			<div class="modal-body" style="background:white;height:400px;overflow-y:auto">
			<div id="main_addnewphone"></div>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
			<button type="button" class="btn grey btn-outline-secondary" onclick="save_addphone_dialog();return false;">Save</button>
			</div>
		</div>
		</div>
	</div>



<div class="modal fade bd-example-modal-lg " id="modal_editasset" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" >
	<div class="modal-dialog modal-lg" role="document" style="border: 2px solid black;border-radius:10px 10px 0px 0px; "> <!-- <?php echo $master_borderdominant_color ?> -->
		<div class="modal-content" class="border border-primary">
			<div class="modal-header" style="background:black;color:white"> <!-- <?php echo $dominant_mastercolor ?> -->
			<h4 class="modal-title" id="myModalLabel14">Edit Asset</h4>
			</div>
			<div class="modal-body" style="background:white">
			<!-- edit assets -->
			<div id="editassetdiv">&nbsp;</div>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
			</div>
		</div>
	</div>
</div>