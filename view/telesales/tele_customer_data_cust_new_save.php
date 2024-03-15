<?php
include "../../sysconf/global_func.php";
include "../../sysconf/session.php";
include "../../sysconf/db_config.php";

$condb = connectDB();

$v_agentid                  = get_session("v_agentid");
$v_agentlevel               = get_session("v_agentlevel");

$v_skillnya                 = get_session("v_skillnya");
$agentname                  = get_session("v_agentname");
$v_agentname                = get_session("v_agentname");
$v_agentemail               = get_session("v_agentemail");
$v_agentlogin               = get_session("v_agentlogin");

$v                          = get_param("v");
$iddet                      = get_param("iddet");

$txt_campaign_name          = inj3($condb,get_param("txt_campaign_name"));
$txt_customer_name          = inj3($condb,get_param("txt_customer_name"));  
$txt_customer_no            = inj3($condb,get_param("txt_customer_no"));
$txt_sumber_data            = inj3($condb,get_param("txt_sumber_data"));
$txt_id_no                  = inj3($condb,get_param("txt_id_no"));
$txt_contact_no             = inj3($condb,get_param("txt_contact_no"));
$txt_mobile_no1             = inj3($condb,get_param("txt_mobile_no1"));
$txt_birth_place            = inj3($condb,get_param("txt_birth_place"));    
$txt_mobile_phone2          = inj3($condb,get_param("txt_mobile_phone2"));
$txt_birth_date             = inj3($condb,get_param("txt_birth_date"));
$txt_phone1                 = inj3($condb,get_param("txt_phone1"));
$txt_religion               = inj3($condb,get_param("txt_religion"));
$txt_phone2                 = inj3($condb,get_param("txt_phone2"));
$txt_spouse_name            = inj3($condb,get_param("txt_spouse_name"));
$txt_spouse_phone           = inj3($condb,get_param("txt_spouse_phone"));
$txt_spouse_nik             = inj3($condb,get_param("txt_spouse_nik"));
$txt_spouse_birthdate       = inj3($condb,get_param("txt_spouse_birthdate"));
$txt_spouse_birthplace      = inj3($condb,get_param("txt_spouse_birthplace"));
$txt_spouse_mobile_phone    = inj3($condb,get_param("txt_spouse_mobile_phone"));
$txt_guarantor_name         = inj3($condb,get_param("txt_guarantor_name"));
$txt_guarantor_phone        = inj3($condb,get_param("txt_guarantor_phone"));
$txt_guarantor_prov         = inj3($condb,get_param("txt_guarantor_prov"));
$txt_guarantor_zip          = inj3($condb,get_param("txt_guarantor_zip"));
$txt_guarantor_nik          = inj3($condb,get_param("txt_guarantor_nik"));
$txt_guarantor_addr         = inj3($condb,get_param("txt_guarantor_addr"));
$txt_guarantor_kab          = inj3($condb,get_param("txt_guarantor_kab"));
$txt_guarantor_relation     = inj3($condb,get_param("txt_guarantor_relation"));
$txt_guarantor_bod          = inj3($condb,get_param("txt_guarantor_bod"));
$txt_guarantor_bod_place    = inj3($condb,get_param("txt_guarantor_bod_place"));
$txt_guarantor_phone1       = inj3($condb,get_param("txt_guarantor_phone1"));
$txt_guarantor_religion     = inj3($condb,get_param("txt_guarantor_religion"));
$txt_guarantor_phone2       = inj3($condb,get_param("txt_guarantor_phone2"));
$txt_guarantor_mobile_phone = inj3($condb,get_param("txt_guarantor_mobile_phone"));
$txt_guarantor_rt           = inj3($condb,get_param("txt_guarantor_rt"));
$txt_guarantor_rw           = inj3($condb,get_param("txt_guarantor_rw"));
$txt_guarantor_kelurahan    = inj3($condb,get_param("txt_guarantor_kelurahan"));
$txt_guarantor_kecamatan    = inj3($condb,get_param("txt_guarantor_kecamatan"));
$txt_legal_address          = inj3($condb,get_param("txt_legal_address"));
$txt_legal_kab              = inj3($condb,get_param("txt_legal_kab"));
$txt_legal_zipcode          = inj3($condb,get_param("txt_legal_zipcode"));
$txt_legal_rt               = inj3($condb,get_param("txt_legal_rt"));
$txt_legal_kec              = inj3($condb,get_param("txt_legal_kec"));
$txt_legal_sub_zipcode      = inj3($condb,get_param("txt_legal_sub_zipcode"));
$txt_legal_rw               = inj3($condb,get_param("txt_legal_rw"));
$txt_legal_kelurahan        = inj3($condb,get_param("txt_legal_kelurahan"));
$txt_legal_prov             = inj3($condb,get_param("txt_legal_prov"));
$txt_survey_addr            = inj3($condb,get_param("txt_survey_addr"));
$txt_survey_kab             = inj3($condb,get_param("txt_survey_kab"));
$txt_survey_subzipcode      = inj3($condb,get_param("txt_survey_subzipcode"));
$txt_survey_rt              = inj3($condb,get_param("txt_survey_rt"));
$txt_survey_kec             = inj3($condb,get_param("txt_survey_kec"));
$txt_survey_houseowner      = inj3($condb,get_param("txt_survey_houseowner"));
$txt_survey_rw              = inj3($condb,get_param("txt_survey_rw"));
$txt_survey_kelurahan       = inj3($condb,get_param("txt_survey_kelurahan"));
$txt_survey_domicile        = inj3($condb,get_param("txt_survey_domicile"));
$txt_survey_prov            = inj3($condb,get_param("txt_survey_prov"));
$txt_survey_zipcode         = inj3($condb,get_param("txt_survey_zipcode"));
$txt_job_profname           = inj3($condb,get_param("txt_job_profname"));
$txt_job_work               = inj3($condb,get_param("txt_job_work"));
$txt_job_modelname          = inj3($condb,get_param("txt_job_modelname"));
$txt_job_penghasilan        = inj3($condb,get_param("txt_job_penghasilan"));
$txt_job_industryname       = inj3($condb,get_param("txt_job_industryname"));
$txt_job_phone1             = inj3($condb,get_param("txt_job_phone1"));
$txt_job_position           = inj3($condb,get_param("txt_job_position"));
$txt_job_phone2             = inj3($condb,get_param("txt_job_phone2"));
$txt_other_type             = inj3($condb,get_param("txt_other_type"));
$txt_other_alternativephone = inj3($condb,get_param("txt_other_alternativephone"));
$txt_other_visitnote        = inj3($condb,get_param("txt_other_visitnote"));

