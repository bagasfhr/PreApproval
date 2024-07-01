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
$customer_id = filter_input(INPUT_GET, 'customer_id');
$PreApproval = filter_input(INPUT_GET, 'PreApproval');
$custname = filter_input(INPUT_GET, 'nama_lengkap');
$birthplace = filter_input(INPUT_GET, 'tempat_lahir');
$bod = filter_input(INPUT_GET, 'tgl_lahir'); 
$app_no = filter_input(INPUT_GET, 'app_no');
$sqlpreapr = "";
if ($PreApproval===1) {
  $sqlpreapr = ', "IsPreApproval":"1"';
}else{
  $sqlpreapr = ', "IsPreApproval":"0"';
}

    $payload = '{
        "check_type":"negative cust",
        "cust_no":"'.$customer_id.'",
        "nik":"'.$nik.'",
        "fullname":"'.$custname.'",
        "birthdate":"'.$bod.'",
        "birthplace":"'.$birthplace.'",
        "source":"CRM"'.$sqlpreapr.',
        "app_no":"'.$app_no.'"
        }';
        if ($customer_id==='') {
          $payload = '{
                      "check_type":"negative cust",
                      "cust_no":"'.$customer_id.'",
                      "nik":"'.$nik.'",
                      "fullname":"'.$custname.'",
                      "birthdate":"'.$bod.'",
                      "birthplace":"'.$birthplace.'",
                      "source":"CRM"'.$sqlpreapr.',
                      "app_no":"'.$app_no.'"
                      }';
        }
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
      CURLOPT_POSTFIELDS =>$payload,
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
      ),
    ));
    $response = curl_exec($curl);
    
    $resp = json_decode($response, true);
    curl_close($curl);

    $test = $resp['data'];
    $test2 = $test['listDuplicateObj'];
    $response_cabang ="";
    $response_total =0;
    for ($i=0; $i < count($test2); $i++) { 
        $test3 = $test2[$i];
        $test4 = $test3['officeName'];
        $wise_stat = $test3['wiseStat'];
        $mss_stat  = $test3['mssStat'];
        if ($wise_stat!=='') {
          $stat = $wise_stat;
        }else{
          if ($mss_stat!=='') {
            $stat = $mss_stat;
          }else{
            $stat="Prosess";
          }
        }
        if ($test4!=="") {
          $response_total++;
          $response_cabang .= "Cabang $test4 : $stat </br> ";
        }
        
    }

    $response = str_replace('"responseCode":"00",', '"responseCode":"00","responseTotal":"'.$response_total.'", "responseCabang":"'.$response_cabang.'",', $response);


$responseMessage        = $resp[0]['ResponseMessage'];

$sqllog->prepare("INSERT INTO cc_respons_log SET
                type_api            ='API_Check_Negative', 
                url_api             ='http://10.0.89.213:8080/cae_score', 
                post_api            ='$payload', 
                respon_status       ='$responseMessage', 
                respon_desc         ='$response', 
                respon_time         =now()");
$reslog = mysqli_query($condb,$sqllog);


disconnectDB($condb);

?>
