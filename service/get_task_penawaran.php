<?php 
ini_set('post_max_size', '264M');
ini_set('upload_max_filesize', '264M');
// ini_set('memory_limit', '296M');
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 3000);

include "../../sysconf/db_config.php";

$server = $server_staging;
$username = $username_staging;  
$password = $password_staging;
$con = mssql_connect($server, $username, $password);
mssql_select_db( $dbname_staging, $con );


/* config mysql */ 
$conf_ip            = $ip_conf;  
$conf_user          = $user_conf;
$conf_passwd        = $password_conf;
$conf_db              = $dbname;


function connectDB() {
    global $conf_ip, $conf_user, $conf_passwd, $conf_db ;   
    if (!$connect=mysqli_connect($conf_ip, $conf_user, $conf_passwd, $conf_db)) {
      $filename = __FILE__;
      $linename = __LINE__;
     // exit();
    }
    return $connect;
}


function disconnectDB($db_connect) {
    mysqli_close($db_connect);
}


if ($con) {
    //echo "Koneksi Berhasil !";
} else {
    echo "Koneksi gagal !";
    die(print_r(mssql_error(),true));
}

echo "Process...";
echo "<br>";
echo "<br>";
$dateexe = DATE("Y-m-d H:i:s");
$dbopen  = connectDB();
// $datenow = DATE("Y-m-d");


//$sqlclear = "TRUNCATE cc_ts_consumer_detail";
//$resclear = mysqli_query($dbopen,$sqlclear);
    //top 100
    $no =1;
    $suc1=0;
    $err1=0;
   // $mss_1 = "SELECT top 10 * FROM WISE_STAGING..T_COLL_TELECOLL_POPULATE_DATA";//echo "string $mss_1"; (NOLOCK)
//    $mss_1 = "select top 2 * from WISE_STAGING..T_MKT_POLO_ELIGIBLE
// where IS_ACTIVE='1'";

$sqlflag = "UPDATE cc_ts_penawaran_job SET is_eligible_crm=0 WHERE SOURCE_DATA = 'WISE'";
$resflag = mysqli_query($dbopen,$sqlflag);

   // $mss_1 = "select A.* from WISE_STAGING..T_MKT_POLO_ELIGIBLE A
   //           LEFT JOIN WISE_STAGING..T_MKT_POLO_ORDER_IN B ON A.AGRMNT_NO = B.AGRMNT_NO AND B.POLO_STEP='TASK MVS'
   //           where A.IS_ACTIVE = '1'
   //           AND B.AGRMNT_NO IS NULL";//AND A.ASSET_TYPE='MOBIL'