$txt_prospect_stat          = inj3($condb,get_param("txt_prospect_stat"));
$txt_activity_result        = inj3($condb,get_param("txt_activity_result"));
$txt_activity_substatuscall = inj3($condb,get_param("txt_activity_substatuscall"));
$txt_activity_ducapil       = inj3($condb,get_param("txt_activity_ducapil"));
$txt_activity_neglist       = inj3($condb,get_param("txt_activity_neglist"));
$txt_activity_notes         = inj3($condb,get_param("txt_activity_notes"));
$txt_activity_waktuvisit    = inj3($condb,get_param("txt_activity_waktuvisit"));

$txt_task_id                = inj3($condb,get_param("txt_task_id"));
$references_id              = inj3($condb,get_param("references_id"));
$dialedno                   = inj3($condb,get_param("dialedno"));
$dialedno                   = inj3($condb,get_param("cmb_phone_no"));
$form_id                    = inj3($condb,get_param("form_id"));
$add_asset_id               = inj3($condb,get_param("add_asset_id"));
$agrmnt_no                  = inj3($condb,get_param("agrmnt_no"));

$txtfollowup                = inj3($condb,get_param("txtfollowup"));
$mlob                       = inj3($condb,get_param("mlob"));
$param_agrmnt               = inj3($condb,get_param("param_agrmnt"));
$three_pro_offering         = inj3($condb,get_param("three_pro_offering"));

// simulasi
$three_or_office            = inj3($condb,get_param("three_or_office"));
$three_asset_name           = inj3($condb,get_param("three_asset_name"));
$three_mfr_year             = inj3($condb,get_param("three_mfr_year"));
$three_otr                  = inj3($condb,get_param("three_otr"));
$three_asset_usage          = inj3($condb,get_param("three_asset_usage"));
$three_admin_fee            = inj3($condb,get_param("three_admin_fee"));
$three_add_adminfee         = inj3($condb,get_param("three_add_adminfee"));
$three_ltv_maks             = inj3($condb,get_param("three_ltv_maks"));
$three_ltv_yang             = inj3($condb,get_param("three_ltv_yang"));
$three_biaya_pro            = inj3($condb,get_param("three_biaya_pro"));
$three_ph_maks              = inj3($condb,get_param("three_ph_maks"));
$three_ph_yang              = inj3($condb,get_param("three_ph_yang"));
$three_ins_type             = inj3($condb,get_param("three_ins_type"));
$three_calcu_ins            = inj3($condb,get_param("three_calcu_ins"));
$three_self_ins             = inj3($condb,get_param("three_self_ins"));
$three_tenor                = inj3($condb,get_param("three_tenor"));
$three_calcu_budget         = inj3($condb,get_param("three_calcu_budget"));
$three_budget_plan          = inj3($condb,get_param("three_budget_plan"));
$three_calcu_install        = inj3($condb,get_param("three_calcu_install"));
$param_num_duplicate        = inj3($condb,get_param("param_num_duplicate"));

//start_new
$txt_activity_pasangan_ducapil       = inj3($condb,get_param("txt_activity_pasangan_ducapil"));
$txt_activity_pasangan_neglist       = inj3($condb,get_param("txt_activity_pasangan_neglist"));
$txt_activity_guarantor_ducapil      = inj3($condb,get_param("txt_activity_guarantor_ducapil"));
$txt_activity_guarantor_neglist      = inj3($condb,get_param("txt_activity_guarantor_neglist"));
$opsi_penanganan                     = inj3($condb,get_param("opsi_penanganan"));
$txt_IS_PRE_APPROVAL                 = inj3($condb,get_param("txt_IS_PRE_APPROVAL"));
//end new

$three_ltv_maks = str_replace(",", ".", $three_ltv_maks);
$three_ltv_yang = str_replace(",", ".", $three_ltv_yang);
if (strpos($three_ltv_maks, ".")=== false) {
    $three_ltv_maks = $three_ltv_maks.".00";
}
if (strpos($three_ltv_yang, ".")=== false) {
    $three_ltv_yang = $three_ltv_yang.".00";
}
$updwaktu = "";
if ($txt_activity_result==1) {
    $updwaktu = " waktu_survey        = '$txt_activity_waktuvisit', ";
}else if ($txt_activity_result==2) {
    $updwaktu = " visit_dt        = '$txt_activity_waktuvisit', ";
}

$sqldel = "DELETE FROM cc_ts_penawaran_temp WHERE (customer_id='$txt_customer_no' OR customer_id_ro='$txt_customer_no') AND call_status=0;";
$rec_i = mysqli_query($condb,$sqldel);

