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
$mothername     = $_GET['mother_name'];
$dateexe = DATE("Y-m-d H:i:s");

    // echo "URL : https://10.0.89.214:8443/api/Engine/CheckDuplicateCustomer</br></br>";
    // echo "JSON : ".'{
    //     "NIK":"'.$nik.'",
    //     "CustName":"'.$custname.'",
    //     "BirthPlace":"'.$birthplace.'",
    //     "BirthDt":"'.$bod.'",
    //     "MotherMaidenNmae":"'.$mothername.'",
    //     "SourceData":"CRM"
    //     }';
    $curl = curl_init();
    // "NIK":"3256389511257895",
    // "CustName":"MARIA ANANTA",
    // "BirthPlace":"JAKARTA",
    // "BirthDt":"1993-01-01",
    // "MotherMaidenNmae":"SITI"
    // CURLOPT_URL => 'https://10.0.89.228:8080/cae_score',
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
      // CURLOPT_POSTFIELDS =>'{
      //   "NIK":"'.$nik.'"
      //   }',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
      ),
    ));
    $response = curl_exec($curl);
// print_r($response); echo "<br>";
// echo 'Curl error: ' . curl_error($curl);
    
    $resp = json_decode($response, true);
    curl_close($curl);
    // print_r($resp);
      // return $response;
    // $resp = json_decode($result, true);

   
    //start new
    $test = $resp['data'];
    $test2 = $test['listApp'];
    $iscustpreappr = $test['isCustomerPreApproval'];
    $param_resp = "0";
    // echo "string $iscustpreappr </br></br>";
    for ($i=0; $i < count($test2); $i++) {
        $test3 = $test2[$i];
        $test4 = $test3['listAsset'];
        // print_r($test4);
        $agrmntNo = $test3['agrmntNo'];
        $isPreApproval = $test3['isPreApproval'];
        // echo "string $agrmntNo || $isPreApproval </br>";
        // print_r($test3);
        // $test4 = $test3['officeName'];

        if ($iscustpreappr=='1') {
          $sqllog = "UPDATE cc_ts_penawaran SET
                          is_pre_approval            ='1', 
                          qa_approve_time         =now()
                     WHERE agrmnt_no='$agrmntNo'";//echo "string11 $sqllog </br></br>";
          $reslog = mysqli_query($condb,$sqllog);
          $param_resp .= ",$agrmntNo|1";
        }else{
          $sqllog = "UPDATE cc_ts_penawaran SET
                          is_pre_approval         ='$isPreApproval', 
                          qa_approve_time         =now()
                     WHERE agrmnt_no='$agrmntNo'";//echo "string22 $sqllog </br></br>";
          $reslog = mysqli_query($condb,$sqllog);
          $param_resp .= ",$agrmntNo|$isPreApproval";
        }
        
    }
    // echo $response;
echo "$param_resp";

// $responseMessage        = $resp[0]['ResponseMessage'];

$sqllog = "INSERT INTO cc_respons_log SET
                type_api            ='API_Check_CustomerPreApproval', 
                url_api             ='$url', 
                post_api            ='$payload', 
                respon_status       ='$responseMessage', 
                respon_desc         ='$response', 
                respon_exe          ='$dateexe', 
                respon_time         =now()";//echo "</br></br>string $sqllog";
$reslog = mysqli_query($condb,$sqllog);


disconnectDB($condb);

?>