$mss_1 = "select A.* FROM WISE_STAGING..T_MKT_POLO_ELIGIBLE A WITH(NOLOCK) 
             LEFT JOIN WISE_STAGING..T_MKT_POLO_ORDER_IN B WITH(NOLOCK) ON A.AGRMNT_NO = B.AGRMNT_NO AND B.POLO_STEP IN ('TASK MVS','TASK MSS', 'TASK MSS 2', 'TASK MSS AC',
             'TASK WISE')
             WHERE A.IS_ACTIVE = '1'
             AND B.AGRMNT_NO IS NULL";
    $rss_1 = mssql_query($mss_1);
    while($rcs_1 = mssql_fetch_array($rss_1)){

       // echo $rcs_1['T_COLL_TELECOLL_POPULATE_DATA_ID']; echo "<br>";
      // print_r($rcs_1);echo "<br><br>";
       // print("<pre>".print_r($rcs_1,true)."</pre>");echo "<br><br>";

        $AGRMNT_ID = $rcs_1['AGRMNT_ID']; 
        $AGRMNT_NO = mysqli_real_escape_string($dbopen,$rcs_1['AGRMNT_NO']); 
        $AGRMNT_DT = mysqli_real_escape_string($dbopen,$rcs_1['AGRMNT_DT']); 
        $PIPELINE_ID = mysqli_real_escape_string($dbopen,$rcs_1['PIPELINE_ID']); 
        $JOB_ID = mysqli_real_escape_string($dbopen,$rcs_1['JOB_ID']); 
        $IS_ACTIVE = mysqli_real_escape_string($dbopen,$rcs_1['IS_ACTIVE']); 
        $DISTRIBUTED_DT = mysqli_real_escape_string($dbopen,$rcs_1['DISTRIBUTED_DT']); 
        $DISTRIBUTED_USR = mysqli_real_escape_string($dbopen,$rcs_1['DISTRIBUTED_USR']); 
        $IS_COMPLETE = mysqli_real_escape_string($dbopen,$rcs_1['IS_COMPLETE']); 
        $COMPLETED_DT = mysqli_real_escape_string($dbopen,$rcs_1['COMPLETED_DT']); 
        $CAE_FINAL_SCORE = mysqli_real_escape_string($dbopen,$rcs_1['CAE_FINAL_SCORE']); 
        $CAE_FINAL_RESULT = mysqli_real_escape_string($dbopen,$rcs_1['CAE_FINAL_RESULT']); 
        $CAE_RESULT = mysqli_real_escape_string($dbopen,$rcs_1['CAE_RESULT']); 
        $CAE_DT = mysqli_real_escape_string($dbopen,$rcs_1['CAE_DT']); 
        $DUKCAPIL = mysqli_real_escape_string($dbopen,$rcs_1['DUKCAPIL']); 
        $DUKCAPIL_RESULT = mysqli_real_escape_string($dbopen,$rcs_1['DUKCAPIL_RESULT']); 
        $DUKCAPIL_API_DT = mysqli_real_escape_string($dbopen,$rcs_1['DUKCAPIL_API_DT']); 
        $SCHEME_ID = mysqli_real_escape_string($dbopen,$rcs_1['SCHEME_ID']); 
        $SLIK_CBASID = mysqli_real_escape_string($dbopen,$rcs_1['SLIK_CBASID']); 
        $SLIK_RESULT = mysqli_real_escape_string($dbopen,$rcs_1['SLIK_RESULT']); 
        $SLIK_CATEGORY = mysqli_real_escape_string($dbopen,$rcs_1['SLIK_CATEGORY']); 
        $SLIK_API_DT = mysqli_real_escape_string($dbopen,$rcs_1['SLIK_API_DT']); 
        $SOURCE_DATA = mysqli_real_escape_string($dbopen,$rcs_1['SOURCE_DATA']); 
        $KILAT_PINTAR = mysqli_real_escape_string($dbopen,$rcs_1['KILAT_PINTAR']); 
        $BUSINESS_DATE = mysqli_real_escape_string($dbopen,$rcs_1['BUSINESS_DATE']); 
        $OFFICE_REGION_CODE = mysqli_real_escape_string($dbopen,$rcs_1['OFFICE_REGION_CODE']); 
        $OFFICE_REGION_NAME = mysqli_real_escape_string($dbopen,$rcs_1['OFFICE_REGION_NAME']); 
        $OFFICE_CODE = mysqli_real_escape_string($dbopen,$rcs_1['OFFICE_CODE']); 
        $OFFICE_NAME = mysqli_real_escape_string($dbopen,$rcs_1['OFFICE_NAME']); 
        $CAB_COLL = mysqli_real_escape_string($dbopen,$rcs_1['CAB_COLL']); 
        $CAB_COLL_NAME = mysqli_real_escape_string($dbopen,$rcs_1['CAB_COLL_NAME']); 
        $KAPOS_NAME = mysqli_real_escape_string($dbopen,$rcs_1['KAPOS_NAME']); 
        $PROD_OFFERING_CODE = mysqli_real_escape_string($dbopen,$rcs_1['PROD_OFFERING_CODE']); 
        $LOB_CODE = mysqli_real_escape_string($dbopen,$rcs_1['LOB_CODE']); 
        $CUST_TYPE = mysqli_real_escape_string($dbopen,$rcs_1['CUST_TYPE']); 
        $CUST_NO = mysqli_real_escape_string($dbopen,$rcs_1['CUST_NO']); 
        $CUST_NAME = mysqli_real_escape_string($dbopen,$rcs_1['CUST_NAME']); 
        $ID_NO = mysqli_real_escape_string($dbopen,$rcs_1['ID_NO']); 
        $GENDER = mysqli_real_escape_string($dbopen,$rcs_1['GENDER']); 
        $RELIGION = mysqli_real_escape_string($dbopen,$rcs_1['RELIGION']); 
        $BIRTH_PLACE = mysqli_real_escape_string($dbopen,$rcs_1['BIRTH_PLACE']); 
        $BIRTH_DT = mysqli_real_escape_string($dbopen,$rcs_1['BIRTH_DT']); 
        $BIRTH_DT = date("Y-m-d h:i:s", strtotime($BIRTH_DT));
        $SPOUSE_ID_NO = mysqli_real_escape_string($dbopen,$rcs_1['SPOUSE_ID_NO']); 
        $SPOUSE_NAME = mysqli_real_escape_string($dbopen,$rcs_1['SPOUSE_NAME']); 
        $SPOUSE_BIRTH_DT = mysqli_real_escape_string($dbopen,$rcs_1['SPOUSE_BIRTH_DT']); 
        $ADDR_LEG = mysqli_real_escape_string($dbopen,$rcs_1['ADDR_LEG']); 
        $RT_LEG = mysqli_real_escape_string($dbopen,$rcs_1['RT_LEG']); 
        $RW_LEG = mysqli_real_escape_string($dbopen,$rcs_1['RW_LEG']); 
        $PROVINSI_LEG = mysqli_real_escape_string($dbopen,$rcs_1['PROVINSI_LEG']); 
        $CITY_LEG = mysqli_real_escape_string($dbopen,$rcs_1['CITY_LEG']); 
        $KABUPATEN_LEG = mysqli_real_escape_string($dbopen,$rcs_1['KABUPATEN_LEG']); 
        $KECAMATAN_LEG = mysqli_real_escape_string($dbopen,$rcs_1['KECAMATAN_LEG']); 
        $KELURAHAN_LEG = mysqli_real_escape_string($dbopen,$rcs_1['KELURAHAN_LEG']); 
        $ZIPCODE_LEG = mysqli_real_escape_string($dbopen,$rcs_1['ZIPCODE_LEG']); 
        $SUB_ZIPCODE_LEG = mysqli_real_escape_string($dbopen,$rcs_1['SUB_ZIPCODE_LEG']); 
        $ADDR_RES = mysqli_real_escape_string($dbopen,$rcs_1['ADDR_RES']); 
        $RT_RES = mysqli_real_escape_string($dbopen,$rcs_1['RT_RES']); 
        $RW_RES = mysqli_real_escape_string($dbopen,$rcs_1['RW_RES']); 
        $PROVINSI_RES = mysqli_real_escape_string($dbopen,$rcs_1['PROVINSI_RES']); 
        $CITY_RES = mysqli_real_escape_string($dbopen,$rcs_1['CITY_RES']); 
        $KABUPATEN_RES = mysqli_real_escape_string($dbopen,$rcs_1['KABUPATEN_RES']); 
        $KECAMATAN_RES = mysqli_real_escape_string($dbopen,$rcs_1['KECAMATAN_RES']); 
        $KELURAHAN_RES = mysqli_real_escape_string($dbopen,$rcs_1['KELURAHAN_RES']); 
        $ZIPCODE_RES = mysqli_real_escape_string($dbopen,$rcs_1['ZIPCODE_RES']); 
        $SUB_ZIPCODE_RES = mysqli_real_escape_string($dbopen,$rcs_1['SUB_ZIPCODE_RES']); 
        $MOBILE1 = mysqli_real_escape_string($dbopen,$rcs_1['MOBILE1']); 
        $MOBILE2 = mysqli_real_escape_string($dbopen,$rcs_1['MOBILE2']); 
        $PHONE1 = mysqli_real_escape_string($dbopen,$rcs_1['PHONE1']); 
        $PHONE2 = mysqli_real_escape_string($dbopen,$rcs_1['PHONE2']); 
        $OFFICE_PHONE1 = mysqli_real_escape_string($dbopen,$rcs_1['OFFICE_PHONE1']); 
        $OFFICE_PHONE2 = mysqli_real_escape_string($dbopen,$rcs_1['OFFICE_PHONE2']); 
        $PROFESSION_CODE = mysqli_real_escape_string($dbopen,$rcs_1['PROFESSION_CODE']); 
        $PROFESSION_NAME = mysqli_real_escape_string($dbopen,$rcs_1['PROFESSION_NAME']); 
        $PROFESSION_CATEGORY_CODE = mysqli_real_escape_string($dbopen,$rcs_1['PROFESSION_CATEGORY_CODE']); 
        $PROFESSION_CATEGORY_NAME = mysqli_real_escape_string($dbopen,$rcs_1['PROFESSION_CATEGORY_NAME']); 
        $JOB_POSITION = mysqli_real_escape_string($dbopen,$rcs_1['JOB_POSITION']); 
        $JOB_STATUS = mysqli_real_escape_string($dbopen,$rcs_1['JOB_STATUS']); 
        $INDUSTRY_TYPE_NAME = mysqli_real_escape_string($dbopen,$rcs_1['INDUSTRY_TYPE_NAME']); 
        $OTHER_BIZ_NAME = mysqli_real_escape_string($dbopen,$rcs_1['OTHER_BIZ_NAME']); 
        $MONTHLY_INCOME = mysqli_real_escape_string($dbopen,$rcs_1['MONTHLY_INCOME']); 
        $MONTHLY_EXPENSE = mysqli_real_escape_string($dbopen,$rcs_1['MONTHLY_EXPENSE']); 
        $MONTHLY_INSTALLMENT = mysqli_real_escape_string($dbopen,$rcs_1['MONTHLY_INSTALLMENT']); 
        $DOWNPAYMENT = mysqli_real_escape_string($dbopen,$rcs_1['DOWNPAYMENT']); 
        $PERCENT_DP = mysqli_real_escape_string($dbopen,$rcs_1['PERCENT_DP']); 
        $PLAFOND = mysqli_real_escape_string($dbopen,$rcs_1['PLAFOND']); 
        $CUST_RATING = mysqli_real_escape_string($dbopen,$rcs_1['CUST_RATING']); 
        $SUPPL_NAME = mysqli_real_escape_string($dbopen,$rcs_1['SUPPL_NAME']); 
        $SUPPL_CODE = mysqli_real_escape_string($dbopen,$rcs_1['SUPPL_CODE']); 
        $MACHINE_NO = mysqli_real_escape_string($dbopen,$rcs_1['MACHINE_NO']); 
        $CHASSIS_NO = mysqli_real_escape_string($dbopen,$rcs_1['CHASSIS_NO']); 
        $PRODUCT_CATEGORY = mysqli_real_escape_string($dbopen,$rcs_1['PRODUCT_CATEGORY']); 
        $ASSET_CATEGORY_CODE = mysqli_real_escape_string($dbopen,$rcs_1['ASSET_CATEGORY_CODE']); 
        $ASSET_TYPE = mysqli_real_escape_string($dbopen,$rcs_1['ASSET_TYPE']); 
        $ITEM_BRAND = mysqli_real_escape_string($dbopen,$rcs_1['ITEM_BRAND']); 
        $ITEM_TYPE = mysqli_real_escape_string($dbopen,$rcs_1['ITEM_TYPE']); 
        $ITEM_DESCRIPTION = mysqli_real_escape_string($dbopen,$rcs_1['ITEM_DESCRIPTION']); 
        $ASSET_MODEL = mysqli_real_escape_string($dbopen,$rcs_1['ASSET_MODEL']); 
        $OTR_PRICE = mysqli_real_escape_string($dbopen,$rcs_1['OTR_PRICE']); 
        $ITEM_YEAR = mysqli_real_escape_string($dbopen,$rcs_1['ITEM_YEAR']); 
        $OWNER_RELATIONSHIP = mysqli_real_escape_string($dbopen,$rcs_1['OWNER_RELATIONSHIP']); 
        $BPKB_OWNERSHIP = mysqli_real_escape_string($dbopen,$rcs_1['BPKB_OWNERSHIP']); 
        $AGRMNT_RATING = mysqli_real_escape_string($dbopen,$rcs_1['AGRMNT_RATING']); 
        $CONTRACT_STAT = mysqli_real_escape_string($dbopen,$rcs_1['CONTRACT_STAT']); 
        $INST_PAYED = mysqli_real_escape_string($dbopen,$rcs_1['INST_PAYED']); 
        $NEXT_INST_NUM = mysqli_real_escape_string($dbopen,$rcs_1['NEXT_INST_NUM']); 
        $NEXT_INST_DT = mysqli_real_escape_string($dbopen,$rcs_1['NEXT_INST_DT']); 
        $OS_TENOR = mysqli_real_escape_string($dbopen,$rcs_1['OS_TENOR']); 
        $TENOR = mysqli_real_escape_string($dbopen,$rcs_1['TENOR']); 
        $RELEASE_DATE_BPKB = mysqli_real_escape_string($dbopen,$rcs_1['RELEASE_DATE_BPKB']); 
        $MATURITY_DT = mysqli_real_escape_string($dbopen,$rcs_1['MATURITY_DT']); 
        $MATURITY_DURATION = mysqli_real_escape_string($dbopen,$rcs_1['MATURITY_DURATION']); 
        $GO_LIVE_DT = mysqli_real_escape_string($dbopen,$rcs_1['GO_LIVE_DT']); 
        $GO_LIVE_DURATION = mysqli_real_escape_string($dbopen,$rcs_1['GO_LIVE_DURATION']); 
        $AAM_RRD_DT = mysqli_real_escape_string($dbopen,$rcs_1['AAM_RRD_DT']); 
        $EXPIRED_MONTHS = mysqli_real_escape_string($dbopen,$rcs_1['EXPIRED_MONTHS']); 
        $OS_PRINCIPAL = mysqli_real_escape_string($dbopen,$rcs_1['OS_PRINCIPAL']); 
        $OS_PRINCIPAL_AMT = mysqli_real_escape_string($dbopen,$rcs_1['OS_PRINCIPAL_AMT']); 
        $OS_INTEREST_AMT = mysqli_real_escape_string($dbopen,$rcs_1['OS_INTEREST_AMT']); 
        $AGING_PEMBIAYAAN = mysqli_real_escape_string($dbopen,$rcs_1['AGING_PEMBIAYAAN']); 
        $JUMLAH_KONTRAK_PERCUST = mysqli_real_escape_string($dbopen,$rcs_1['JUMLAH_KONTRAK_PERCUST']); 
        $ESTIMASI_TERIMA_BERSIH = mysqli_real_escape_string($dbopen,$rcs_1['ESTIMASI_TERIMA_BERSIH']); 
        $STARTED_DT = mysqli_real_escape_string($dbopen,$rcs_1['STARTED_DT']); 
        $POS_DEALER = mysqli_real_escape_string($dbopen,$rcs_1['POS_DEALER']); 
        $SALES_DEALER_ID = mysqli_real_escape_string($dbopen,$rcs_1['SALES_DEALER_ID']); 
        $SALES_DEALER = mysqli_real_escape_string($dbopen,$rcs_1['SALES_DEALER']); 
        $DTM_CRT = mysqli_real_escape_string($dbopen,$rcs_1['DTM_CRT']); 
        $USR_CRT = mysqli_real_escape_string($dbopen,$rcs_1['USR_CRT']); 
        $DTM_UPD = mysqli_real_escape_string($dbopen,$rcs_1['DTM_UPD']); 
        $USR_UPD = mysqli_real_escape_string($dbopen,$rcs_1['USR_UPD']); 
        $COLL_AGRMNT_ID = mysqli_real_escape_string($dbopen,$rcs_1['COLL_AGRMNT_ID']); 
        $AGRMNT_ASSET_ID = mysqli_real_escape_string($dbopen,$rcs_1['AGRMNT_ASSET_ID']); 
        $ASSET_MASTER_ID = mysqli_real_escape_string($dbopen,$rcs_1['ASSET_MASTER_ID']); 
        $DEFAULT_STAT = mysqli_real_escape_string($dbopen,$rcs_1['DEFAULT_STAT']); 
        $CUST_ID = mysqli_real_escape_string($dbopen,$rcs_1['CUST_ID']); 
        $HOME_STAT = mysqli_real_escape_string($dbopen,$rcs_1['HOME_STAT']); 
        $MOTHER_NAME = mysqli_real_escape_string($dbopen,$rcs_1['MOTHER_NAME']); 
        $IS_EVER_REPO = mysqli_real_escape_string($dbopen,$rcs_1['IS_EVER_REPO']); 
        $IS_REPO = mysqli_real_escape_string($dbopen,$rcs_1['IS_REPO']); 
        $IS_WRITE_OFF = mysqli_real_escape_string($dbopen,$rcs_1['IS_WRITE_OFF']); 
        $IS_RESTRUKTUR = mysqli_real_escape_string($dbopen,$rcs_1['IS_RESTRUKTUR']); 
        $IS_INSURANCE = mysqli_real_escape_string($dbopen,$rcs_1['IS_INSURANCE']); 
        $IS_NEGATIVE_CUST = mysqli_real_escape_string($dbopen,$rcs_1['IS_NEGATIVE_CUST']); 
        $IS_ACCOUNT_BAM = mysqli_real_escape_string($dbopen,$rcs_1['IS_ACCOUNT_BAM']); 
        $CUST_EXPOSURE = mysqli_real_escape_string($dbopen,$rcs_1['CUST_EXPOSURE']); 
        $AGE = mysqli_real_escape_string($dbopen,$rcs_1['AGE']); 
        $ASSET_AGE = mysqli_real_escape_string($dbopen,$rcs_1['ASSET_AGE']); 
        $SAME_ASSET_GO_LIVE = mysqli_real_escape_string($dbopen,$rcs_1['SAME_ASSET_GO_LIVE']); 
        $LTV = mysqli_real_escape_string($dbopen,$rcs_1['LTV']); 
        $DSR = mysqli_real_escape_string($dbopen,$rcs_1['DSR']); 
        $MARITAL_STAT = mysqli_real_escape_string($dbopen,$rcs_1['MARITAL_STAT']); 
        $EDUCATION = mysqli_real_escape_string($dbopen,$rcs_1['EDUCATION']); 
        $EMPLOYMENT_ESTABLISHMENT_DT = mysqli_real_escape_string($dbopen,$rcs_1['EMPLOYMENT_ESTABLISHMENT_DT']); 
        $LENGTH_OF_WORK = mysqli_real_escape_string($dbopen,$rcs_1['LENGTH_OF_WORK']); 
        $HOUSE_STAY_LENGTH = mysqli_real_escape_string($dbopen,$rcs_1['HOUSE_STAY_LENGTH']); 
        $LAST_OVERDUE = mysqli_real_escape_string($dbopen,$rcs_1['LAST_OVERDUE']); 
        $MAX_OVERDUE = mysqli_real_escape_string($dbopen,$rcs_1['MAX_OVERDUE']); 
        $MAX_OVERDUE_LAST_X_MONTHS = mysqli_real_escape_string($dbopen,$rcs_1['MAX_OVERDUE_LAST_X_MONTHS']); 
        $IS_USED = mysqli_real_escape_string($dbopen,$rcs_1['IS_USED']);
        $SPOUSE_BIRTH_PLACE = mysqli_real_escape_string($dbopen,$rcs_1['SPOUSE_BIRTH_PLACE']);

        $IS_SELECTED = mysqli_real_escape_string($dbopen,$rcs_1['IS_SELECTED']);
        $PIPELINE_DUMMY_ID = mysqli_real_escape_string($dbopen,$rcs_1['PIPELINE_DUMMY_ID']);
        $PIPELINE_DUMMY_IS_EARLY_WSC = mysqli_real_escape_string($dbopen,$rcs_1['PIPELINE_DUMMY_IS_EARLY_WSC']);
        $FINAL_DT = mysqli_real_escape_string($dbopen,$rcs_1['FINAL_DT']);

        $SPOUSE_PHONE = mysqli_real_escape_string($dbopen,$rcs_1['SPOUSE_PHONE']);
        $SPOUSE_MOBILE_PHONE_NO = mysqli_real_escape_string($dbopen,$rcs_1['SPOUSE_MOBILE_PHONE_NO']);
        $GUARANTOR_ID_NO = mysqli_real_escape_string($dbopen,$rcs_1['GUARANTOR_ID_NO']);
        $GUARANTOR_NAME = mysqli_real_escape_string($dbopen,$rcs_1['GUARANTOR_NAME']);
        $GUARANTOR_MOBILE_PHONE_NO = mysqli_real_escape_string($dbopen,$rcs_1['GUARANTOR_MOBILE_PHONE_NO']);
        $GUARANTOR_BIRTH_PLACE = mysqli_real_escape_string($dbopen,$rcs_1['GUARANTOR_BIRTH_PLACE']);
        $GUARANTOR_BIRTH_DT = mysqli_real_escape_string($dbopen,$rcs_1['GUARANTOR_BIRTH_DT']);
        $GUARANTOR_ADDR = mysqli_real_escape_string($dbopen,$rcs_1['GUARANTOR_ADDR']);
        $GUARANTOR_RT = mysqli_real_escape_string($dbopen,$rcs_1['GUARANTOR_RT']);
        $GUARANTOR_RW = mysqli_real_escape_string($dbopen,$rcs_1['GUARANTOR_RW']);
        $GUARANTOR_KELURAHAN = mysqli_real_escape_string($dbopen,$rcs_1['GUARANTOR_KELURAHAN']);
        $GUARANTOR_KECAMATAN = mysqli_real_escape_string($dbopen,$rcs_1['GUARANTOR_KECAMATAN']);
        $GUARANTOR_CITY = mysqli_real_escape_string($dbopen,$rcs_1['GUARANTOR_CITY']);
        $GUARANTOR_PROVINSI = mysqli_real_escape_string($dbopen,$rcs_1['GUARANTOR_PROVINSI']);
        $GUARANTOR_ZIPCODE = mysqli_real_escape_string($dbopen,$rcs_1['GUARANTOR_ZIPCODE']);
        $GUARANTOR_SUBZIPCODE = mysqli_real_escape_string($dbopen,$rcs_1['GUARANTOR_SUBZIPCODE']);
        $GUARANTOR_RELATIONSHIP = mysqli_real_escape_string($dbopen,$rcs_1['GUARANTOR_RELATIONSHIP']);
        $SPOUSE_CUST_ID = mysqli_real_escape_string($dbopen,$rcs_1['SPOUSE_CUST_ID']);
        $GUARANTOR_CUST_ID = mysqli_real_escape_string($dbopen,$rcs_1['GUARANTOR_CUST_ID']);
        $IS_PRE_APPROVAL = mysqli_real_escape_string($dbopen,$rcs_1['IS_PRE_APPROVAL']);

        $sql_in = "INSERT INTO cc_ts_penawaran_job SET
                        campaign_id = '0', 
                        AGRMNT_ID = '$AGRMNT_ID', 
                        AGRMNT_NO = '$AGRMNT_NO', 
                        AGRMNT_DT = '$AGRMNT_DT', 
                        PIPELINE_ID = '$PIPELINE_ID', 
                        JOB_ID = '$JOB_ID', 
                        IS_ACTIVE = '$IS_ACTIVE', 
                        DISTRIBUTED_DT = '$DISTRIBUTED_DT', 
                        DISTRIBUTED_USR = '$DISTRIBUTED_USR', 
                        IS_COMPLETE = '$IS_COMPLETE', 
                        COMPLETED_DT = '$COMPLETED_DT', 
                        CAE_FINAL_SCORE = '$CAE_FINAL_SCORE', 
                        CAE_FINAL_RESULT = '$CAE_FINAL_RESULT', 
                        CAE_RESULT = '$CAE_RESULT', 
                        CAE_DT = '$CAE_DT', 
                        DUKCAPIL = '$DUKCAPIL', 
                        DUKCAPIL_RESULT = '$DUKCAPIL_RESULT', 
                        DUKCAPIL_API_DT = '$DUKCAPIL_API_DT', 
                        SCHEME_ID = '$SCHEME_ID', 
                        SLIK_CBASID = '$SLIK_CBASID', 
                        SLIK_RESULT = '$SLIK_RESULT', 
                        SLIK_CATEGORY = '$SLIK_CATEGORY', 
                        SLIK_API_DT = '$SLIK_API_DT', 
                        SOURCE_DATA = '$SOURCE_DATA', 
                        KILAT_PINTAR = '$KILAT_PINTAR', 
                        BUSINESS_DATE = '$BUSINESS_DATE', 
                        OFFICE_REGION_CODE = '$OFFICE_REGION_CODE', 
                        OFFICE_REGION_NAME = '$OFFICE_REGION_NAME', 
                        OFFICE_CODE = '$OFFICE_CODE', 
                        OFFICE_NAME = '$OFFICE_NAME', 
                        CAB_COLL = '$CAB_COLL', 
                        CAB_COLL_NAME = '$CAB_COLL_NAME', 
                        KAPOS_NAME = '$KAPOS_NAME', 
                        PROD_OFFERING_CODE = '$PROD_OFFERING_CODE', 
                        LOB_CODE = '$LOB_CODE', 
                        CUST_TYPE = '$CUST_TYPE', 
                        CUST_NO = '$CUST_NO', 
                        CUST_NAME = '$CUST_NAME', 
                        ID_NO = '$ID_NO', 
                        GENDER = '$GENDER', 
                        RELIGION = '$RELIGION', 
                        BIRTH_PLACE = '$BIRTH_PLACE', 
                        BIRTH_DT = '$BIRTH_DT', 
                        SPOUSE_ID_NO = '$SPOUSE_ID_NO', 
                        SPOUSE_NAME = '$SPOUSE_NAME', 
                        SPOUSE_BIRTH_DT = '$SPOUSE_BIRTH_DT', 
                        ADDR_LEG = '$ADDR_LEG', 
                        RT_LEG = '$RT_LEG', 
                        RW_LEG = '$RW_LEG', 
                        PROVINSI_LEG = '$PROVINSI_LEG', 
                        CITY_LEG = '$CITY_LEG', 
                        KABUPATEN_LEG = '$KABUPATEN_LEG', 
                        KECAMATAN_LEG = '$KECAMATAN_LEG', 
                        KELURAHAN_LEG = '$KELURAHAN_LEG', 
                        ZIPCODE_LEG = '$ZIPCODE_LEG', 
                        SUB_ZIPCODE_LEG = '$SUB_ZIPCODE_LEG', 
                        ADDR_RES = '$ADDR_RES', 
                        RT_RES = '$RT_RES', 
                        RW_RES = '$RW_RES', 
                        PROVINSI_RES = '$PROVINSI_RES', 
                        CITY_RES = '$CITY_RES', 
                        KABUPATEN_RES = '$KABUPATEN_RES', 
                        KECAMATAN_RES = '$KECAMATAN_RES', 
                        KELURAHAN_RES = '$KELURAHAN_RES', 
                        ZIPCODE_RES = '$ZIPCODE_RES', 
                        SUB_ZIPCODE_RES = '$SUB_ZIPCODE_RES', 
                        MOBILE1 = '$MOBILE1', 
                        MOBILE2 = '$MOBILE2', 
                        PHONE1 = '$PHONE1', 
                        PHONE2 = '$PHONE2', 
                        OFFICE_PHONE1 = '$OFFICE_PHONE1', 
                        OFFICE_PHONE2 = '$OFFICE_PHONE2', 
                        PROFESSION_CODE = '$PROFESSION_CODE', 
                        PROFESSION_NAME = '$PROFESSION_NAME', 
                        PROFESSION_CATEGORY_CODE = '$PROFESSION_CATEGORY_CODE', 
                        PROFESSION_CATEGORY_NAME = '$PROFESSION_CATEGORY_NAME', 
                        JOB_POSITION = '$JOB_POSITION', 
                        JOB_STATUS = '$JOB_STATUS', 
                        INDUSTRY_TYPE_NAME = '$INDUSTRY_TYPE_NAME', 
                        OTHER_BIZ_NAME = '$OTHER_BIZ_NAME', 
                        MONTHLY_INCOME = '$MONTHLY_INCOME', 
                        MONTHLY_EXPENSE = '$MONTHLY_EXPENSE', 
                        MONTHLY_INSTALLMENT = '$MONTHLY_INSTALLMENT', 
                        DOWNPAYMENT = '$DOWNPAYMENT', 
                        PERCENT_DP = '$PERCENT_DP', 
                        PLAFOND = '$PLAFOND', 
                        CUST_RATING = '$CUST_RATING', 
                        SUPPL_NAME = '$SUPPL_NAME', 
                        SUPPL_CODE = '$SUPPL_CODE', 
                        MACHINE_NO = '$MACHINE_NO', 
                        CHASSIS_NO = '$CHASSIS_NO', 
                        PRODUCT_CATEGORY = '$PRODUCT_CATEGORY', 
                        ASSET_CATEGORY_CODE = '$ASSET_CATEGORY_CODE', 
                        ASSET_TYPE = '$ASSET_TYPE', 
                        ITEM_BRAND = '$ITEM_BRAND', 
                        ITEM_TYPE = '$ITEM_TYPE', 
                        ITEM_DESCRIPTION = '$ITEM_DESCRIPTION', 
                        ASSET_MODEL = '$ASSET_MODEL', 
                        OTR_PRICE = '$OTR_PRICE', 
                        ITEM_YEAR = '$ITEM_YEAR', 
                        OWNER_RELATIONSHIP = '$OWNER_RELATIONSHIP', 
                        BPKB_OWNERSHIP = '$BPKB_OWNERSHIP', 
                        AGRMNT_RATING = '$AGRMNT_RATING', 
                        CONTRACT_STAT = '$CONTRACT_STAT', 
                        INST_PAYED = '$INST_PAYED', 
                        NEXT_INST_NUM = '$NEXT_INST_NUM', 
                        NEXT_INST_DT = '$NEXT_INST_DT', 
                        OS_TENOR = '$OS_TENOR', 
                        TENOR = '$TENOR', 
                        RELEASE_DATE_BPKB = '$RELEASE_DATE_BPKB', 
                        MATURITY_DT = '$MATURITY_DT', 
                        MATURITY_DURATION = '$MATURITY_DURATION', 
                        GO_LIVE_DT = '$GO_LIVE_DT', 
                        GO_LIVE_DURATION = '$GO_LIVE_DURATION', 
                        AAM_RRD_DT = '$AAM_RRD_DT', 
                        EXPIRED_MONTHS = '$EXPIRED_MONTHS', 
                        OS_PRINCIPAL = '$OS_PRINCIPAL', 
                        OS_PRINCIPAL_AMT = '$OS_PRINCIPAL_AMT', 
                        OS_INTEREST_AMT = '$OS_INTEREST_AMT', 
                        AGING_PEMBIAYAAN = '$AGING_PEMBIAYAAN', 
                        JUMLAH_KONTRAK_PERCUST = '$JUMLAH_KONTRAK_PERCUST', 
                        ESTIMASI_TERIMA_BERSIH = '$ESTIMASI_TERIMA_BERSIH', 
                        STARTED_DT = '$STARTED_DT', 
                        POS_DEALER = '$POS_DEALER', 
                        SALES_DEALER_ID = '$SALES_DEALER_ID', 
                        SALES_DEALER = '$SALES_DEALER', 
                        DTM_CRT = '$DTM_CRT', 
                        USR_CRT = '$USR_CRT', 
                        DTM_UPD = '$DTM_UPD', 
                        USR_UPD = '$USR_UPD', 
                        COLL_AGRMNT_ID = '$COLL_AGRMNT_ID', 
                        AGRMNT_ASSET_ID = '$AGRMNT_ASSET_ID', 
                        ASSET_MASTER_ID = '$ASSET_MASTER_ID', 
                        DEFAULT_STAT = '$DEFAULT_STAT', 
                        CUST_ID = '$CUST_ID', 
                        HOME_STAT = '$HOME_STAT', 
                        MOTHER_NAME = '$MOTHER_NAME', 
                        IS_EVER_REPO = '$IS_EVER_REPO', 
                        IS_REPO = '$IS_REPO', 
                        IS_WRITE_OFF = '$IS_WRITE_OFF', 
                        IS_RESTRUKTUR = '$IS_RESTRUKTUR', 
                        IS_INSURANCE = '$IS_INSURANCE', 
                        IS_NEGATIVE_CUST = '$IS_NEGATIVE_CUST', 
                        IS_ACCOUNT_BAM = '$IS_ACCOUNT_BAM', 
                        CUST_EXPOSURE = '$CUST_EXPOSURE', 
                        AGE = '$AGE', 
                        ASSET_AGE = '$ASSET_AGE', 
                        SAME_ASSET_GO_LIVE = '$SAME_ASSET_GO_LIVE', 
                        LTV = '$LTV', 
                        DSR = '$DSR', 
                        MARITAL_STAT = '$MARITAL_STAT', 
                        EDUCATION = '$EDUCATION', 
                        EMPLOYMENT_ESTABLISHMENT_DT = '$EMPLOYMENT_ESTABLISHMENT_DT', 
                        LENGTH_OF_WORK = '$LENGTH_OF_WORK', 
                        HOUSE_STAY_LENGTH = '$HOUSE_STAY_LENGTH', 
                        LAST_OVERDUE = '$LAST_OVERDUE', 
                        MAX_OVERDUE = '$MAX_OVERDUE', 
                        MAX_OVERDUE_LAST_X_MONTHS = '$MAX_OVERDUE_LAST_X_MONTHS', 
                        IS_USED = '$IS_USED',
                        SPOUSE_BIRTH_PLACE = '$SPOUSE_BIRTH_PLACE',
                        IS_SELECTED = '$IS_SELECTED',
                        PIPELINE_DUMMY_ID = '$PIPELINE_DUMMY_ID',
                        PIPELINE_DUMMY_IS_EARLY_WSC = '$PIPELINE_DUMMY_IS_EARLY_WSC',
                        FINAL_DT = '$FINAL_DT',
                        SPOUSE_PHONE = '$SPOUSE_PHONE',
                        SPOUSE_MOBILE_PHONE_NO = '$SPOUSE_MOBILE_PHONE_NO',
                        GUARANTOR_ID_NO = '$GUARANTOR_ID_NO',
                        GUARANTOR_NAME = '$GUARANTOR_NAME',
                        GUARANTOR_MOBILE_PHONE_NO = '$GUARANTOR_MOBILE_PHONE_NO',
                        GUARANTOR_BIRTH_PLACE = '$GUARANTOR_BIRTH_PLACE',
                        GUARANTOR_BIRTH_DT = '$GUARANTOR_BIRTH_DT',
                        GUARANTOR_ADDR = '$GUARANTOR_ADDR',
                        GUARANTOR_RT = '$GUARANTOR_RT',
                        GUARANTOR_RW = '$GUARANTOR_RW',
                        GUARANTOR_KELURAHAN = '$GUARANTOR_KELURAHAN',
                        GUARANTOR_KECAMATAN = '$GUARANTOR_KECAMATAN',
                        GUARANTOR_CITY = '$GUARANTOR_CITY',
                        GUARANTOR_PROVINSI = '$GUARANTOR_PROVINSI',
                        GUARANTOR_ZIPCODE = '$GUARANTOR_ZIPCODE',
                        GUARANTOR_SUBZIPCODE = '$GUARANTOR_SUBZIPCODE',
                        GUARANTOR_RELATIONSHIP = '$GUARANTOR_RELATIONSHIP',
                        SPOUSE_CUST_ID = '$SPOUSE_CUST_ID',
                        GUARANTOR_CUST_ID = '$GUARANTOR_CUST_ID',
                        is_eligible_crm = '1',
                        is_process = '1', 
                        IS_PRE_APPROVAL = '$IS_PRE_APPROVAL', 
                        SYNC_TIME=now()
                    ON DUPLICATE KEY UPDATE 
                        campaign_id = '0', 
                        AGRMNT_ID = '$AGRMNT_ID', 
                        AGRMNT_NO = '$AGRMNT_NO', 
                        AGRMNT_DT = '$AGRMNT_DT', 
                        PIPELINE_ID = '$PIPELINE_ID', 
                        JOB_ID = '$JOB_ID', 
                        IS_ACTIVE = '$IS_ACTIVE', 
                        DISTRIBUTED_DT = '$DISTRIBUTED_DT', 
                        DISTRIBUTED_USR = '$DISTRIBUTED_USR', 
                        IS_COMPLETE = '$IS_COMPLETE', 
                        COMPLETED_DT = '$COMPLETED_DT', 
                        CAE_FINAL_SCORE = '$CAE_FINAL_SCORE', 
                        CAE_FINAL_RESULT = '$CAE_FINAL_RESULT', 
                        CAE_RESULT = '$CAE_RESULT', 
                        CAE_DT = '$CAE_DT', 
                        DUKCAPIL = '$DUKCAPIL', 
                        DUKCAPIL_RESULT = '$DUKCAPIL_RESULT', 
                        DUKCAPIL_API_DT = '$DUKCAPIL_API_DT', 
                        SCHEME_ID = '$SCHEME_ID', 
                        SLIK_CBASID = '$SLIK_CBASID', 
                        SLIK_RESULT = '$SLIK_RESULT', 
                        SLIK_CATEGORY = '$SLIK_CATEGORY', 
                        SLIK_API_DT = '$SLIK_API_DT', 
                        SOURCE_DATA = '$SOURCE_DATA', 
                        KILAT_PINTAR = '$KILAT_PINTAR', 
                        BUSINESS_DATE = '$BUSINESS_DATE', 
                        OFFICE_REGION_CODE = '$OFFICE_REGION_CODE', 
                        OFFICE_REGION_NAME = '$OFFICE_REGION_NAME', 
                        OFFICE_CODE = '$OFFICE_CODE', 
                        OFFICE_NAME = '$OFFICE_NAME', 
                        CAB_COLL = '$CAB_COLL', 
                        CAB_COLL_NAME = '$CAB_COLL_NAME', 
                        KAPOS_NAME = '$KAPOS_NAME', 
                        PROD_OFFERING_CODE = '$PROD_OFFERING_CODE', 
                        LOB_CODE = '$LOB_CODE', 
                        CUST_TYPE = '$CUST_TYPE', 
                        CUST_NO = '$CUST_NO', 
                        CUST_NAME = '$CUST_NAME', 
                        ID_NO = '$ID_NO', 
                        GENDER = '$GENDER', 
                        RELIGION = '$RELIGION', 
                        BIRTH_PLACE = '$BIRTH_PLACE', 
                        BIRTH_DT = '$BIRTH_DT', 
                        SPOUSE_ID_NO = '$SPOUSE_ID_NO', 
                        SPOUSE_NAME = '$SPOUSE_NAME', 
                        SPOUSE_BIRTH_DT = '$SPOUSE_BIRTH_DT', 
                        ADDR_LEG = '$ADDR_LEG', 
                        RT_LEG = '$RT_LEG', 
                        RW_LEG = '$RW_LEG', 
                        PROVINSI_LEG = '$PROVINSI_LEG', 
                        CITY_LEG = '$CITY_LEG', 
                        KABUPATEN_LEG = '$KABUPATEN_LEG', 
                        KECAMATAN_LEG = '$KECAMATAN_LEG', 
                        KELURAHAN_LEG = '$KELURAHAN_LEG', 
                        ZIPCODE_LEG = '$ZIPCODE_LEG', 
                        SUB_ZIPCODE_LEG = '$SUB_ZIPCODE_LEG', 
                        ADDR_RES = '$ADDR_RES', 
                        RT_RES = '$RT_RES', 
                        RW_RES = '$RW_RES', 
                        PROVINSI_RES = '$PROVINSI_RES', 
                        CITY_RES = '$CITY_RES', 
                        KABUPATEN_RES = '$KABUPATEN_RES', 
                        KECAMATAN_RES = '$KECAMATAN_RES', 
                        KELURAHAN_RES = '$KELURAHAN_RES', 
                        ZIPCODE_RES = '$ZIPCODE_RES', 
                        SUB_ZIPCODE_RES = '$SUB_ZIPCODE_RES', 
                        MOBILE1 = '$MOBILE1', 
                        MOBILE2 = '$MOBILE2', 
                        PHONE1 = '$PHONE1', 
                        PHONE2 = '$PHONE2', 
                        OFFICE_PHONE1 = '$OFFICE_PHONE1', 
                        OFFICE_PHONE2 = '$OFFICE_PHONE2', 
                        PROFESSION_CODE = '$PROFESSION_CODE', 
                        PROFESSION_NAME = '$PROFESSION_NAME', 
                        PROFESSION_CATEGORY_CODE = '$PROFESSION_CATEGORY_CODE', 
                        PROFESSION_CATEGORY_NAME = '$PROFESSION_CATEGORY_NAME', 
                        JOB_POSITION = '$JOB_POSITION', 
                        JOB_STATUS = '$JOB_STATUS', 
                        INDUSTRY_TYPE_NAME = '$INDUSTRY_TYPE_NAME', 
                        OTHER_BIZ_NAME = '$OTHER_BIZ_NAME', 
                        MONTHLY_INCOME = '$MONTHLY_INCOME', 
                        MONTHLY_EXPENSE = '$MONTHLY_EXPENSE', 
                        MONTHLY_INSTALLMENT = '$MONTHLY_INSTALLMENT', 
                        DOWNPAYMENT = '$DOWNPAYMENT', 
                        PERCENT_DP = '$PERCENT_DP', 
                        PLAFOND = '$PLAFOND', 
                        CUST_RATING = '$CUST_RATING', 
                        SUPPL_NAME = '$SUPPL_NAME', 
                        SUPPL_CODE = '$SUPPL_CODE', 
                        MACHINE_NO = '$MACHINE_NO', 
                        CHASSIS_NO = '$CHASSIS_NO', 
                        PRODUCT_CATEGORY = '$PRODUCT_CATEGORY', 
                        ASSET_CATEGORY_CODE = '$ASSET_CATEGORY_CODE', 
                        ASSET_TYPE = '$ASSET_TYPE', 
                        ITEM_BRAND = '$ITEM_BRAND', 
                        ITEM_TYPE = '$ITEM_TYPE', 
                        ITEM_DESCRIPTION = '$ITEM_DESCRIPTION', 
                        ASSET_MODEL = '$ASSET_MODEL', 
                        OTR_PRICE = '$OTR_PRICE', 
                        ITEM_YEAR = '$ITEM_YEAR', 
                        OWNER_RELATIONSHIP = '$OWNER_RELATIONSHIP', 
                        BPKB_OWNERSHIP = '$BPKB_OWNERSHIP', 
                        AGRMNT_RATING = '$AGRMNT_RATING', 
                        CONTRACT_STAT = '$CONTRACT_STAT', 
                        INST_PAYED = '$INST_PAYED', 
                        NEXT_INST_NUM = '$NEXT_INST_NUM', 
                        NEXT_INST_DT = '$NEXT_INST_DT', 
                        OS_TENOR = '$OS_TENOR', 
                        TENOR = '$TENOR', 
                        RELEASE_DATE_BPKB = '$RELEASE_DATE_BPKB', 
                        MATURITY_DT = '$MATURITY_DT', 
                        MATURITY_DURATION = '$MATURITY_DURATION', 
                        GO_LIVE_DT = '$GO_LIVE_DT', 
                        GO_LIVE_DURATION = '$GO_LIVE_DURATION', 
                        AAM_RRD_DT = '$AAM_RRD_DT', 
                        EXPIRED_MONTHS = '$EXPIRED_MONTHS', 
                        OS_PRINCIPAL = '$OS_PRINCIPAL', 
                        OS_PRINCIPAL_AMT = '$OS_PRINCIPAL_AMT', 
                        OS_INTEREST_AMT = '$OS_INTEREST_AMT', 
                        AGING_PEMBIAYAAN = '$AGING_PEMBIAYAAN', 
                        JUMLAH_KONTRAK_PERCUST = '$JUMLAH_KONTRAK_PERCUST', 
                        ESTIMASI_TERIMA_BERSIH = '$ESTIMASI_TERIMA_BERSIH', 
                        STARTED_DT = '$STARTED_DT', 
                        POS_DEALER = '$POS_DEALER', 
                        SALES_DEALER_ID = '$SALES_DEALER_ID', 
                        SALES_DEALER = '$SALES_DEALER', 
                        DTM_CRT = '$DTM_CRT', 
                        USR_CRT = '$USR_CRT', 
                        DTM_UPD = '$DTM_UPD', 
                        USR_UPD = '$USR_UPD', 
                        COLL_AGRMNT_ID = '$COLL_AGRMNT_ID', 
                        AGRMNT_ASSET_ID = '$AGRMNT_ASSET_ID', 
                        ASSET_MASTER_ID = '$ASSET_MASTER_ID', 
                        DEFAULT_STAT = '$DEFAULT_STAT', 
                        CUST_ID = '$CUST_ID', 
                        HOME_STAT = '$HOME_STAT', 
                        MOTHER_NAME = '$MOTHER_NAME', 
                        IS_EVER_REPO = '$IS_EVER_REPO', 
                        IS_REPO = '$IS_REPO', 
                        IS_WRITE_OFF = '$IS_WRITE_OFF', 
                        IS_RESTRUKTUR = '$IS_RESTRUKTUR', 
                        IS_INSURANCE = '$IS_INSURANCE', 
                        IS_NEGATIVE_CUST = '$IS_NEGATIVE_CUST', 
                        IS_ACCOUNT_BAM = '$IS_ACCOUNT_BAM', 
                        CUST_EXPOSURE = '$CUST_EXPOSURE', 
                        AGE = '$AGE', 
                        ASSET_AGE = '$ASSET_AGE', 
                        SAME_ASSET_GO_LIVE = '$SAME_ASSET_GO_LIVE', 
                        LTV = '$LTV', 
                        DSR = '$DSR', 
                        MARITAL_STAT = '$MARITAL_STAT', 
                        EDUCATION = '$EDUCATION', 
                        EMPLOYMENT_ESTABLISHMENT_DT = '$EMPLOYMENT_ESTABLISHMENT_DT', 
                        LENGTH_OF_WORK = '$LENGTH_OF_WORK', 
                        HOUSE_STAY_LENGTH = '$HOUSE_STAY_LENGTH', 
                        LAST_OVERDUE = '$LAST_OVERDUE', 
                        MAX_OVERDUE = '$MAX_OVERDUE', 
                        MAX_OVERDUE_LAST_X_MONTHS = '$MAX_OVERDUE_LAST_X_MONTHS', 
                        IS_USED = '$IS_USED', 
                        SPOUSE_BIRTH_PLACE = '$SPOUSE_BIRTH_PLACE',
                        IS_SELECTED = '$IS_SELECTED',
                        PIPELINE_DUMMY_ID = '$PIPELINE_DUMMY_ID',
                        PIPELINE_DUMMY_IS_EARLY_WSC = '$PIPELINE_DUMMY_IS_EARLY_WSC',
                        FINAL_DT = '$FINAL_DT',
                        SPOUSE_PHONE = '$SPOUSE_PHONE',
                        SPOUSE_MOBILE_PHONE_NO = '$SPOUSE_MOBILE_PHONE_NO',
                        GUARANTOR_ID_NO = '$GUARANTOR_ID_NO',
                        GUARANTOR_NAME = '$GUARANTOR_NAME',
                        GUARANTOR_MOBILE_PHONE_NO = '$GUARANTOR_MOBILE_PHONE_NO',
                        GUARANTOR_BIRTH_PLACE = '$GUARANTOR_BIRTH_PLACE',
                        GUARANTOR_BIRTH_DT = '$GUARANTOR_BIRTH_DT',
                        GUARANTOR_ADDR = '$GUARANTOR_ADDR',
                        GUARANTOR_RT = '$GUARANTOR_RT',
                        GUARANTOR_RW = '$GUARANTOR_RW',
                        GUARANTOR_KELURAHAN = '$GUARANTOR_KELURAHAN',
                        GUARANTOR_KECAMATAN = '$GUARANTOR_KECAMATAN',
                        GUARANTOR_CITY = '$GUARANTOR_CITY',
                        GUARANTOR_PROVINSI = '$GUARANTOR_PROVINSI',
                        GUARANTOR_ZIPCODE = '$GUARANTOR_ZIPCODE',
                        GUARANTOR_SUBZIPCODE = '$GUARANTOR_SUBZIPCODE',
                        GUARANTOR_RELATIONSHIP = '$GUARANTOR_RELATIONSHIP',
                        SPOUSE_CUST_ID = '$SPOUSE_CUST_ID',
                        GUARANTOR_CUST_ID = '$GUARANTOR_CUST_ID',
                        is_eligible_crm = '1',
                        is_process = '1', 
                        IS_PRE_APPROVAL = '$IS_PRE_APPROVAL', 
                        SYNC_TIME=now()";
        if($resin =  mysqli_query($dbopen,$sql_in)){
            $idcus = mysqli_insert_id($dbopen);

            $suc1++;
        }else{
            $err1++;
            if ($err_agrmn1=="") {
                $err_agrmn1="$AGRMNT_NO";
                $err_desc = mysqli_error($dbopen).";";
            }else{
                $err_agrmn1 .=", $AGRMNT_NO";
                $err_desc .= "</br>".mysqli_error($dbopen).";";
            }
            
        }

    }




    //log 
    $err_desc = mysqli_real_escape_string($dbopen,$err_desc);
    $sqllog = "INSERT INTO cc_log_sync_data SET 
                  sync_desc       ='T_MKT_POLO_ELIGIBLE',
                  sync_success    ='$suc1',
                  sync_error      ='$err1',
                  sync_error_agrmnt_no ='$err_agrmn1',
                  sync_error_desc ='$err_desc',
                  exe_time        = '$dateexe',
                  sync_time       =now()";
    mysqli_query($dbopen,$sqllog);