// $sqlinserttemp = "INSERT cc_ts_penawaran_temp SELECT * FROM cc_ts_penawaran WHERE (customer_id='$txt_customer_no' OR customer_id_ro='$txt_customer_no');";//echo "string $sqlinserttemp </br></br>";

$sqlinserttemp = "INSERT cc_ts_penawaran_temp SELECT a.* FROM cc_ts_penawaran a LEFT JOIN cc_ts_penawaran_temp b
                  ON a.id=b.id WHERE (a.customer_id='$txt_customer_no' OR a.customer_id_ro='$txt_customer_no') AND (b.call_status IS NULL OR b.call_status=0);";
$rec_i = mysqli_query($condb,$sqlinserttemp);


$sqlsa = "SELECT 
            a.*
          FROM 
            cc_master_kendaraan a 
          WHERE 
            a.id='$three_asset_name'";
$ressa = mysqli_query($condb,$sqlsa);
if($recsa = mysqli_fetch_array($ressa)){
    $asset_code       = $recsa['asset_code'];
}

$sqlsa = "SELECT a.id, a.office_code, a.office_name FROM cc_master_cabang a 
          WHERE 
            a.id='$three_or_office'";
$ressa = mysqli_query($condb,$sqlsa);
if($recsa = mysqli_fetch_array($ressa)){
    $cabang_code       = $recsa['office_code'];
}

$sqlupd = "UPDATE cc_ts_penawaran_temp SET   
                customer_name       = '$txt_customer_name',         
                customer_id         = '$txt_customer_no',          
                source_data         = '$txt_sumber_data',           
                nik_ktp             = '$txt_id_no',             
                mobile_1            = '$txt_mobile_no1',                
                tempat_lahir        = '$txt_birth_place',           
                mobile_2            = '$txt_mobile_phone2',         
                tanggal_lahir       = '$txt_birth_date',            
                phone_1             = '$txt_phone1',                    
                religion            = '$txt_religion',              
                phone_2             = '$txt_phone2',                    
                nama_pasangan       = '$txt_spouse_name',                    
                spouse_name         = '$txt_spouse_name',           
                spouse_phone        = '$txt_spouse_phone',          
                spouse_mobile_phone = '$txt_spouse_mobile_phone',          
                spouse_nik          = '$txt_spouse_nik',                
                spouse_birth_date   = '$txt_spouse_birthdate',      
                spouse_birth_place  = '$txt_spouse_birthplace',     
                tanggal_lahir_pasangan   = '$txt_spouse_birthdate',          
                guarantor_name      = '$txt_guarantor_name',            
                guarantor_phone     = '$txt_guarantor_phone',             
                guarantor_mobile_phone     = '$txt_guarantor_mobile_phone',     
                guarantor_provinsi  = '$txt_guarantor_prov',            
                guarantor_zipcode   = '$txt_guarantor_zip',         
                guarantor_nik       = '$txt_guarantor_nik',         
                guarantor_address   = '$txt_guarantor_addr',            
                guarantor_kabupaten = '$txt_guarantor_kab',         
                guarantor_relation  = '$txt_guarantor_relation',        
                guarantor_birth_date= '$txt_guarantor_bod',         
                guarantor_birth_place= '$txt_guarantor_bod_place',                  
                guarantor_phone1    = '$txt_guarantor_phone1',      
                guarantor_religion  = '$txt_guarantor_religion',        
                guarantor_phone2    = '$txt_guarantor_phone2',
                guarantor_rt        = '$txt_guarantor_rt',        
                guarantor_rw        = '$txt_guarantor_rw',        
                guarantor_kelurahan = '$txt_guarantor_kelurahan',        
                guarantor_kecamatan = '$txt_guarantor_kecamatan',               
                legal_alamat        = '$txt_legal_address',         
                legal_kabupaten     = '$txt_legal_kab',             
                legal_kodepos       = '$txt_legal_zipcode',         
                legal_rt            = '$txt_legal_rt',              
                legal_kecamatan     = '$txt_legal_kec',             
                legal_sub_kodepos   = '$txt_legal_sub_zipcode',     
                legal_rw            = '$txt_legal_rw',              
                legal_kelurahan     = '$txt_legal_kelurahan',       
                legal_provinsi      = '$txt_legal_prov',                
                survey_alamat       = '$txt_survey_addr',           
                survey_kabupaten    = '$txt_survey_kab',                
                survey_sub_kodepos  = '$txt_survey_subzipcode',     
                survey_rt           = '$txt_survey_rt',             
                survey_kecamatan    = '$txt_survey_kec',                
                ownership           = '$txt_survey_houseowner',     
                survey_rw           = '$txt_survey_rw',             
                survey_kelurahan    = '$txt_survey_kelurahan',      
                length_of_domicile  = '$txt_survey_domicile',       
                survey_provinsi     = '$txt_survey_prov',           
                survey_kodepos      = '$txt_survey_zipcode',            
                profession_name     = '$txt_job_profname',          
                length_of_work      = '$txt_job_work',              
                customer_model      = '$txt_job_modelname',         
                monthly_income      = '$txt_job_penghasilan',       
                industry_type_name  = '$txt_job_industryname',      
                job_phone_1         = '$txt_job_phone1',                
                job_position        = '$txt_job_position',          
                job_phone_2         = '$txt_job_phone2',                
                other_asset         = '$txt_other_type',                
                alternative_phone_no= '$txt_other_alternativephone',    
                visit_notes         = '$txt_other_visitnote',       
                dukcapil_stat       = '$txt_activity_ducapil',
                dukcapil_spouse_stat       = '$txt_activity_pasangan_ducapil',
                negative_spouse_cust       = '$txt_activity_pasangan_neglist',
                dukcapil_guarantor_stat    = '$txt_activity_guarantor_ducapil',
                negative_guarantor_cust    = '$txt_activity_guarantor_neglist',
                negative_cust       = '$txt_activity_neglist',
                follow_up           = '$txt_activity_waktuvisit',
                last_phoneno        = '$dialedno'

                WHERE (customer_id='$txt_customer_no' OR customer_id_ro='$txt_customer_no')"; 
                // product_offering_code = '$three_pro_offering',       
                // ,
                // lob                 = '$mlob'         
