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

$condb = connectDB();

$nik = filter_input(INPUT_GET, 'nik');
$custname = filter_input(INPUT_GET, 'nama_lengkap');
$birthplace = filter_input(INPUT_GET, 'tempat_lahir');
$bod = filter_input(INPUT_GET, 'tgl_lahir'); 
$user_name = filter_input(INPUT_GET, 'user_name');
$emp_name = filter_input(INPUT_GET, 'emp_name');
$office_code = filter_input(INPUT_GET, 'office_code');
$office_name = filter_input(INPUT_GET, 'office_name');
$region = filter_input(INPUT_GET, 'region'); 
$cust_no = filter_input(INPUT_GET, 'cust_no');
$app_no = filter_input(INPUT_GET, 'app_no');
$ip_user = filter_input(INPUT_GET, 'ip_user');
$source = filter_input(INPUT_GET, 'source');
$mothername = filter_input(INPUT_GET, 'mother_name');
$dateexe = DATE("Y-m-d H:i:s");

    $curl = curl_init();
    $url = "https://10.0.89.214:8443/api/Pengajuan/GetCustAppByCustNIK/$nik";
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://10.0.89.214:8443/api/Pengajuan/GetCustAppByCustNIK/'.$nik,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_SSL_VERIFYHOST => false,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
      ),
    ));
    $response = curl_exec($curl);
    
    $resp = json_decode($response, true);
    curl_close($curl);

    $test = $resp['data'];
    $test2 = $test['listApp'];
    $iscustpreappr = $test['isCustomerPreApproval'];
    $param_resp = "0";
    for ($i=0; $i < count($test2); $i++) {
        $test3 = $test2[$i];
        $test4 = $test3['listAsset'];
        $agrmntNo = $test3['agrmntNo'];
        $isPreApproval = $test3['isPreApproval'];

        if ($iscustpreappr==='1') {
          $sqllog = "UPDATE cc_ts_penawaran SET
                          is_pre_approval            ='1', 
                          qa_approve_time         =now()
                     WHERE agrmnt_no='$agrmntNo'";
          $reslog = mysqli_query($condb,$sqllog);
          $param_resp .= ",$agrmntNo|1";
        }else{
          $sqllog = "UPDATE cc_ts_penawaran SET
                          is_pre_approval         ='$isPreApproval', 
                          qa_approve_time         =now()
                     WHERE agrmnt_no='$agrmntNo'";
          $reslog = mysqli_query($condb,$sqllog);
          $param_resp .= ",$agrmntNo|$isPreApproval";
        }
        
    }
    


$sqllog->prepare("INSERT INTO cc_respons_log SET
                type_api            ='API_Check_CustomerPreApproval', 
                url_api             ='$url', 
                post_api            ='$payload', 
                respon_status       ='$responseMessage', 
                respon_desc         ='$response', 
                respon_exe          ='$dateexe', 
                respon_time         =now()");
$reslog = mysqli_query($condb,$sqllog);


disconnectDB($condb);

?>