//campaign 
$suc2=0;
$err2=0;
$puteran=0;
$sqlcg = "SELECT 
          a.*
          FROM 
          cc_ts_penawaran_campaign a 
          WHERE a.campaign_priority > 0 AND status=1 
          AND POSITION('WISE' IN a.data_source) > 0
          ORDER BY a.campaign_priority ASC ";
$rescg = mysqli_query($dbopen,$sqlcg);
while($reccg = mysqli_fetch_array($rescg)){
    $idcc                               = $reccg['id'];//echo "string $idcc || $sqlcg";
    $data_source                        = $reccg['data_source'];
    $type_asset                       = $reccg['type_asset'];
    $pipeline                         = $reccg['pipeline'];
    $level                            = $reccg['level'];
    $branch                           = $reccg['branch'];
    $branch_code                           = $reccg['branch_code'];
    $regional                         = $reccg['regional'];
    $kendaraan                        = $reccg['kendaraan'];
    $product                          = $reccg['product'];
    $priority_sisa_tenor                             = $reccg['priority_sisa_tenor'];
    $priority_sisa_tenor_from                             = $reccg['priority_sisa_tenor_from'];
    $priority_sisa_tenor_to                             = $reccg['priority_sisa_tenor_to'];
    $status_konsumen                             = $reccg['status_konsumen'];
    $status_kontrak                             = $reccg['status_kontrak'];
    $kepemilikan_rumah                             = $reccg['kepemilikan_rumah'];
    $kepemilikan_bpkb                             = $reccg['kepemilikan_bpkb'];
    $distribution_spv                             = $reccg['distribution_spv'];
    $aging_pembiayaan                             = $reccg['aging_pembiayaan'];
    $aging_pembiayaan_from                             = $reccg['aging_pembiayaan_from'];
    $aging_pembiayaan_to                             = $reccg['aging_pembiayaan_to'];
    $cust_age                             = $reccg['cust_age'];
    $cust_age_from                             = $reccg['cust_age_from'];
    $cust_age_to                             = $reccg['cust_age_to'];
    $cust_birthday_month                             = $reccg['cust_birthday_month'];
    $cust_birthday_month_from                             = $reccg['cust_birthday_month_from'];
    $cust_birthday_month_to                             = $reccg['cust_birthday_month_to'];
    $cust_rating                             = $reccg['cust_rating'];
    $gender                             = $reccg['gender'];
    $industry_type                             = $reccg['industry_type'];
    $item_year                             = $reccg['item_year'];
    $item_year_from                             = $reccg['item_year_from'];
    $item_year_to                             = $reccg['item_year_to'];
    $jenis_kendaraan                             = $reccg['jenis_kendaraan'];
    $max_past_due                             = $reccg['max_past_due'];
    $max_past_due_from                             = $reccg['max_past_due_from'];
    $max_past_due_to                             = $reccg['max_past_due_to'];
    $cust_monthly_income                             = $reccg['cust_monthly_income'];
    $cust_monthly_income_from                             = $reccg['cust_monthly_income_from'];
    $cust_monthly_income_to                             = $reccg['cust_monthly_income_to'];
    $otr                             = $reccg['otr'];
    $otr_from                             = $reccg['otr_from'];
    $otr_to                             = $reccg['otr_to'];
    $profession                             = $reccg['profession'];
    $religion                             = $reccg['religion'];
    $flag_potensi                             = $reccg['flag_potensi'];

    $puteran++;
    //log 
    $sqllog = "INSERT INTO cc_log_service_get SET 
                  campaign_id       ='$idcc',
                  `desc`            ='puteran campaign',
                  insert_time       =now()";
    mysqli_query($dbopen,$sqllog);
    
    $sql_whr="";
    if ($data_source!="" && $data_source!="0") {
        $data_source = str_replace(",", "','", $data_source);
        $data_source = str_replace("(POTENSIAL DATA RO)", "", $data_source); 
        $sql_whr .=" AND SOURCE_DATA IN ('$data_source')";
    }
    if ($type_asset!="" && $type_asset!="0") {
        $type_asset = str_replace(",", "','", $type_asset);
        $sql_whr .=" AND ASSET_TYPE IN ('$type_asset')";
    }
    if ($pipeline!="" && $pipeline!="0") {
        $pipeline = str_replace(",", "','", $pipeline);
        $sql_whr .=" AND PIPELINE_ID IN ('$pipeline')";
    }
    if ($level!="" && $level!="0") {
        $level = str_replace(",", "','", $level);
        // $sql_whr .=" AND *** IN ('$level')";
    }
    if ($branch_code!="" && $branch_code!="0") {
        $branch_code = str_replace(",", "','", $branch_code);
        $sql_whr .=" AND OFFICE_CODE IN ('$branch_code')";
    }
    if ($regional!="" && $regional!="0") {
        $regional = str_replace(",", "','", $regional);
        $sql_whr .=" AND OFFICE_REGION_CODE IN ('$regional')";
    }
    if ($kendaraan!="" && $kendaraan!="0") {
        $kendaraan = str_replace(",", "','", $kendaraan);
        // $sql_whr .=" AND *** IN ('$kendaraan')";
    }
    if ($product!="" && $product!="0") {
        $product = str_replace(",", "','", $product);
        $sql_whr .=" AND LOB_CODE IN ('$product')";
    }
    if ($priority_sisa_tenor_from!="") {// && $priority_sisa_tenor_from!="0"
        // $data_source = str_replace(",", "','", $data_source);
        // $sql_whr .=" AND OS_TENOR >= '$priority_sisa_tenor_from'";
        // $sql_whr .=" AND MATURITY_DURATION >= CAST('".$priority_sisa_tenor_from."' as DECIMAL(65))";
        $sql_whr .=" AND OS_TENOR >= CAST('".$priority_sisa_tenor_from."' as DECIMAL(65))";
    }
    if ($priority_sisa_tenor_to!="") {// && $priority_sisa_tenor_to!="0"
        // $data_source = str_replace(",", "','", $data_source);
        $sql_whr .=" AND OS_TENOR <= CAST('".$priority_sisa_tenor_to."' as DECIMAL(65))";
    }
    if ($status_kontrak!="" && $status_kontrak!="0") {
        $status_kontrak = str_replace(",", "','", $status_kontrak);
        $sql_whr .=" AND CONTRACT_STAT IN ('$status_kontrak')";
    }
    if ($kepemilikan_rumah!="" && $kepemilikan_rumah!="0") {
        $kepemilikan_rumah = str_replace(",", "','", $kepemilikan_rumah);
        $sqlch = "SELECT 
          a.*
          FROM 
          cc_master_house_ownership a 
          WHERE a.descr IN ('$kepemilikan_rumah')";
        $resch = mysqli_query($dbopen,$sqlch);
        while($recch = mysqli_fetch_array($resch)){
            $master_code = $recch['master_code'];
            $descr = $recch['descr'];
            $kepemilikan_rumah = str_replace("$descr", "$master_code", $kepemilikan_rumah);
        }
        $sql_whr .=" AND HOME_STAT IN ('$kepemilikan_rumah')";
    }
    if ($kepemilikan_bpkb!="" && $kepemilikan_bpkb!="0") {
        $kepemilikan_bpkb = str_replace(",", "','", $kepemilikan_bpkb);
        $sql_whr .=" AND BPKB_OWNERSHIP IN ('$kepemilikan_bpkb')";
    }
    if ($distribution_spv!="" && $distribution_spv!="0") {
        $distribution_spv = str_replace(",", "','", $distribution_spv);
        // $sql_whr .=" AND *** IN ('$distribution_spv')";
    }
    if ($aging_pembiayaan_from!="") {//&& $aging_pembiayaan_from!="0"
        // $data_source = str_replace(",", "','", $data_source);
        // $aging_pembiayaan_from = str_replace("-", "", $aging_pembiayaan_from);
        // $sql_whr .=" AND OS_TENOR <= CAST('".$aging_pembiayaan_from."' as DECIMAL(65))";
        $sql_whr .=" AND MATURITY_DURATION >= CAST('".$aging_pembiayaan_from."' as DECIMAL(65))";
    }
    if ($aging_pembiayaan_to!="") {// && $aging_pembiayaan_to!="0"
        // $data_source = str_replace(",", "','", $data_source);
        $sql_whr .=" AND MATURITY_DURATION <= CAST('".$aging_pembiayaan_to."' as DECIMAL(65))";
    }
    if ($cust_age_from!="" && $cust_age_from!="0") {
        // $data_source = str_replace(",", "','", $data_source);
        $sql_whr .=" AND AGE >= CAST('".$cust_age_from."' as DECIMAL(65))";
    }
    if ($cust_age_to!="" && $cust_age_to!="0") {
        // $data_source = str_replace(",", "','", $data_source);
        $sql_whr .=" AND AGE <= CAST('".$cust_age_to."' as DECIMAL(65))";
    }
    if ($cust_birthday_month_from!="" && $cust_birthday_month_from!="0") {
        // $data_source = str_replace(",", "','", $data_source);
        $sql_whr .=" AND MONTH(BIRTH_DT) >= '$cust_birthday_month_from'";
    }
    if ($cust_birthday_month_to!="" && $cust_birthday_month_to!="0") {
        // $data_source = str_replace(",", "','", $data_source);
        $sql_whr .=" AND MONTH(BIRTH_DT) <= '$cust_birthday_month_to'";
    }
    // if ($cust_rating!="" && $cust_rating!="0") {
    //     $cust_rating = str_replace(",", "','", $cust_rating);
    //     $sql_whr .=" AND CUST_RATING IN ('$cust_rating')";
    // }
    // if ($gender!="" && $gender!="0") {
    //     $gender = str_replace(",", "','", $gender);
    //     $sql_whr .=" AND GENDER IN ('$gender')";
    // }
    
    if ($cust_rating!="" && $cust_rating!="0") {
        $cust_rating = str_replace(",", "','", $cust_rating);
        $cust_rating = str_replace("1", "EXCELLENT", $cust_rating);
        $cust_rating = str_replace("2", "GOOD", $cust_rating);
        $cust_rating = str_replace("3", "NORMAL", $cust_rating);
        $sql_whr .=" AND CUST_RATING IN ('$cust_rating')";
    }
    if ($gender!="" && $gender!="0") {
        $gender = str_replace(",", "','", $gender);
        $gender = str_replace("1", "Laki - laki','LAKI-LAKI','M','MALE", $gender);
        $gender = str_replace("2", "F','Female','PEREMPUAN", $gender);
        $gender = str_replace("''", "'", $gender);
        $sql_whr .=" AND GENDER IN ('$gender')";
    }
    if ($industry_type!="" && $industry_type!="0") {
        $industry_type = str_replace(",", "','", $industry_type);
        $sql_whr .=" AND INDUSTRY_TYPE_NAME IN ('$industry_type')";
    }
    if ($jenis_kendaraan!="" && $jenis_kendaraan!="0") {
        $jenis_kendaraan = str_replace(",", "','", $jenis_kendaraan);
        // $sql_whr .=" AND item_description IN ('$jenis_kendaraan')";
    }
    if ($item_year_from!="" && $item_year_from!="0") {
        // $data_source = str_replace(",", "','", $data_source);
        $sql_whr .=" AND ITEM_YEAR >= '$item_year_from'";
    }
    if ($item_year_to!="" && $item_year_to!="0") {
        // $data_source = str_replace(",", "','", $data_source);
        $sql_whr .=" AND ITEM_YEAR <= '$item_year_to'";
    }
    if ($max_past_due_from!="" && $max_past_due_from!="0") {
        // $data_source = str_replace(",", "','", $data_source);
        $sql_whr .=" AND MAX_OVERDUE >= CAST('".$max_past_due_from."' as DECIMAL(65))";
    }
    if ($max_past_due_to!="" && $max_past_due_to!="0") {
        // $data_source = str_replace(",", "','", $data_source);
        $sql_whr .=" AND MAX_OVERDUE <= CAST('".$max_past_due_to."' as DECIMAL(65))";
    }
    if ($cust_monthly_income_from!="" && $cust_monthly_income_from!="0") {
        // $data_source = str_replace(",", "','", $data_source);
        $cust_monthly_income_from = str_replace(".", "", $cust_monthly_income_from);
        $sql_whr .=" AND MONTHLY_INCOME >= '$cust_monthly_income_from'";
    }
    if ($cust_monthly_income_to!="" && $cust_monthly_income_to!="0") {
        // $data_source = str_replace(",", "','", $data_source);
        $cust_monthly_income_to = str_replace(".", "", $cust_monthly_income_to);
        $sql_whr .=" AND MONTHLY_INCOME <= '$cust_monthly_income_to'";
    }
    if ($otr_from!="" && $otr_from!="0") {
        // $data_source = str_replace(",", "','", $data_source);
        $otr_from = str_replace(".", "", $otr_from);
        $sql_whr .=" AND OTR_PRICE >= '$otr_from'";
    }
    if ($otr_to!="" && $otr_to!="0") {
        // $data_source = str_replace(",", "','", $data_source);
        $otr_to = str_replace(".", "", $otr_to);
        $sql_whr .=" AND OTR_PRICE <= '$otr_to'";
    }
    if ($religion!="" && $religion!="0") {
        $religion = str_replace(",", "','", $religion);
        $sql_whr .=" AND RELIGION IN ('$religion')";
    }
    if ($profession!=""&&$profession!="0") {
        $profession = str_replace(",", "','", $profession);
        $sql_whr .=" AND PROFESSION_CODE IN ('$profession')";
    }

    //start customer detail
    $suc3=0;
    $err3=0;
    $sqlcektoday = "SELECT 
                a.*
              FROM 
                cc_ts_penawaran_job a 
              WHERE campaign_id='0' $sql_whr ";//echo "$idcc || string $sqlcektoday </br></br>";
              if ($idcc==5) {
                  // echo "$idcc || string $sqlcektoday </br></br>";
              }
    $rescektoday = mysqli_query($dbopen,$sqlcektoday);
    if($reccektoday = mysqli_fetch_array($rescektoday)){
        $id_today_upd  = $reccektoday['id']; 

        //log 
        $sqllog = "INSERT INTO cc_log_service_get SET 
                      campaign_id       ='$idcc',
                      `desc`            ='puteran consumer_detail',
                      insert_time       =now()";
        mysqli_query($dbopen,$sqllog);

        $sqlupdt = "";
        // if ($spv_id > 0) {
        //     $sqlupdt ="assign_to       ='$spv_id',
        //                assign_time     =now(),";
        // }

        $sqltodayupdt = "UPDATE cc_ts_penawaran_job
                         SET $sqlupdt campaign_id = '$idcc'
                         WHERE campaign_id='0' $sql_whr ";//echo "string $sqltodayupdt </br>---------------------------------------</br>";
        // $restodayupdt = mysqli_query($dbopen,$sqltodayupdt); 
        if($restodayupdt =  mysqli_query($dbopen,$sqltodayupdt)){ 
           $suc2++;
        }else{
           $err2++;
        }

    }
    mysqli_free_result($rescektoday);
    //end customer detail

}

            //REPLACE
            // $sqlall = "REPLACE INTO cc_ts_penawaran (AGRMNT_ID,campaign_id, agrmnt_no,pipeline,distributed_date,final_result_cae,dukcapil_result,source_data,kilat_pintar,region_code,region_name,
            //                        cabang_code,cabang_name,cabang_coll,cabang_coll_name,kapos_name,product_offering_code,lob,customer_id_ro,customer_name,nik_ktp,gender,religion,tempat_lahir,tanggal_lahir,
            //                        spouse_nik,spouse_name,spouse_birth_date,legal_alamat,legal_rt,legal_rw,legal_provinsi,legal_city,legal_kabupaten,legal_kecamatan,legal_kelurahan,legal_kodepos,
            //                        legal_sub_kodepos,survey_alamat,survey_rt,survey_rw,survey_provinsi,survey_city,survey_kabupaten,survey_kecamatan,survey_kelurahan,survey_kodepos,survey_sub_kodepos,
            //                        mobile_1,mobile_2,phone_1,phone_2,office_phone_1,office_phone_2,profession_code,profession_name,profession_category_code,profession_cat_name,job_position,
            //                        industry_type_name,other_biz_name,monthly_income,monthly_expense,monthly_instalment,dp,dp_pct,plafond,customer_rating,suppl_name,suppl_code,no_mesin,no_rangka,
            //                        product_category,asset_category,asset_type,brand,item_type,item_desc,otr_price,item_year,ownership,kepemilikan_bpkb,agrmnt_rating,status_kontrak,sisa_tenor,tenor,
            //                        release_date_bpkb,maturity_date,go_live_dt,rrd_date,os_principal,os_installment_amt,aging_pembiayaan,jumlah_kontrak_per_cust,estimasi_terima_bersih,started_date,
            //                        pos_dealer,sales_dealer_id,sales_dealer,dtm_crt,usr_crt,dtm_upd,usr_upd,customer_id,kepemilikan_rumah,nama_ibu_kandung,is_repo,is_write_off,is_restructure,
            //                        is_insurance,is_negative,exposure,ltv,dsr,marital_status,education,length_of_work,house_stay_length,
            //                        created_by, modif_by, insert_time, modif_time)
            //             SELECT AGRMNT_ID,campaign_id, AGRMNT_NO, PIPELINE_ID, DISTRIBUTED_DT, CAE_FINAL_RESULT, DUKCAPIL_RESULT, SOURCE_DATA, KILAT_PINTAR, OFFICE_REGION_CODE, OFFICE_REGION_NAME, OFFICE_CODE, OFFICE_NAME, CAB_COLL, CAB_COLL_NAME, KAPOS_NAME, PROD_OFFERING_CODE, LOB_CODE, CUST_NO, CUST_NAME, ID_NO, GENDER, RELIGION, BIRTH_PLACE, BIRTH_DT, SPOUSE_ID_NO, SPOUSE_NAME, SPOUSE_BIRTH_DT, ADDR_LEG, RT_LEG, RW_LEG, PROVINSI_LEG, CITY_LEG, KABUPATEN_LEG, KECAMATAN_LEG, KELURAHAN_LEG, ZIPCODE_LEG, SUB_ZIPCODE_LEG, ADDR_RES, RT_RES, RW_RES, PROVINSI_RES, CITY_RES, KABUPATEN_RES, KECAMATAN_RES, KELURAHAN_RES, ZIPCODE_RES, SUB_ZIPCODE_RES, MOBILE1, MOBILE2, PHONE1, PHONE2, OFFICE_PHONE1, OFFICE_PHONE2, PROFESSION_CODE, PROFESSION_NAME, PROFESSION_CATEGORY_CODE, PROFESSION_CATEGORY_NAME, JOB_POSITION, INDUSTRY_TYPE_NAME, OTHER_BIZ_NAME, MONTHLY_INCOME, MONTHLY_EXPENSE, MONTHLY_INSTALLMENT, DOWNPAYMENT, PERCENT_DP, PLAFOND, CUST_RATING, SUPPL_NAME, SUPPL_CODE, MACHINE_NO, CHASSIS_NO, PRODUCT_CATEGORY, ASSET_CATEGORY_CODE, ASSET_TYPE, ITEM_BRAND, ITEM_TYPE, ITEM_DESCRIPTION, OTR_PRICE, ITEM_YEAR, OWNER_RELATIONSHIP, BPKB_OWNERSHIP, AGRMNT_RATING, CONTRACT_STAT, OS_TENOR, TENOR, RELEASE_DATE_BPKB, MATURITY_DT, GO_LIVE_DT, AAM_RRD_DT, OS_PRINCIPAL, OS_INTEREST_AMT, AGING_PEMBIAYAAN, JUMLAH_KONTRAK_PERCUST, ESTIMASI_TERIMA_BERSIH, STARTED_DT, POS_DEALER, SALES_DEALER_ID, SALES_DEALER, DTM_CRT, USR_CRT, DTM_UPD, USR_UPD, CUST_ID, HOME_STAT, MOTHER_NAME, IS_REPO, IS_WRITE_OFF, IS_RESTRUKTUR, IS_INSURANCE, IS_NEGATIVE_CUST, CUST_EXPOSURE, LTV, DSR, MARITAL_STAT, EDUCATION, LENGTH_OF_WORK, HOUSE_STAY_LENGTH,'1','1',now(),now() FROM cc_ts_penawaran_job
            //             WHERE campaign_id!='0' ";
            // mysqli_query($dbopen,$sqlall);


    $sqljob = "SELECT * FROM cc_ts_penawaran_job
              WHERE campaign_id='0' AND SOURCE_DATA = 'WISE'";//task_id='$taskId'
    $resjob = mysqli_query($dbopen,$sqljob);
    while($recjob = mysqli_fetch_array($resjob)){
        @extract($recjob,EXTR_OVERWRITE);

        $sql_in2 = "INSERT INTO cc_ts_penawaran_job_temp SET
                        campaign_id = '0', 
                        AGRMNT_ID = '$AGRMNT_ID', 
                        AGRMNT_NO = '$AGRMNT_NO', 
                        AGRMNT_DT = '$AGRMNT_DT', 
                        PIPELINE_ID = '$PIPELINE_ID', 
                        JOB_ID = '$JOB_ID', 
                        IS_ACTIVE = '$IS_ACTIVE', 
                        DISTRIBUTED_DT = '$DISTRIBUTED_DT', 
                        DISTRIBUTED_USR = '$DISTRIBUTED_USR', 
                        IS_COMPLETE = '$IS_COMPLETE', 
                        COMPLETED_DT = '$COMPLETED_DT', 
                        CAE_FINAL_SCORE = '$CAE_FINAL_SCORE', 
                        CAE_FINAL_RESULT = '$CAE_FINAL_RESULT', 
                        CAE_RESULT = '$CAE_RESULT', 
                        CAE_DT = '$CAE_DT', 
                        DUKCAPIL = '$DUKCAPIL', 
                        DUKCAPIL_RESULT = '$DUKCAPIL_RESULT', 
                        DUKCAPIL_API_DT = '$DUKCAPIL_API_DT', 
                        SCHEME_ID = '$SCHEME_ID', 
                        SLIK_CBASID = '$SLIK_CBASID', 
                        SLIK_RESULT = '$SLIK_RESULT', 
                        SLIK_CATEGORY = '$SLIK_CATEGORY', 
                        SLIK_API_DT = '$SLIK_API_DT', 
                        SOURCE_DATA = '$SOURCE_DATA', 
                        KILAT_PINTAR = '$KILAT_PINTAR', 
                        BUSINESS_DATE = '$BUSINESS_DATE', 
                        OFFICE_REGION_CODE = '$OFFICE_REGION_CODE', 
                        OFFICE_REGION_NAME = '$OFFICE_REGION_NAME', 
                        OFFICE_CODE = '$OFFICE_CODE', 
                        OFFICE_NAME = '$OFFICE_NAME', 
                        CAB_COLL = '$CAB_COLL', 
                        CAB_COLL_NAME = '$CAB_COLL_NAME', 
                        KAPOS_NAME = '$KAPOS_NAME', 
                        PROD_OFFERING_CODE = '$PROD_OFFERING_CODE', 
                        LOB_CODE = '$LOB_CODE', 
                        CUST_TYPE = '$CUST_TYPE', 
                        CUST_NO = '$CUST_NO', 
                        CUST_NAME = '$CUST_NAME', 
                        ID_NO = '$ID_NO', 
                        GENDER = '$GENDER', 
                        RELIGION = '$RELIGION', 
                        BIRTH_PLACE = '$BIRTH_PLACE', 
                        BIRTH_DT = '$BIRTH_DT', 
                        SPOUSE_ID_NO = '$SPOUSE_ID_NO', 
                        SPOUSE_NAME = '$SPOUSE_NAME', 
                        SPOUSE_BIRTH_DT = '$SPOUSE_BIRTH_DT', 
                        ADDR_LEG = '$ADDR_LEG', 
                        RT_LEG = '$RT_LEG', 
                        RW_LEG = '$RW_LEG', 
                        PROVINSI_LEG = '$PROVINSI_LEG', 
                        CITY_LEG = '$CITY_LEG', 
                        KABUPATEN_LEG = '$KABUPATEN_LEG', 
                        KECAMATAN_LEG = '$KECAMATAN_LEG', 
                        KELURAHAN_LEG = '$KELURAHAN_LEG', 
                        ZIPCODE_LEG = '$ZIPCODE_LEG', 
                        SUB_ZIPCODE_LEG = '$SUB_ZIPCODE_LEG', 
                        ADDR_RES = '$ADDR_RES', 
                        RT_RES = '$RT_RES', 
                        RW_RES = '$RW_RES', 
                        PROVINSI_RES = '$PROVINSI_RES', 
                        CITY_RES = '$CITY_RES', 
                        KABUPATEN_RES = '$KABUPATEN_RES', 
                        KECAMATAN_RES = '$KECAMATAN_RES', 
                        KELURAHAN_RES = '$KELURAHAN_RES', 
                        ZIPCODE_RES = '$ZIPCODE_RES', 
                        SUB_ZIPCODE_RES = '$SUB_ZIPCODE_RES', 
                        MOBILE1 = '$MOBILE1', 
                        MOBILE2 = '$MOBILE2', 
                        PHONE1 = '$PHONE1', 
                        PHONE2 = '$PHONE2', 
                        OFFICE_PHONE1 = '$OFFICE_PHONE1', 
                        OFFICE_PHONE2 = '$OFFICE_PHONE2', 
                        PROFESSION_CODE = '$PROFESSION_CODE', 
                        PROFESSION_NAME = '$PROFESSION_NAME', 
                        PROFESSION_CATEGORY_CODE = '$PROFESSION_CATEGORY_CODE', 
                        PROFESSION_CATEGORY_NAME = '$PROFESSION_CATEGORY_NAME', 
                        JOB_POSITION = '$JOB_POSITION', 
                        JOB_STATUS = '$JOB_STATUS', 
                        INDUSTRY_TYPE_NAME = '$INDUSTRY_TYPE_NAME', 
                        OTHER_BIZ_NAME = '$OTHER_BIZ_NAME', 
                        MONTHLY_INCOME = '$MONTHLY_INCOME', 
                        MONTHLY_EXPENSE = '$MONTHLY_EXPENSE', 
                        MONTHLY_INSTALLMENT = '$MONTHLY_INSTALLMENT', 
                        DOWNPAYMENT = '$DOWNPAYMENT', 
                        PERCENT_DP = '$PERCENT_DP', 
                        PLAFOND = '$PLAFOND', 
                        CUST_RATING = '$CUST_RATING', 
                        SUPPL_NAME = '$SUPPL_NAME', 
                        SUPPL_CODE = '$SUPPL_CODE', 
                        MACHINE_NO = '$MACHINE_NO', 
                        CHASSIS_NO = '$CHASSIS_NO', 
                        PRODUCT_CATEGORY = '$PRODUCT_CATEGORY', 
                        ASSET_CATEGORY_CODE = '$ASSET_CATEGORY_CODE', 
                        ASSET_TYPE = '$ASSET_TYPE', 
                        ITEM_BRAND = '$ITEM_BRAND', 
                        ITEM_TYPE = '$ITEM_TYPE', 
                        ITEM_DESCRIPTION = '$ITEM_DESCRIPTION', 
                        ASSET_MODEL = '$ASSET_MODEL', 
                        OTR_PRICE = '$OTR_PRICE', 
                        ITEM_YEAR = '$ITEM_YEAR', 
                        OWNER_RELATIONSHIP = '$OWNER_RELATIONSHIP', 
                        BPKB_OWNERSHIP = '$BPKB_OWNERSHIP', 
                        AGRMNT_RATING = '$AGRMNT_RATING', 
                        CONTRACT_STAT = '$CONTRACT_STAT', 
                        INST_PAYED = '$INST_PAYED', 
                        NEXT_INST_NUM = '$NEXT_INST_NUM', 
                        NEXT_INST_DT = '$NEXT_INST_DT', 
                        OS_TENOR = '$OS_TENOR', 
                        TENOR = '$TENOR', 
                        RELEASE_DATE_BPKB = '$RELEASE_DATE_BPKB', 
                        MATURITY_DT = '$MATURITY_DT', 
                        MATURITY_DURATION = '$MATURITY_DURATION', 
                        GO_LIVE_DT = '$GO_LIVE_DT', 
                        GO_LIVE_DURATION = '$GO_LIVE_DURATION', 
                        AAM_RRD_DT = '$AAM_RRD_DT', 
                        EXPIRED_MONTHS = '$EXPIRED_MONTHS', 
                        OS_PRINCIPAL = '$OS_PRINCIPAL', 
                        OS_PRINCIPAL_AMT = '$OS_PRINCIPAL_AMT', 
                        OS_INTEREST_AMT = '$OS_INTEREST_AMT', 
                        AGING_PEMBIAYAAN = '$AGING_PEMBIAYAAN', 
                        JUMLAH_KONTRAK_PERCUST = '$JUMLAH_KONTRAK_PERCUST', 
                        ESTIMASI_TERIMA_BERSIH = '$ESTIMASI_TERIMA_BERSIH', 
                        STARTED_DT = '$STARTED_DT', 
                        POS_DEALER = '$POS_DEALER', 
                        SALES_DEALER_ID = '$SALES_DEALER_ID', 
                        SALES_DEALER = '$SALES_DEALER', 
                        DTM_CRT = '$DTM_CRT', 
                        USR_CRT = '$USR_CRT', 
                        DTM_UPD = '$DTM_UPD', 
                        USR_UPD = '$USR_UPD', 
                        COLL_AGRMNT_ID = '$COLL_AGRMNT_ID', 
                        AGRMNT_ASSET_ID = '$AGRMNT_ASSET_ID', 
                        ASSET_MASTER_ID = '$ASSET_MASTER_ID', 
                        DEFAULT_STAT = '$DEFAULT_STAT', 
                        CUST_ID = '$CUST_ID', 
                        HOME_STAT = '$HOME_STAT', 
                        MOTHER_NAME = '$MOTHER_NAME', 
                        IS_EVER_REPO = '$IS_EVER_REPO', 
                        IS_REPO = '$IS_REPO', 
                        IS_WRITE_OFF = '$IS_WRITE_OFF', 
                        IS_RESTRUKTUR = '$IS_RESTRUKTUR', 
                        IS_INSURANCE = '$IS_INSURANCE', 
                        IS_NEGATIVE_CUST = '$IS_NEGATIVE_CUST', 
                        IS_ACCOUNT_BAM = '$IS_ACCOUNT_BAM', 
                        CUST_EXPOSURE = '$CUST_EXPOSURE', 
                        AGE = '$AGE', 
                        ASSET_AGE = '$ASSET_AGE', 
                        SAME_ASSET_GO_LIVE = '$SAME_ASSET_GO_LIVE', 
                        LTV = '$LTV', 
                        DSR = '$DSR', 
                        MARITAL_STAT = '$MARITAL_STAT', 
                        EDUCATION = '$EDUCATION', 
                        EMPLOYMENT_ESTABLISHMENT_DT = '$EMPLOYMENT_ESTABLISHMENT_DT', 
                        LENGTH_OF_WORK = '$LENGTH_OF_WORK', 
                        HOUSE_STAY_LENGTH = '$HOUSE_STAY_LENGTH', 
                        LAST_OVERDUE = '$LAST_OVERDUE', 
                        MAX_OVERDUE = '$MAX_OVERDUE', 
                        MAX_OVERDUE_LAST_X_MONTHS = '$MAX_OVERDUE_LAST_X_MONTHS', 
                        IS_USED = '$IS_USED',
                        SPOUSE_BIRTH_PLACE = '$SPOUSE_BIRTH_PLACE',
                        IS_SELECTED = '$IS_SELECTED',
                        PIPELINE_DUMMY_ID = '$PIPELINE_DUMMY_ID',
                        PIPELINE_DUMMY_IS_EARLY_WSC = '$PIPELINE_DUMMY_IS_EARLY_WSC',
                        FINAL_DT = '$FINAL_DT',
                        SPOUSE_PHONE = '$SPOUSE_PHONE',
                        SPOUSE_MOBILE_PHONE_NO = '$SPOUSE_MOBILE_PHONE_NO',
                        GUARANTOR_ID_NO = '$GUARANTOR_ID_NO',
                        GUARANTOR_NAME = '$GUARANTOR_NAME',
                        GUARANTOR_MOBILE_PHONE_NO = '$GUARANTOR_MOBILE_PHONE_NO',
                        GUARANTOR_BIRTH_PLACE = '$GUARANTOR_BIRTH_PLACE',
                        GUARANTOR_BIRTH_DT = '$GUARANTOR_BIRTH_DT',
                        GUARANTOR_ADDR = '$GUARANTOR_ADDR',
                        GUARANTOR_RT = '$GUARANTOR_RT',
                        GUARANTOR_RW = '$GUARANTOR_RW',
                        GUARANTOR_KELURAHAN = '$GUARANTOR_KELURAHAN',
                        GUARANTOR_KECAMATAN = '$GUARANTOR_KECAMATAN',
                        GUARANTOR_CITY = '$GUARANTOR_CITY',
                        GUARANTOR_PROVINSI = '$GUARANTOR_PROVINSI',
                        GUARANTOR_ZIPCODE = '$GUARANTOR_ZIPCODE',
                        GUARANTOR_SUBZIPCODE = '$GUARANTOR_SUBZIPCODE',
                        GUARANTOR_RELATIONSHIP = '$GUARANTOR_RELATIONSHIP',
                        SPOUSE_CUST_ID = '$SPOUSE_CUST_ID',
                        GUARANTOR_CUST_ID = '$GUARANTOR_CUST_ID',
                        opsi_penanganan = '$opsi_penanganan',
                        IS_PRE_APPROVAL = '$IS_PRE_APPROVAL',
                        is_eligible_crm = '1',
                        is_process = '1',
                        is_assign  = '0', 
                        SYNC_TIME=now()
                    ON DUPLICATE KEY UPDATE 
                        campaign_id = '0', 
                        AGRMNT_ID = '$AGRMNT_ID', 
                        AGRMNT_NO = '$AGRMNT_NO', 
                        AGRMNT_DT = '$AGRMNT_DT', 
                        PIPELINE_ID = '$PIPELINE_ID', 
                        JOB_ID = '$JOB_ID', 
                        IS_ACTIVE = '$IS_ACTIVE', 
                        DISTRIBUTED_DT = '$DISTRIBUTED_DT', 
                        DISTRIBUTED_USR = '$DISTRIBUTED_USR', 
                        IS_COMPLETE = '$IS_COMPLETE', 
                        COMPLETED_DT = '$COMPLETED_DT', 
                        CAE_FINAL_SCORE = '$CAE_FINAL_SCORE', 
                        CAE_FINAL_RESULT = '$CAE_FINAL_RESULT', 
                        CAE_RESULT = '$CAE_RESULT', 
                        CAE_DT = '$CAE_DT', 
                        DUKCAPIL = '$DUKCAPIL', 
                        DUKCAPIL_RESULT = '$DUKCAPIL_RESULT', 
                        DUKCAPIL_API_DT = '$DUKCAPIL_API_DT', 
                        SCHEME_ID = '$SCHEME_ID', 
                        SLIK_CBASID = '$SLIK_CBASID', 
                        SLIK_RESULT = '$SLIK_RESULT', 
                        SLIK_CATEGORY = '$SLIK_CATEGORY', 
                        SLIK_API_DT = '$SLIK_API_DT', 
                        SOURCE_DATA = '$SOURCE_DATA', 
                        KILAT_PINTAR = '$KILAT_PINTAR', 
                        BUSINESS_DATE = '$BUSINESS_DATE', 
                        OFFICE_REGION_CODE = '$OFFICE_REGION_CODE', 
                        OFFICE_REGION_NAME = '$OFFICE_REGION_NAME', 
                        OFFICE_CODE = '$OFFICE_CODE', 
                        OFFICE_NAME = '$OFFICE_NAME', 
                        CAB_COLL = '$CAB_COLL', 
                        CAB_COLL_NAME = '$CAB_COLL_NAME', 
                        KAPOS_NAME = '$KAPOS_NAME', 
                        PROD_OFFERING_CODE = '$PROD_OFFERING_CODE', 
                        LOB_CODE = '$LOB_CODE', 
                        CUST_TYPE = '$CUST_TYPE', 
                        CUST_NO = '$CUST_NO', 
                        CUST_NAME = '$CUST_NAME', 
                        ID_NO = '$ID_NO', 
                        GENDER = '$GENDER', 
                        RELIGION = '$RELIGION', 
                        BIRTH_PLACE = '$BIRTH_PLACE', 
                        BIRTH_DT = '$BIRTH_DT', 
                        SPOUSE_ID_NO = '$SPOUSE_ID_NO', 
                        SPOUSE_NAME = '$SPOUSE_NAME', 
                        SPOUSE_BIRTH_DT = '$SPOUSE_BIRTH_DT', 
                        ADDR_LEG = '$ADDR_LEG', 
                        RT_LEG = '$RT_LEG', 
                        RW_LEG = '$RW_LEG', 
                        PROVINSI_LEG = '$PROVINSI_LEG', 
                        CITY_LEG = '$CITY_LEG', 
                        KABUPATEN_LEG = '$KABUPATEN_LEG', 
                        KECAMATAN_LEG = '$KECAMATAN_LEG', 
                        KELURAHAN_LEG = '$KELURAHAN_LEG', 
                        ZIPCODE_LEG = '$ZIPCODE_LEG', 
                        SUB_ZIPCODE_LEG = '$SUB_ZIPCODE_LEG', 
                        ADDR_RES = '$ADDR_RES', 
                        RT_RES = '$RT_RES', 
                        RW_RES = '$RW_RES', 
                        PROVINSI_RES = '$PROVINSI_RES', 
                        CITY_RES = '$CITY_RES', 
                        KABUPATEN_RES = '$KABUPATEN_RES', 
                        KECAMATAN_RES = '$KECAMATAN_RES', 
                        KELURAHAN_RES = '$KELURAHAN_RES', 
                        ZIPCODE_RES = '$ZIPCODE_RES', 
                        SUB_ZIPCODE_RES = '$SUB_ZIPCODE_RES', 
                        MOBILE1 = '$MOBILE1', 
                        MOBILE2 = '$MOBILE2', 
                        PHONE1 = '$PHONE1', 
                        PHONE2 = '$PHONE2', 
                        OFFICE_PHONE1 = '$OFFICE_PHONE1', 
                        OFFICE_PHONE2 = '$OFFICE_PHONE2', 
                        PROFESSION_CODE = '$PROFESSION_CODE', 
                        PROFESSION_NAME = '$PROFESSION_NAME', 
                        PROFESSION_CATEGORY_CODE = '$PROFESSION_CATEGORY_CODE', 
                        PROFESSION_CATEGORY_NAME = '$PROFESSION_CATEGORY_NAME', 
                        JOB_POSITION = '$JOB_POSITION', 
                        JOB_STATUS = '$JOB_STATUS', 
                        INDUSTRY_TYPE_NAME = '$INDUSTRY_TYPE_NAME', 
                        OTHER_BIZ_NAME = '$OTHER_BIZ_NAME', 
                        MONTHLY_INCOME = '$MONTHLY_INCOME', 
                        MONTHLY_EXPENSE = '$MONTHLY_EXPENSE', 
                        MONTHLY_INSTALLMENT = '$MONTHLY_INSTALLMENT', 
                        DOWNPAYMENT = '$DOWNPAYMENT', 
                        PERCENT_DP = '$PERCENT_DP', 
                        PLAFOND = '$PLAFOND', 
                        CUST_RATING = '$CUST_RATING', 
                        SUPPL_NAME = '$SUPPL_NAME', 
                        SUPPL_CODE = '$SUPPL_CODE', 
                        MACHINE_NO = '$MACHINE_NO', 
                        CHASSIS_NO = '$CHASSIS_NO', 
                        PRODUCT_CATEGORY = '$PRODUCT_CATEGORY', 
                        ASSET_CATEGORY_CODE = '$ASSET_CATEGORY_CODE', 
                        ASSET_TYPE = '$ASSET_TYPE', 
                        ITEM_BRAND = '$ITEM_BRAND', 
                        ITEM_TYPE = '$ITEM_TYPE', 
                        ITEM_DESCRIPTION = '$ITEM_DESCRIPTION', 
                        ASSET_MODEL = '$ASSET_MODEL', 
                        OTR_PRICE = '$OTR_PRICE', 
                        ITEM_YEAR = '$ITEM_YEAR', 
                        OWNER_RELATIONSHIP = '$OWNER_RELATIONSHIP', 
                        BPKB_OWNERSHIP = '$BPKB_OWNERSHIP', 
                        AGRMNT_RATING = '$AGRMNT_RATING', 
                        CONTRACT_STAT = '$CONTRACT_STAT', 
                        INST_PAYED = '$INST_PAYED', 
                        NEXT_INST_NUM = '$NEXT_INST_NUM', 
                        NEXT_INST_DT = '$NEXT_INST_DT', 
                        OS_TENOR = '$OS_TENOR', 
                        TENOR = '$TENOR', 
                        RELEASE_DATE_BPKB = '$RELEASE_DATE_BPKB', 
                        MATURITY_DT = '$MATURITY_DT', 
                        MATURITY_DURATION = '$MATURITY_DURATION', 
                        GO_LIVE_DT = '$GO_LIVE_DT', 
                        GO_LIVE_DURATION = '$GO_LIVE_DURATION', 
                        AAM_RRD_DT = '$AAM_RRD_DT', 
                        EXPIRED_MONTHS = '$EXPIRED_MONTHS', 
                        OS_PRINCIPAL = '$OS_PRINCIPAL', 
                        OS_PRINCIPAL_AMT = '$OS_PRINCIPAL_AMT', 
                        OS_INTEREST_AMT = '$OS_INTEREST_AMT', 
                        AGING_PEMBIAYAAN = '$AGING_PEMBIAYAAN', 
                        JUMLAH_KONTRAK_PERCUST = '$JUMLAH_KONTRAK_PERCUST', 
                        ESTIMASI_TERIMA_BERSIH = '$ESTIMASI_TERIMA_BERSIH', 
                        STARTED_DT = '$STARTED_DT', 
                        POS_DEALER = '$POS_DEALER', 
                        SALES_DEALER_ID = '$SALES_DEALER_ID', 
                        SALES_DEALER = '$SALES_DEALER', 
                        DTM_CRT = '$DTM_CRT', 
                        USR_CRT = '$USR_CRT', 
                        DTM_UPD = '$DTM_UPD', 
                        USR_UPD = '$USR_UPD', 
                        COLL_AGRMNT_ID = '$COLL_AGRMNT_ID', 
                        AGRMNT_ASSET_ID = '$AGRMNT_ASSET_ID', 
                        ASSET_MASTER_ID = '$ASSET_MASTER_ID', 
                        DEFAULT_STAT = '$DEFAULT_STAT', 
                        CUST_ID = '$CUST_ID', 
                        HOME_STAT = '$HOME_STAT', 
                        MOTHER_NAME = '$MOTHER_NAME', 
                        IS_EVER_REPO = '$IS_EVER_REPO', 
                        IS_REPO = '$IS_REPO', 
                        IS_WRITE_OFF = '$IS_WRITE_OFF', 
                        IS_RESTRUKTUR = '$IS_RESTRUKTUR', 
                        IS_INSURANCE = '$IS_INSURANCE', 
                        IS_NEGATIVE_CUST = '$IS_NEGATIVE_CUST', 
                        IS_ACCOUNT_BAM = '$IS_ACCOUNT_BAM', 
                        CUST_EXPOSURE = '$CUST_EXPOSURE', 
                        AGE = '$AGE', 
                        ASSET_AGE = '$ASSET_AGE', 
                        SAME_ASSET_GO_LIVE = '$SAME_ASSET_GO_LIVE', 
                        LTV = '$LTV', 
                        DSR = '$DSR', 
                        MARITAL_STAT = '$MARITAL_STAT', 
                        EDUCATION = '$EDUCATION', 
                        EMPLOYMENT_ESTABLISHMENT_DT = '$EMPLOYMENT_ESTABLISHMENT_DT', 
                        LENGTH_OF_WORK = '$LENGTH_OF_WORK', 
                        HOUSE_STAY_LENGTH = '$HOUSE_STAY_LENGTH', 
                        LAST_OVERDUE = '$LAST_OVERDUE', 
                        MAX_OVERDUE = '$MAX_OVERDUE', 
                        MAX_OVERDUE_LAST_X_MONTHS = '$MAX_OVERDUE_LAST_X_MONTHS', 
                        IS_USED = '$IS_USED', 
                        SPOUSE_BIRTH_PLACE = '$SPOUSE_BIRTH_PLACE',
                        IS_SELECTED = '$IS_SELECTED',
                        PIPELINE_DUMMY_ID = '$PIPELINE_DUMMY_ID',
                        PIPELINE_DUMMY_IS_EARLY_WSC = '$PIPELINE_DUMMY_IS_EARLY_WSC',
                        FINAL_DT = '$FINAL_DT',
                        SPOUSE_PHONE = '$SPOUSE_PHONE',
                        SPOUSE_MOBILE_PHONE_NO = '$SPOUSE_MOBILE_PHONE_NO',
                        GUARANTOR_ID_NO = '$GUARANTOR_ID_NO',
                        GUARANTOR_NAME = '$GUARANTOR_NAME',
                        GUARANTOR_MOBILE_PHONE_NO = '$GUARANTOR_MOBILE_PHONE_NO',
                        GUARANTOR_BIRTH_PLACE = '$GUARANTOR_BIRTH_PLACE',
                        GUARANTOR_BIRTH_DT = '$GUARANTOR_BIRTH_DT',
                        GUARANTOR_ADDR = '$GUARANTOR_ADDR',
                        GUARANTOR_RT = '$GUARANTOR_RT',
                        GUARANTOR_RW = '$GUARANTOR_RW',
                        GUARANTOR_KELURAHAN = '$GUARANTOR_KELURAHAN',
                        GUARANTOR_KECAMATAN = '$GUARANTOR_KECAMATAN',
                        GUARANTOR_CITY = '$GUARANTOR_CITY',
                        GUARANTOR_PROVINSI = '$GUARANTOR_PROVINSI',
                        GUARANTOR_ZIPCODE = '$GUARANTOR_ZIPCODE',
                        GUARANTOR_SUBZIPCODE = '$GUARANTOR_SUBZIPCODE',
                        GUARANTOR_RELATIONSHIP = '$GUARANTOR_RELATIONSHIP',
                        SPOUSE_CUST_ID = '$SPOUSE_CUST_ID',
                        GUARANTOR_CUST_ID = '$GUARANTOR_CUST_ID',
                        opsi_penanganan = '$opsi_penanganan',
                        IS_PRE_APPROVAL = '$IS_PRE_APPROVAL',
                        is_eligible_crm = '1',
                        is_process = '1', 
                        is_assign  = '0', 
                        SYNC_TIME=now()";
        $resin2 =  mysqli_query($dbopen,$sql_in2);
    }

            $sqldelete = "DELETE FROM cc_ts_penawaran_job  
                             WHERE campaign_id='0' AND SOURCE_DATA = 'WISE'"; 
            $resdelete =  mysqli_query($dbopen,$sqldelete);

            