$rec_i = mysqli_query($condb,$sqlupd);

    //simulasi
    $sqlsimulasi = "INSERT INTO cc_ts_simulasi SET    
                 id_cust_detail     = '$iddet',
                 id_task            = '$txt_task_id',
                 agrmnt_no          = '$agrmnt_no',
                 form_id            = '$form_id',
                 three_or_office    = '$three_or_office',
                 three_pro_offering = '$three_pro_offering',
                 three_asset_name   = '$three_asset_name',
                 three_mfr_year     = '$three_mfr_year',
                 three_otr          = '$three_otr',
                 three_asset_usage  = '$three_asset_usage',
                 three_admin_fee    = '$three_admin_fee',
                 three_add_adminfee = '$three_add_adminfee',
                 three_biaya_pro    = '$three_biaya_pro',
                 three_ltv_maks     = '$three_ltv_maks',
                 three_ltv_yang     = '$three_ltv_yang',
                 three_ph_maks      = '$three_ph_maks',
                 three_ph_yang      = '$three_ph_yang',
                 three_ins_type     = '$three_ins_type',
                 three_calcu_ins    = '$three_calcu_ins',
                 three_self_ins     = '$three_self_ins',
                 three_tenor        = '$three_tenor',
                 three_calcu_budget = '$three_calcu_budget',
                 three_budget_plan  = '$three_budget_plan',
                 three_calcu_install= '$three_calcu_install',
                 num_duplicate      = '$param_num_duplicate',
                 created_by         = '$v_agentid',
                 modif_by           = '$v_agentid',
                 insert_time        = now(),
                 modif_time         = now()";
    mysqli_query($condb,$sqlsimulasi);

//update job
    $sqlupall = "UPDATE cc_ts_penawaran_job SET    
                    is_assign         = '0'
             WHERE AGRMNT_NO = '$agrmnt_no'";
    mysqli_query($condb,$sqlupall);


if ($txt_activity_result=='5'||$txt_activity_result=='6') {
    //update
    $sqlupall = "UPDATE cc_ts_penawaran_temp SET    
                    visit_notes         = '$txt_other_visitnote',
                    last_phoneno        = '$dialedno',
                    call_status         = '$txt_activity_result',
                    call_status_sub2    = '$txt_activity_result',
                    prospect_stat       = '$txt_prospect_stat',
                    call_status_sub1    = '$txt_activity_substatuscall',
                    last_followup_by    = '$v_agentid',
                    last_followup_date  = now(),
                    modif_time          = now(),
                    follow_up           = '$txt_activity_waktuvisit',
                    $updwaktu
                    remark_desc         = '$txt_activity_notes',
                    total_dial          = total_dial+1
             WHERE id IN ($param_agrmnt)";
    mysqli_query($condb,$sqlupall);

    $sqlupall = "UPDATE cc_ts_penawaran_temp SET    
                    visit_notes         = '$txt_other_visitnote',
                    last_phoneno        = '$dialedno',
                    call_status         = '$txt_activity_result',
                    call_status_sub2    = '$txt_activity_result',
                    prospect_stat       = '$txt_prospect_stat',
                    call_status_sub1    = '$txt_activity_substatuscall',
                    last_followup_by    = '$v_agentid',
                    last_followup_date  = now(),
                    modif_time          = now(),
                    follow_up           = '$txt_activity_waktuvisit',
                    $updwaktu
                    remark_desc         = '$txt_activity_notes',
                    total_dial          = total_dial+1
             WHERE id IN ($param_agrmnt)";
    mysqli_query($condb,$sqlupall);
}

