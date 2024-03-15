<?php
include "config_api.php";
include "../../sysconf/global_func.php";
include "../../sysconf/db_config.php";

$condb = connectDB();

$nik            = $_GET['nik'];
$custname       = $_GET['nama_lengkap'];
$birthplace     = $_GET['tempat_lahir'];
$bod            = $_GET['tgl_lahir']; //06-07-1987
$user_name      = $_GET['user_name'];
$emp_name       = $_GET['emp_name'];
$office_code    = $_GET['office_code'];
$office_name    = $_GET['office_name'];
$region         = $_GET['region']; //1
$cust_no        = $_GET['cust_no'];
$app_no         = $_GET['app_no'];
$ip_user        = $_GET['ip_user'];
$source         = $_GET['source'];
$PreApproval    = $_GET['PreApproval'];
$sqlpreapr = "";
if ($PreApproval==1) {
  $sqlpreapr = ', "IsPreApproval":"1"';
}else{
  $sqlpreapr = ', "IsPreApproval":"0"';
}
$bod3           = explode(" ", $bod);
$bod2           = explode("-", $bod3[0]);
$bod            = $bod2[2]."-".$bod2[1]."-".$bod2[0];    
    $curl = curl_init();
    // "NIK":"3256389511257895",
    // "CustName":"MARIA ANANTA",
    // "BirthPlace":"JAKARTA",
    // "BirthDt":"1993-01-01",
    // "MotherMaidenNmae":"SITI"
    // CURLOPT_URL => 'https://10.0.89.228:8080/cae_score',
    // $nik="3576022907810002";
    // $nik="zeky";
    // $nik="29-07-1981";
    // $nik="surabaya";
    curl_setopt_array($curl, array(
      // CURLOPT_URL => 'http://10.0.89.228:8080/cae_score',
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
    // print_r($resp);
      // return $response;
    // $resp = json_decode($result, true);
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