// $sqlengine = "SELECT a.CUST_NO,GROUP_CONCAT(a.AGRMNT_NO) AS agrmnno,GROUP_CONCAT(a.campaign_id) AS camp1,GROUP_CONCAT(b.agrmnt_no) AS agrmnno2,GROUP_CONCAT(b.campaign_id) AS camp2 
//                             FROM cc_ts_penawaran_job a LEFT JOIN cc_ts_penawaran b
//                             ON (a.CUST_NO=b.customer_id OR a.CUST_NO=b.customer_id_ro)
//                             WHERE a.is_eligible_crm=1 AND b.call_status=0 AND b.campaign_id>1
//                             GROUP BY a.CUST_NO
//                             HAVING COUNT(a.id)>1 ";
//             $resengine = mysqli_query($dbopen,$sqlengine);
//             while($recengine = mysqli_fetch_array($resengine)){
//                 $custno    = $recengine['CUST_NO']; 
//                 $agrmnno   = $recengine['agrmnno'];
//                 $camp1     = $recengine['camp1'];
//                 $agrmnno2  = $recengine['agrmnno2'];
//                 $camp2     = $recengine['camp2'];
//                 $arrcamp1 = explode(",", $camp1);
//                 $arrcamp2 = explode(",", $camp2);
//                 $arrcampall = array_merge($arrcamp1,$arrcamp2);
//                 // print_r($arrcampall);
//                 foreach ($arrcampall as $value) {
//                   // echo "string $value : ".$arrlevel[$value]."</br>";
//                   $arrparam[$value]= $arrlevel[$value];
//                 }
//                 $val2='';
//                 $camp_min='';
//                 foreach($arrparam as $x => $val) {
//                     // echo "string $x | $val </br>";
//                     if ($val2=='') {
//                         $val2=$val;
//                         $camp_min=$x;
//                     }
//                     if ($val<$val2) {
//                         $val2=$val;
//                         $camp_min=$x;
//                     }
//                 }