//update customer_id         = '$txt_customer_no',
$sqlup = "UPDATE cc_ts_penawaran_temp SET
                customer_name       = '$txt_customer_name',         
                asset_usage         = '$three_asset_usage',      
                ltv                 = '$three_ltv_yang',
                plafond             = '$three_budget_plan',
                monthly_instalment  = '$three_calcu_install',
                otr_price           = '$three_otr',
                item_year           = '$three_mfr_year',
                product_offering_code = '$three_pro_offering',          
                source_data         = '$txt_sumber_data',           

                nik_ktp             = '$txt_id_no',             
                contact_no          = '$txt_contact_no',             
                mobile_1            = '$txt_mobile_no1',                
                tempat_lahir        = '$txt_birth_place',           
                mobile_2            = '$txt_mobile_phone2',         
                tanggal_lahir       = '$txt_birth_date',            
                phone_1             = '$txt_phone1',                    
                religion            = '$txt_religion',              
                phone_2             = '$txt_phone2',                    
                nama_pasangan       = '$txt_spouse_name',                    
                spouse_name         = '$txt_spouse_name',           
                spouse_phone        = '$txt_spouse_phone',          
                spouse_nik          = '$txt_spouse_nik',                
                spouse_birth_date   = '$txt_spouse_birthdate',      
                spouse_birth_place  = '$txt_spouse_birthplace',      
                spouse_mobile_phone = '$txt_spouse_mobile_phone',     
                tanggal_lahir_pasangan   = '$txt_spouse_birthdate',          
                guarantor_name      = '$txt_guarantor_name',            
                guarantor_phone     = '$txt_guarantor_phone',       
                guarantor_provinsi  = '$txt_guarantor_prov',            
                guarantor_zipcode   = '$txt_guarantor_zip',         
                guarantor_nik       = '$txt_guarantor_nik',         
                guarantor_address   = '$txt_guarantor_addr',            
                guarantor_kabupaten = '$txt_guarantor_kab',         
                guarantor_relation  = '$txt_guarantor_relation',        
                guarantor_birth_date= '$txt_guarantor_bod',         
                guarantor_birth_place= '$txt_guarantor_bod_place',                  
                guarantor_phone1    = '$txt_guarantor_phone1',
                guarantor_rt        = '$txt_guarantor_rt',        
                guarantor_rw        = '$txt_guarantor_rw',        
                guarantor_kelurahan = '$txt_guarantor_kelurahan',        
                guarantor_kecamatan = '$txt_guarantor_kecamatan',                     
                guarantor_religion  = '$txt_guarantor_religion',        
                guarantor_phone2    = '$txt_guarantor_phone2',        
                guarantor_mobile_phone    = '$txt_guarantor_mobile_phone',    
                legal_alamat        = '$txt_legal_address',         
                legal_kabupaten     = '$txt_legal_kab',             
                legal_kodepos       = '$txt_legal_zipcode',         
                legal_rt            = '$txt_legal_rt',              
                legal_kecamatan     = '$txt_legal_kec',             
                legal_sub_kodepos   = '$txt_legal_sub_zipcode',     
                legal_rw            = '$txt_legal_rw',              
                legal_kelurahan     = '$txt_legal_kelurahan',       
                legal_provinsi      = '$txt_legal_prov',                
                survey_alamat       = '$txt_survey_addr',           
                survey_kabupaten    = '$txt_survey_kab',                
                survey_sub_kodepos  = '$txt_survey_subzipcode',     
                survey_rt           = '$txt_survey_rt',             
                survey_kecamatan    = '$txt_survey_kec',                
                house_ownership     = '$txt_survey_houseowner',     
                survey_rw           = '$txt_survey_rw',             
                survey_kelurahan    = '$txt_survey_kelurahan',      
                length_of_domicile  = '$txt_survey_domicile',       
                survey_provinsi     = '$txt_survey_prov',           
                survey_kodepos      = '$txt_survey_zipcode',            
                profession_name     = '$txt_job_profname',          
                length_of_work      = '$txt_job_work',              
                customer_model      = '$txt_job_modelname',         
                monthly_income      = '$txt_job_penghasilan',       
                industry_type_name  = '$txt_job_industryname',      
                job_phone_1         = '$txt_job_phone1',                
                job_position        = '$txt_job_position',          
                job_phone_2         = '$txt_job_phone2',                
                other_asset         = '$txt_other_type',                
                alternative_phone_no= '$txt_other_alternativephone',    
                visit_notes         = '$txt_other_visitnote',
                last_phoneno        = '$dialedno',
                call_status         = '$txt_activity_result',
                call_status_sub2    = '$txt_activity_result',
                prospect_stat       = '$txt_prospect_stat',
                tenor               = '$three_tenor',
                call_status_sub1    = '$txt_activity_substatuscall',
                last_followup_by    = '$v_agentid',
                last_followup_date  = now(),
                modif_time          = now(),
                follow_up           = '$txt_activity_waktuvisit',
                $updwaktu
                remark_desc         = '$txt_activity_notes',
                dukcapil_stat       = '$txt_activity_ducapil',
                negative_cust       = '$txt_activity_neglist',
                total_dial          = total_dial+1,
                lob                 = '$mlob',
                three_ph_yang       = '$three_ph_yang',
                dukcapil_spouse_stat       = '$txt_activity_pasangan_ducapil',
                negative_spouse_cust       = '$txt_activity_pasangan_neglist',
                dukcapil_guarantor_stat    = '$txt_activity_guarantor_ducapil',
                negative_guarantor_cust    = '$txt_activity_guarantor_neglist',
                opsi_penanganan            = '$opsi_penanganan',
                IS_PRE_APPROVAL            = '$txt_IS_PRE_APPROVAL',
                asset_code          = '$asset_code',
                cabang_code         = '$cabang_code',
                three_ins_type      = '$three_ins_type'
         WHERE id='$iddet' ";
mysqli_query($condb,$sqlup);

if($txt_activity_result=='4'){
    $sqla = "SELECT a.agent_id, a.agent_name FROM cc_agent_profile a WHERE a.id='$v_agentid'";
    $resa = mysqli_query($condb,$sqla);
    if($reca = mysqli_fetch_array($resa)){
        $agent_id   = $reca['agent_id'];
        $agent_name = $reca['agent_name'];
    }

    $request_reason = "Reminder Customer : \n <b>$txt_id_no - $txt_customer_name</b>  \n Untuk di Follow Up, \n Follow Up sekarang ? ";

    $sqli = "INSERT INTO cc_call_back SET
                com_ticket          ='$iddet',
                cust_no             ='$agrmnt_no',
                cust_name           ='$txt_customer_name',
                cust_phone1         ='$txt_mobile_no1',
                cust_phone2         ='$txt_mobile_phone2',
                cust_phone3         ='$txt_phone1',
                request_time        ='$txtfollowup',
                request_reason      ='$txt_activity_notes',
                assigned_to         ='$v_agentid',
                assigned_to_id      ='$agent_id',
                assigned_to_name    ='$agent_name',
                type_callback       ='7',
                notif_flag          ='99',
                insert_time         = now(),
                created_by          ='$v_agentid'";
    mysqli_query($condb,$sqli);
}


