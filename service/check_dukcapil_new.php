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

$nik            = $xxx = filter_input(INPUT_GET, 'nik'];
$custname       = $xxx = filter_input(INPUT_GET, 'nama_lengkap'];
$birthplace     = $xxx = filter_input(INPUT_GET, 'tempat_lahir'];
$bod            = $xxx = filter_input(INPUT_GET, 'tgl_lahir']; 
$user_name      = $xxx = filter_input(INPUT_GET, 'user_name'];
$emp_name       = $xxx = filter_input(INPUT_GET, 'emp_name'];
$office_code    = $xxx = filter_input(INPUT_GET, 'office_code'];
$office_name    = $xxx = filter_input(INPUT_GET, 'office_name'];
$region         = $xxx = filter_input(INPUT_GET, 'region']; 
$cust_no        = $xxx = filter_input(INPUT_GET, 'cust_no'];
$app_no         = $xxx = filter_input(INPUT_GET, 'app_no'];
$ip_user        = $xxx = filter_input(INPUT_GET, 'ip_user'];
$source         = $xxx = filter_input(INPUT_GET, 'source'];
$PreApproval    = $xxx = filter_input(INPUT_GET, 'PreApproval'];
$sqlpreapr = "";
if ($PreApproval===1) {
  $sqlpreapr = ', "IsPreApproval":"1"';
}else{
  $sqlpreapr = ', "IsPreApproval":"0"';
}
$bod3           = explode(" ", $bod);
$bod2           = explode("-", $bod3[0]);
$bod            = $bod2[2]."-".$bod2[1]."-".$bod2[0];    
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://10.0.89.213:8080/cae_score',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_SSL_VERIFYHOST => false,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
        "check_type":"data dukcapil",
        "source":"'.$source.'",
        "nik":"'.$nik.'",
        "fullname":"'.$custname.'",
        "birthdate":"'.$bod.'",
        "birthplace":"'.$birthplace.'",
        "app_no":"'.$app_no.'"'.$sqlpreapr.'
        }',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
      ),
    ));
    $response = curl_exec($curl);
    $payload = '{
        "check_type":"data dukcapil",
        "source":"'.$source.'",
        "nik":"'.$nik.'",
        "fullname":"'.$custname.'",
        "birthdate":"'.$bod.'",
        "birthplace":"'.$birthplace.'",
        "app_no":"'.$app_no.'"'.$sqlpreapr.'
        }';
    $resp = json_decode($response, true);
    curl_close($curl);
    echo $response;


$responseMessage        = $resp[0]['ResponseMessage'];

$sqllog = "INSERT INTO cc_respons_log SET
                type_api            ='API_Check_Dukcapil', 
                url_api             ='http://10.0.89.213:8080/cae_score', 
                post_api            ='$payload', 
                respon_status       ='$responseMessage', 
                respon_desc         ='$response', 
                respon_exe          ='', 
                respon_time         =now()";
$reslog = mysqli_query($condb,$sqllog);


disconnectDB($condb);

?>