//                 $arragrmen   = explode(",", $agrmnno);
//                 $agrmnno2 ='';
//                 foreach($arragrmen as $x => $val) {
//                     // echo "string $x | $val </br>";
//                     if ($agrmnno2=='') {
//                         $agrmnno2="'$val'";
//                     }else{
//                         $agrmnno2.=",'$val'";
//                     }
//                 }

//                 $assignto=0;
//                 $sqlpnwr = "SELECT a.assign_to FROM cc_ts_penawaran a 
//                             WHERE a.campaign_id='$camp_min' AND (a.customer_id='$custno' OR a.customer_id_ro='$custno')
//                             AND a.call_status=0 AND a.is_process=1 ORDER BY ISNULL(a.assign_to) ASC, a.assign_to=0 LIMIT 1";//echo "string $sqlpnwr";
//                 $respnwr = mysqli_query($dbopen,$sqlpnwr);
//                 if($recpnwr = mysqli_fetch_array($respnwr)){
//                     $assignto  = $recpnwr['assign_to']; 
//                 }
//                 // if ($custno=='CUS116120201009534'||$custno=='CUS116120201211149') {
//                 //     echo "string $custno 121 $assignto > $sqlengine </br>";
//                 // }
                

//                 if ($assignto>0) {
//                     $sqljob = "SELECT a.* FROM cc_ts_penawaran_job a 
//                         WHERE a.CUST_NO='$custno' AND a.AGRMNT_NO IN ($agrmnno2) AND a.is_eligible_crm=1";//task_id='$taskId'
//                       $resjob = mysqli_query($dbopen,$sqljob);
//                       while($recjob = mysqli_fetch_array($resjob)){
//                         @extract($recjob,EXTR_OVERWRITE);