$sql = "INSERT INTO cc_ts_penawaran_call_session SET
                buck_id             ='$iddet',
                ref_id              ='$references_id',
                task_id             ='$txt_task_id',
                form_id             ='$form_id',
                phone_no            ='$dialedno',
                called_by           ='$v_agentid',
                result              ='$txt_activity_result',
                sub_result          ='$txt_activity_substatuscall',
                remark              ='$txt_activity_notes',
                insert_time         =now(), ";
// $sql .= $sqlclose;
$sql .= "modified_by            ='$v_agentid',
         modify_time            =now()"; //echo $sql;
//call status dan response status sama 
mysqli_query($condb,$sql);

/*
 $sqlall = "INSERT INTO cc_ts_penawaran_history (`form_id`, `id_add_asset`, `id_penawaran`, `polo_order_in_id`, `distributed_date`, `source_data`, `region_code`, `region_name`, `office`, `cabang_code`, `cabang_name`, `cabang_coll`, `cabang_coll_name`, `kapos_name`, `agrmnt_no`, `order_no`, `order_no_rating`, `product`, `product_cat`, `product_offering_code`, `order_no_ro`, `customer_id`, `customer_name`, `nik_ktp`, `religion`, `tempat_lahir`, `tanggal_lahir`, `nama_pasangan`, `tanggal_lahir_pasangan`, `child_name`, `child_birthdate`, `legal_alamat`, `legal_rt`, `legal_rw`, `legal_provinsi`, `legal_kabupaten`, `legal_city`, `legal_kecamatan`, `legal_kelurahan`, `legal_kodepos`, `legal_sub_kodepos`, `survey_alamat`, `survey_rt`, `survey_rw`, `survey_provinsi`, `survey_kabupaten`, `survey_city`, `survey_kecamatan`, `survey_kelurahan`, `survey_kodepos`, `survey_sub_kodepos`, `city_id`, `gender`, `mobile_1`, `mobile_2`, `phone_1`, `phone_2`, `office_phone_1`, `office_phone_2`, `profession_name`, `profession_cat_name`, `job_position`, `industry_type_name`, `monthly_income`, `monthly_instalment`, `lob`, `nama_ibu_kandung`, `education`, `marital_status`, `residance_status`, `dp`, `num_of_dependents`, `length_of_work`, `stay_length`, `status_ktp`, `plafond`, `cust_rating`, `suppl_name`, `suppl_code`, `pekerjaan`, `jenis_pekerjaan`, `detail_pekerjaan`, `oth_biz_name`, `hobby`, `kepemilikan_rumah`, `customer_id_ro`, `customer_rating`, `nama_dealer`, `kode_dealer`, `no_mesin`, `no_rangka`, `asset_type`, `asset_category`, `asset_desc`, `merk`, `asset_price_amount`, `item_id`, `item_type`, `item_desc`, `item_year`, `otr_price`, `kepemilikan_bpkb`, `agrmnt_rating`, `status_kontrak`, `angsuran_ke`, `sisa_tenor`, `tenor`, `release_date_bpkb`, `max_past_due_date`, `tanggal_jatuh_tempo`, `maturity_date`, `est_max_pembiayaan`, `os_principal`, `product_category`, `sisa_piutang`, `kilat_pintar`, `aging_pembiayaan`, `jumlah_kontrak_per_cust`, `estimasi_terima_bersih`, `cycling`, `task_id`, `jenis_task`, `soa`, `down_payment`, `ltv`, `call_stat`, `answer_call`, `prospect_stat`, `reason_not_prospect`, `confirmation`, `notes`, `sla_remaining`, `started_date`, `emp_position`, `application_id`, `application_ia`, `dukcapil_stat`, `field_person_name`, `negative_cust`, `notes_new_lead`, `visit_dt`, `input_dt`, `sub_sitrict_kat_code`, `contact_no`, `source_data_mss`, `referantor_code`, `referantor_name`, `supervisor_name`, `note_telesales`, `submited_dt`, `mss_stat`, `wise_stat`, `visit_stat`, `survey_stat`, `flag_void_sla`, `eligible_flag`, `eligible_flag_dt`, `dtm_crt`, `usr_crt`, `rtm_upd`, `usr_upd`, `app_no`, `application_stat`, `bpkb_out`, `brand`, `city_leg`, `city_res`, `cust_photo`, `dp_pct`, `f_card_photo`, `ia_app`, `id_photo`, `jenis_pembiayaan`, `monthly_expense`, `npwp_no`, `nomor_akta_pendirian`, `nomor_badan_usaha`, `tempat_pendirian`, `tanggal_akta_pendirian`, `order_id`, `other_biz_name`, `ownership`, `pos_dealer`, `promotion_activity`, `referantor_code_1`, `referantor_code_2`, `referantor_name_1`, `referantor_name_2`, `sales_dealer`, `send_flag_wise`, `spouse_id_photo`, `spouse_name`, `spouse_birth_date`, `spouse_birth_place`, `spouse_nik`, `spouse_phone`, `guarantor_name`, `guarantor_nik`, `guarantor_birth_date`, `guarantor_birth_place`, `guarantor_phone`, `guarantor_address`, `guarantor_rt`, `guarantor_rw`, `guarantor_kelurahan`, `guarantor_kecamatan`, `guarantor_kabupaten`, `guarantor_provinsi`, `guarantor_zipcode`, `guarantor_religion`, `guarantor_phone1`, `guarantor_phone2`, `customer_model`, `length_of_domicile`, `penghasilan`, `job_phone_1`, `job_phone_2`, `other_asset`, `alternative_phone_no`, `visit_notes`, `pipeline`, `pot`, `completion_data`, `contract_status`, `dukcapil_result`, `cek_dukcapil`, `waktu_survey`, `guarantor_relation`, `send_flag_mss`, `flag_pre_ia`, `task_id_mss`, `profession_code`, `sales_dealer_id`, `profession_category_code`, `flag_void_sla_tele`, `status_task_mss`, `priority_level`, `outstand_principal`, `outstand_monthly_instalment`, `rrd_date`, `group_id`, `sumber_order`, `special_cash_flag`, `created_by`, `modif_by`, `insert_time`, `modif_time`, `campaign_id`, `external_code`, `priority`, `branch_name`, `phone`, `product_type`, `vehicle_year`, `plafond_price`, `installment_price`, `referentor`, `desc_note`, `desc_note_adv`, `assign_by`, `assign_to`, `assign_time`, `reassign`, `reassign_by`, `reassign_time`, `first_call_time`, `first_followup_by`, `follow_up`, `remark_desc`, `last_phoneno`, `last_call_time`, `last_followup_by`, `last_followup_date`, `call_status`, `call_status_sub1`, `call_status_sub2`, `total_dial`, `total_phone`, `total_course`, `status`, `status_bypass`, `status_approve`, `close_time`, `close_by`, `close_approve_time`, `close_approve_by`, `qa_approve_status`, `qa_approve_note`, `qa_approve_time`, `qa_approve_by`, `flag_pushtopolo`, `flag_auto`, `api_flag`, `create_by`, `create_time`)
                        SELECT '$form_id','$add_asset_id',a.*,'$v_agentid',NOW() FROM cc_ts_penawaran a
                        WHERE a.id='$iddet' "; */