//                         if ($AGRMNT_NO!='') {
//                             $param_agrmen = " agrmnt_no = '$AGRMNT_NO', ";
//                         }else{
//                             $param_agrmen = "";
//                         }

//                         $param_task = "";
//                         if ($TASK_ID!='') {
//                             $param_task = " task_id = '$TASK_ID', ";
//                         }

//                         $sqlsa = "INSERT INTO cc_ts_penawaran 
//                                   SET AGRMNT_ID            = '$AGRMNT_ID', 
//                                   campaign_id              = '$campaign_id',
//                                   $param_agrmen 
//                                   $param_task
//                                   pipeline                 = '$PIPELINE_ID', 
//                                   distributed_date         = '$DISTRIBUTED_DT', 
//                                   final_result_cae         = '$CAE_FINAL_RESULT', 
//                                   dukcapil_result          = '$DUKCAPIL_RESULT', 
//                                   source_data              = '$SOURCE_DATA', 
//                                   kilat_pintar             = '$KILAT_PINTAR', 
//                                   region_code              = '$OFFICE_REGION_CODE', 
//                                   region_name              = '$OFFICE_REGION_NAME', 
//                                   cabang_code              = '$OFFICE_CODE', 
//                                   cabang_name              = '$OFFICE_NAME', 
//                                   cabang_coll              = '$CAB_COLL', 
//                                   cabang_coll_name         = '$CAB_COLL_NAME', 
//                                   kapos_name               = '$KAPOS_NAME', 
//                                   product_offering_code    = '$PROD_OFFERING_CODE', 
//                                   lob                      = '$LOB_CODE', 
//                                   customer_id_ro           = '$CUST_NO', 
//                                   customer_name            = '$CUST_NAME', 
//                                   nik_ktp                  = '$ID_NO', 
//                                   gender                   = '$GENDER', 
//                                   religion                 = '$RELIGION', 
//                                   tempat_lahir             = '$BIRTH_PLACE', 
//                                   tanggal_lahir            = '$BIRTH_DT', 
//                                   spouse_nik               = '$SPOUSE_ID_NO', 
//                                   spouse_name              = '$SPOUSE_NAME', 
//                                   spouse_birth_date        = '$SPOUSE_BIRTH_DT', 
//                                   spouse_birth_place       = '$SPOUSE_BIRTH_PLACE', 
//                                   legal_alamat             = '$ADDR_LEG', 
//                                   legal_rt                 = '$RT_LEG', 
//                                   legal_rw                 = '$RW_LEG', 
//                                   legal_provinsi           = '$PROVINSI_LEG', 
//                                   legal_city               = '$CITY_LEG', 
//                                   legal_kabupaten          = '$KABUPATEN_LEG', 
//                                   legal_kecamatan          = '$KECAMATAN_LEG', 
//                                   legal_kelurahan          = '$KELURAHAN_LEG', 
//                                   legal_kodepos            = '$ZIPCODE_LEG', 
//                                   legal_sub_kodepos        = '$SUB_ZIPCODE_LEG', 
//                                   survey_alamat            = '$ADDR_RES', 
//                                   survey_rt                = '$RT_RES', 
//                                   survey_rw                = '$RW_RES', 
//                                   survey_provinsi          = '$PROVINSI_RES', 
//                                   survey_city              = '$CITY_RES', 
//                                   survey_kabupaten         = '$KABUPATEN_RES', 
//                                   survey_kecamatan         = '$KECAMATAN_RES', 
//                                   survey_kelurahan         = '$KELURAHAN_RES', 
//                                   survey_kodepos           = '$ZIPCODE_RES', 
//                                   survey_sub_kodepos       = '$SUB_ZIPCODE_RES', 
//                                   mobile_1                 = '$MOBILE1', 
//                                   mobile_2                 = '$MOBILE2', 
//                                   phone_1                  = '$PHONE1', 
//                                   phone_2                  = '$PHONE2', 
//                                   office_phone_1           = '$OFFICE_PHONE1', 
//                                   office_phone_2           = '$OFFICE_PHONE2', 
//                                   profession_code          = '$PROFESSION_CODE', 
//                                   profession_name          = '$PROFESSION_NAME', 
//                                   profession_category_code = '$PROFESSION_CATEGORY_CODE', 
//                                   profession_cat_name      = '$PROFESSION_CATEGORY_NAME', 
//                                   job_position             = '$JOB_POSITION', 
//                                   industry_type_name       = '$INDUSTRY_TYPE_NAME', 
//                                   other_biz_name           = '$OTHER_BIZ_NAME', 
//                                   monthly_income           = '$MONTHLY_INCOME', 
//                                   monthly_expense          = '$MONTHLY_EXPENSE', 
//                                   monthly_instalment       = '$MONTHLY_INSTALLMENT', 
//                                   dp                       = '$DOWNPAYMENT', 
//                                   dp_pct                   = '$PERCENT_DP', 
//                                   plafond                  = '$PLAFOND', 
//                                   customer_rating          = '$CUST_RATING', 
//                                   suppl_name               = '$SUPPL_NAME', 
//                                   suppl_code               = '$SUPPL_CODE', 
//                                   no_mesin                 = '$MACHINE_NO', 
//                                   no_rangka                = '$CHASSIS_NO', 
//                                   product_category         = '$PRODUCT_CATEGORY', 
//                                   asset_category           = '$ASSET_CATEGORY_CODE', 
//                                   asset_type               = '$ASSET_TYPE', 
//                                   asset_age                = '$ASSET_AGE', 
//                                   brand                    = '$ITEM_BRAND', 
//                                   item_type                = '$ITEM_TYPE', 
//                                   item_desc                = '$ITEM_DESCRIPTION', 
//                                   otr_price                = '$OTR_PRICE', 
//                                   item_year                = '$ITEM_YEAR', 
//                                   ownership                = '$OWNER_RELATIONSHIP', 
//                                   kepemilikan_bpkb         = '$BPKB_OWNERSHIP', 
//                                   agrmnt_rating            = '$AGRMNT_RATING', 
//                                   status_kontrak           = '$CONTRACT_STAT', 
//                                   sisa_tenor               = '$OS_TENOR', 
//                                   tenor                    = '$TENOR', 
//                                   release_date_bpkb        = '$RELEASE_DATE_BPKB', 
//                                   maturity_date            = '$MATURITY_DT', 
//                                   go_live_dt               = '$GO_LIVE_DT', 
//                                   rrd_date                 = '$AAM_RRD_DT', 
//                                   os_principal             = '$OS_PRINCIPAL', 
//                                   os_installment_amt       = '$OS_INTEREST_AMT', 
//                                   aging_pembiayaan         = '$AGING_PEMBIAYAAN', 
//                                   jumlah_kontrak_per_cust  = '$JUMLAH_KONTRAK_PERCUST', 
//                                   estimasi_terima_bersih   = '$ESTIMASI_TERIMA_BERSIH', 
//                                   started_date             = '$STARTED_DT', 
//                                   pos_dealer               = '$POS_DEALER', 
//                                   sales_dealer_id          = '$SALES_DEALER_ID', 
//                                   sales_dealer             = '$SALES_DEALER', 
//                                   dtm_crt                  = '$DTM_CRT', 
//                                   usr_crt                  = '$USR_CRT', 
//                                   dtm_upd                  = '$DTM_UPD', 
//                                   usr_upd                  = '$USR_UPD', 
//                                   customer_id              = '$CUST_ID', 
//                                   kepemilikan_rumah        = '$HOME_STAT', 
//                                   nama_ibu_kandung         = '$MOTHER_NAME', 
//                                   is_repo                  = '$IS_REPO', 
//                                   is_write_off             = '$IS_WRITE_OFF', 
//                                   is_restructure           = '$IS_RESTRUKTUR', 
//                                   is_insurance             = '$IS_INSURANCE', 
//                                   is_negative              = '$IS_NEGATIVE_CUST', 
//                                   exposure                 = '$CUST_EXPOSURE', 
//                                   ltv                      = '$LTV', 
//                                   dsr                      = '$DSR', 
//                                   marital_status           = '$MARITAL_STAT', 
//                                   education                = '$EDUCATION', 
//                                   length_of_work           = '$LENGTH_OF_WORK', 
//                                   house_stay_length        = '$HOUSE_STAY_LENGTH', 
//                                   created_by               = '$v_agentid', 
//                                   modif_by                 = '$v_agentid', 
//                                   insert_time              = now(), 
//                                   modif_time               = now(), 
//                                   spv_id                   = '$v_agentid',
//                                   assign_to                = '$assignto', 
//                                   call_status              ='0',
//                                   assign_by                = '$v_agentid', 
//                                   back_flag                = '0', 
//                                   flag_wise                = '$flag_wise',
//                                   is_eligible_crm          = '$is_eligible_crm',
//                                   is_process               = '$is_process',
//                                   total_course             = '0',
                                                                                 
//                                   assign_time              = now()
//                                   ON DUPLICATE KEY UPDATE
//                                   AGRMNT_ID                = '$AGRMNT_ID', 
//                                   campaign_id              = '$campaign_id', 
//                                   $param_agrmen
//                                   $param_task
//                                   pipeline                 = '$PIPELINE_ID', 
//                                   distributed_date         = '$DISTRIBUTED_DT', 
//                                   final_result_cae         = '$CAE_FINAL_RESULT', 
//                                   dukcapil_result          = '$DUKCAPIL_RESULT', 
//                                   source_data              = '$SOURCE_DATA', 
//                                   kilat_pintar             = '$KILAT_PINTAR', 
//                                   region_code              = '$OFFICE_REGION_CODE', 
//                                   region_name              = '$OFFICE_REGION_NAME', 
//                                   cabang_code              = '$OFFICE_CODE', 
//                                   cabang_name              = '$OFFICE_NAME', 
//                                   cabang_coll              = '$CAB_COLL', 
//                                   cabang_coll_name         = '$CAB_COLL_NAME', 
//                                   kapos_name               = '$KAPOS_NAME', 
//                                   product_offering_code    = '$PROD_OFFERING_CODE', 
//                                   lob                      = '$LOB_CODE', 
//                                   customer_id_ro           = '$CUST_NO', 
//                                   customer_name            = '$CUST_NAME', 
//                                   nik_ktp                  = '$ID_NO', 
//                                   gender                   = '$GENDER', 
//                                   religion                 = '$RELIGION', 
//                                   tempat_lahir             = '$BIRTH_PLACE', 
//                                   tanggal_lahir            = '$BIRTH_DT', 
//                                   spouse_nik               = '$SPOUSE_ID_NO', 
//                                   spouse_name              = '$SPOUSE_NAME', 
//                                   spouse_birth_date        = '$SPOUSE_BIRTH_DT', 
//                                   spouse_birth_place       = '$SPOUSE_BIRTH_PLACE', 
//                                   legal_alamat             = '$ADDR_LEG', 
//                                   legal_rt                 = '$RT_LEG', 
//                                   legal_rw                 = '$RW_LEG', 
//                                   legal_provinsi           = '$PROVINSI_LEG', 
//                                   legal_city               = '$CITY_LEG', 
//                                   legal_kabupaten          = '$KABUPATEN_LEG', 
//                                   legal_kecamatan          = '$KECAMATAN_LEG', 
//                                   legal_kelurahan          = '$KELURAHAN_LEG', 
//                                   legal_kodepos            = '$ZIPCODE_LEG', 
//                                   legal_sub_kodepos        = '$SUB_ZIPCODE_LEG', 
//                                   survey_alamat            = '$ADDR_RES', 
//                                   survey_rt                = '$RT_RES', 
//                                   survey_rw                = '$RW_RES', 
//                                   survey_provinsi          = '$PROVINSI_RES', 
//                                   survey_city              = '$CITY_RES', 
//                                   survey_kabupaten         = '$KABUPATEN_RES', 
//                                   survey_kecamatan         = '$KECAMATAN_RES', 
//                                   survey_kelurahan         = '$KELURAHAN_RES', 
//                                   survey_kodepos           = '$ZIPCODE_RES', 
//                                   survey_sub_kodepos       = '$SUB_ZIPCODE_RES', 
//                                   mobile_1                 = '$MOBILE1', 
//                                   mobile_2                 = '$MOBILE2', 
//                                   phone_1                  = '$PHONE1', 
//                                   phone_2                  = '$PHONE2', 
//                                   office_phone_1           = '$OFFICE_PHONE1', 
//                                   office_phone_2           = '$OFFICE_PHONE2', 
//                                   profession_code          = '$PROFESSION_CODE', 
//                                   profession_name          = '$PROFESSION_NAME', 
//                                   profession_category_code = '$PROFESSION_CATEGORY_CODE', 
//                                   profession_cat_name      = '$PROFESSION_CATEGORY_NAME', 
//                                   job_position             = '$JOB_POSITION', 
//                                   industry_type_name       = '$INDUSTRY_TYPE_NAME', 
//                                   other_biz_name           = '$OTHER_BIZ_NAME', 
//                                   monthly_income           = '$MONTHLY_INCOME', 
//                                   monthly_expense          = '$MONTHLY_EXPENSE', 
//                                   monthly_instalment       = '$MONTHLY_INSTALLMENT', 
//                                   dp                       = '$DOWNPAYMENT', 
//                                   dp_pct                   = '$PERCENT_DP', 
//                                   plafond                  = '$PLAFOND', 
//                                   customer_rating          = '$CUST_RATING', 
//                                   suppl_name               = '$SUPPL_NAME', 
//                                   suppl_code               = '$SUPPL_CODE', 
//                                   no_mesin                 = '$MACHINE_NO', 
//                                   no_rangka                = '$CHASSIS_NO', 
//                                   product_category         = '$PRODUCT_CATEGORY', 
//                                   asset_category           = '$ASSET_CATEGORY_CODE', 
//                                   asset_type               = '$ASSET_TYPE', 
//                                   asset_age                = '$ASSET_AGE', 
//                                   brand                    = '$ITEM_BRAND', 
//                                   item_type                = '$ITEM_TYPE', 
//                                   item_desc                = '$ITEM_DESCRIPTION', 
//                                   otr_price                = '$OTR_PRICE', 
//                                   item_year                = '$ITEM_YEAR', 
//                                   ownership                = '$OWNER_RELATIONSHIP', 
//                                   kepemilikan_bpkb         = '$BPKB_OWNERSHIP', 
//                                   agrmnt_rating            = '$AGRMNT_RATING', 
//                                   status_kontrak           = '$CONTRACT_STAT', 
//                                   sisa_tenor               = '$OS_TENOR', 
//                                   tenor                    = '$TENOR', 
//                                   release_date_bpkb        = '$RELEASE_DATE_BPKB', 
//                                   maturity_date            = '$MATURITY_DT', 
//                                   go_live_dt               = '$GO_LIVE_DT', 
//                                   rrd_date                 = '$AAM_RRD_DT', 
//                                   os_principal             = '$OS_PRINCIPAL', 
//                                   os_installment_amt       = '$OS_INTEREST_AMT', 
//                                   aging_pembiayaan         = '$AGING_PEMBIAYAAN', 
//                                   jumlah_kontrak_per_cust  = '$JUMLAH_KONTRAK_PERCUST', 
//                                   estimasi_terima_bersih   = '$ESTIMASI_TERIMA_BERSIH', 
//                                   started_date             = '$STARTED_DT', 
//                                   pos_dealer               = '$POS_DEALER', 
//                                   sales_dealer_id          = '$SALES_DEALER_ID', 
//                                   sales_dealer             = '$SALES_DEALER', 
//                                   dtm_crt                  = '$DTM_CRT', 
//                                   usr_crt                  = '$USR_CRT', 
//                                   dtm_upd                  = '$DTM_UPD', 
//                                   usr_upd                  = '$USR_UPD', 
//                                   customer_id              = '$CUST_ID', 
//                                   kepemilikan_rumah        = '$HOME_STAT', 
//                                   nama_ibu_kandung         = '$MOTHER_NAME', 
//                                   is_repo                  = '$IS_REPO', 
//                                   is_write_off             = '$IS_WRITE_OFF', 
//                                   is_restructure           = '$IS_RESTRUKTUR', 
//                                   is_insurance             = '$IS_INSURANCE', 
//                                   is_negative              = '$IS_NEGATIVE_CUST', 
//                                   exposure                 = '$CUST_EXPOSURE', 
//                                   ltv                      = '$LTV', 
//                                   dsr                      = '$DSR', 
//                                   marital_status           = '$MARITAL_STAT', 
//                                   education                = '$EDUCATION', 
//                                   length_of_work           = '$LENGTH_OF_WORK', 
//                                   house_stay_length        = '$HOUSE_STAY_LENGTH', 
//                                   created_by               = '$v_agentid', 
//                                   modif_by                 = '$v_agentid', 
//                                   insert_time              = now(), 
//                                   modif_time               = now(), 
//                                   spv_id                   = '$v_agentid',
//                                   assign_to                = '$assignto', 
//                                   call_status              ='0',
//                                   assign_by                = '$v_agentid',
//                                   back_flag                = '0',  
//                                   flag_wise                = '$flag_wise',
//                                   is_eligible_crm          = '$is_eligible_crm',
//                                   is_process               = '$is_process',
                                                                                 