$sqlall = "INSERT INTO cc_ts_penawaran_history2 (form_id,
 id_add_asset,
            id_penawaran,
            AGRMNT_ID,
            polo_order_in_id,
            distributed_date,
            source_data,
            region_code,
            region_name,
            office,
            cabang_code,
            cabang_name,
            cabang_coll,
            cabang_coll_name,
            kapos_name,
            agrmnt_no,
            no_pengajuan,
            order_no,
            order_no_rating,
            product,
            product_cat,
            product_offering_code,
            order_no_ro,
            customer_id,
            customer_name,
            nik_ktp,
            religion,
            tempat_lahir,
            tanggal_lahir,
            nama_pasangan,
            tanggal_lahir_pasangan,
            child_name,
            child_birthdate,
            legal_alamat,
            legal_rt,
            legal_rw,
            legal_provinsi,
            legal_kabupaten,
            legal_city,
            legal_kecamatan,
            legal_kelurahan,
            legal_kodepos,
            legal_sub_kodepos,
            survey_alamat,
            survey_rt,
            survey_rw,
            survey_provinsi,
            survey_kabupaten,
            survey_city,
            survey_kecamatan,
            survey_kelurahan,
            survey_kodepos,
            survey_sub_kodepos,
            city_id,
            gender,
            mobile_1,
            mobile_2,
            phone_1,
            phone_2,
            office_phone_1,
            office_phone_2,
            profession_name,
            profession_cat_name,
            job_position,
            industry_type_name,
            monthly_income,
            monthly_instalment,
            three_ph_yang,
            three_ins_type,
            lob,
            nama_ibu_kandung,
            education,
            marital_status,
            residance_status,
            dp,
            num_of_dependents,
            length_of_work,
            stay_length,
            status_ktp,
            plafond,
            cust_rating,
            suppl_name,
            suppl_code,
            pekerjaan,
            jenis_pekerjaan,
            detail_pekerjaan,
            oth_biz_name,
            hobby,
            kepemilikan_rumah,
            customer_id_ro,
            customer_rating,
            nama_dealer,
            kode_dealer,
            no_mesin,
            no_rangka,
            asset_usage,
            asset_type,
            asset_category,
            asset_type_desc,
            asset_desc,
            asset_ownership,
            asset_age,
            platfond_max,
            installment_amount,
            ltv_amount,
            ltv_percent_amount,
            merk,
            asset_price_amount,
            item_id,
            item_type,
            item_desc,
            item_year,
            otr_price,
            kepemilikan_bpkb,
            agrmnt_rating,
            status_kontrak,
            angsuran_ke,
            sisa_tenor,
            tenor,
            release_date_bpkb,
            max_past_due_date,
            tanggal_jatuh_tempo,
            maturity_date,
            est_max_pembiayaan,
            os_principal,
            product_category,
            sisa_piutang,
            kilat_pintar,
            aging_pembiayaan,
            jumlah_kontrak_per_cust,
            estimasi_terima_bersih,
            cycling,
            task_id,
            jenis_task,
            soa,
            down_payment,
            ltv,
            call_stat,
            answer_call,
            prospect_stat,
            reason_not_prospect,
            confirmation,
            notes,
            sla_remaining,
            started_date,
            emp_position,
            application_id,
            application_ia,
            dukcapil_stat,
            field_person_name,
            negative_cust,
            dukcapil_spouse_stat,
            negative_spouse_cust,
            dukcapil_guarantor_stat,
            negative_guarantor_cust,
            notes_new_lead,
            visit_dt,
            input_dt,
            sub_sitrict_kat_code,
            contact_no,
            source_data_mss,
            referantor_code,
            referantor_name,
            supervisor_name,
            note_telesales,
            submited_dt,
            mss_stat,
            wise_stat,
            visit_stat,
            survey_stat,
            flag_void_sla,
            eligible_flag,
            eligible_flag_dt,
            dtm_crt,
            usr_crt,
            rtm_upd,
            usr_upd,
            app_no,
            application_stat,
            bpkb_out,
            brand,
            city_leg,
            city_res,
            cust_photo,
            dp_pct,
            f_card_photo,
            ia_app,
            id_photo,
            jenis_pembiayaan,
            monthly_expense,
            npwp_no,
            nomor_akta_pendirian,
            nomor_badan_usaha,
            tempat_pendirian,
            tanggal_akta_pendirian,
            order_id,
            other_biz_name,
            ownership,
            pos_dealer,
            promotion_activity,
            referantor_code_1,
            referantor_code_2,
            referantor_name_1,
            referantor_name_2,
            sales_dealer,
            send_flag_wise,
            spouse_id_photo,
            spouse_name,
            spouse_birth_date,
            spouse_birth_place,
            spouse_nik,
            spouse_phone,
            spouse_mobile_phone,
            guarantor_name,
            guarantor_nik,
            guarantor_birth_date,
            guarantor_birth_place,
            guarantor_phone,
            guarantor_address,
            guarantor_rt,
            guarantor_rw,
            guarantor_kelurahan,
            guarantor_kecamatan,
            guarantor_kabupaten,
            guarantor_provinsi,
            guarantor_zipcode,
            guarantor_religion,
            guarantor_phone1,
            guarantor_phone2,
            guarantor_mobile_phone,
            customer_model,
            length_of_domicile,
            penghasilan,
            job_phone_1,
            job_phone_2,
            other_asset,
            alternative_phone_no,
            visit_notes,
            pipeline,
            pot,
            completion_data,
            contract_status,
            dukcapil_result,
            cek_dukcapil,
            waktu_survey,
            guarantor_relation,
            send_flag_mss,
            flag_pre_ia,
            task_id_mss,
            profession_code,
            sales_dealer_id,
            profession_category_code,
            flag_void_sla_tele,
            status_task_mss,
            campaign_dt,
            is_duplicate,
            order_id_dealer,
            go_live_dt,
            ntf_amt,
            lengthofwork,
            company_name,
            duplicate_nuw,
            apu_ppt_match_stat,
            matching_coordinate,
            slik_score,
            credit_score,
            income_result,
            pefindo_score,
            final_result_cae,
            asset_code,
            due_dt,
            os_installment_amt,
            status_call,
            notes_other_vehicle,
            notes_phone_alternative,
            polo_stat,
            polo_step,
            img_slip_approval_doc,
            submit_by,
            role_name,
            img_approval_from_slik,
            img_family_card,
            long_survey,
            lat_survey,
            dsr,
            house_stay_length,
            layer,
            installment_amt,
            down_payment_gross,
            is_slik_approval,
            img_slefie_cust,
            guarantor_photo,
            spouse_biometric_result,
            guarantor_biometic_result,
            is_survey_addr_with_legal,
            house_ownership,
            guarantor_email,
            is_guarantor_add_different,
            is_spouse_addr_different,
            spouse_legal,
            spouse_legal_rt,
            spouse_legal_rw,
            spouse_legal_province,
            spouse_legal_city,
            spouse_legal_kecamatan,
            spouse_legal_kelurahan,
            spouse_legal_zipcode,
            spouse_email,
            spouse_mobile_phone_no,
            guarantor_id_photo,
            is_spouse_appr,
            img_spouse_not_participate,
            stat_dt,
            stat_final_wise_dt,
            num_of_reset_cycling,
            surveyor_name,
            surveyor_id,
            surveyor_emp_position,
            surveyor_spv,
            surveyor_spv_id,
            surveyor_spv_emp_position,
            approval_engine_result,
            first_stat,
            img_slik_approval_doc,
            img_selfie_cust,
            is_guarantor_addr_different,
            is_digital_sign,
            spouse_photo,
            spouse_mother_maiden_name,
            is_spouse_document_not_complate,
            mandatory_level,
            geotag_result,
            pipeline_code,
            down_payment_percentage,
            exposure,
            is_insurance,
            is_negative,
            is_repo,
            is_restructure,
            is_write_off,
            license_plate_no,
            surveryor_spv_emp_position,
            is_document_not_complete,
            geotag_addr,
            result_check_mobile_phone_no,
            priority_level,
            outstand_principal,
            outstand_monthly_instalment,
            rrd_date,
            group_id,
            sumber_order,
            special_cash_flag,
            created_by,
            modif_by,
            insert_time,
            modif_time,
            campaign_id,
            campaign_id_job,
            external_code,
            priority,
            branch_name,
            phone,
            product_type,
            vehicle_year,
            plafond_price,
            installment_price,
            referentor,
            desc_note,
            desc_note_adv,
            assign_by,
            assign_to,
            spv_id,
            assign_time,
            reassign,
            reassign_by,
            reassign_time,
            first_call_time,
            first_followup_by,
            follow_up,
            remark_desc,
            last_phoneno,
            last_call_time,
            last_followup_by,
            last_followup_date,
            last_followup_time,
            call_status,
            call_status_sub1,
            call_status_sub2,
            total_dial,
            total_phone,
            total_course,
            status,
            status_bypass,
            status_approve,
            close_time,
            close_by,
            close_approve_time,
            close_approve_by,
            qa_approve_status,
            qa_approve_note,
            qa_approve_time,
            qa_approve_by,
            flag_pushtopolo,
            flag_auto,
            count_node,
            api_flag,
            back_flag,
            flag_wise,
            is_eligible_crm,
            is_process,
            is_pre_approval,
            opsi_penanganan,
            create_by,
            create_time)
                SELECT '$form_id','$add_asset_id',a.*,'$v_agentid',NOW() FROM cc_ts_penawaran_temp a
                        WHERE a.id='$iddet'"; //echo $sqlall;
if($rec_u = mysqli_query($condb,$sqlall)) {
    echo "Success!";
} else {
    echo "Failed";
}
 
disconnectDB($condb);
?>