//                                   total_course             = '0',
//                                   assign_time              = now()
//                                   ";//echo "string $sqlsa </br></br>";

//                                   mysqli_query($dbopen,$sqlsa);
                                  
//                                 $sqlupd = "UPDATE cc_ts_penawaran_job SET is_assign = 1 WHERE id=$id";
//                                 mysqli_query($dbopen, $sqlupd);
//                         }
//                 }else{
//                     $sqlupd = "UPDATE cc_ts_penawaran SET assign_to = 0 WHERE (customer_id='$custno' OR customer_id_ro='$custno')
//                                AND call_status=0";
//                                 mysqli_query($dbopen, $sqlupd);

//                     $sqlupd2 = "UPDATE cc_ts_penawaran_job SET is_assign = 0 WHERE CUST_NO='$custno' AND is_assign=1 AND is_eligible_crm=1";
//                     mysqli_query($dbopen, $sqlupd2);

//                     // if ($custno=='CUS116120201009534'||$custno=='CUS116120201211149') {
//                     //     echo "string $sqlupd > $sqlupd2</br>";
//                     // }
//                 }


//         }




           

disconnectDB($dbopen);


mssql_close($con);

echo "Sync Data POLO_ELIGIBLE OK <br><br><br>";

echo "Sync Process Done <br>";

?>