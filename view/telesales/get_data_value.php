<?php
include "../../sysconf/con_reff.php";
include "../../sysconf/global_func.php";
include "../../sysconf/session.php";
include "../../sysconf/db_config.php";

$v_agentid	= get_session("v_agentid");
$v_skillnya = get_session("v_skillnya");
$v_agentgroup   = get_session("v_agentgroup");
$id 		= get_param("id");
$v          = get_param("v"); 

$condb = connectDB();

if($v=="call_status"){ 
		$call_statusid = get_param("call_statusid");
	    $arr_category= array();
        $sql1 = "SELECT id, call_status_sub1 
											  FROM cc_ts_call_status_sub1
											  WHERE call_status_id='$call_statusid'
											  AND id NOT IN (21,22)
											  ORDER BY call_status_sub1 ASC ";
		$res1 = mysqli_query($condb, $sql1);
		$arr_category[] = "<option value=''>-- Select --</select>";
		while($row1 = mysqli_fetch_array($res1)) {
			@extract($row1, EXTR_OVERWRITE);
			//if($call_statusid == $id) {
			//	$arr_category[] = "<option value='$id' selected>$interaction_status</option>";
			//} else {
				$arr_category[] = "<option value='$id' data-value='$call_status_sub1'>$call_status_sub1</option>";
			//}
		}
	$aReturn['arr_category'] 	    	= $arr_category; 


	
	
	echo json_encode($aReturn);
}
else if($v=="call_status2"){ 
		$call_statusid = get_param("call_statusid");
	    $arr_category= array();
        $sql1 = "SELECT id, call_status_sub1 
											  FROM cc_ts_konfirmasi_sub1_call_status
											  WHERE call_status_id='$call_statusid'
											  AND id NOT IN (21)
											  ORDER BY call_status_sub1 ASC ";
		$res1 = mysqli_query($condb, $sql1);
		$arr_category[] = "<option value=''>-- Select --</select>";
		while($row1 = mysqli_fetch_array($res1)) {
			@extract($row1, EXTR_OVERWRITE);
			//if($call_statusid == $id) {
			//	$arr_category[] = "<option value='$id' selected>$interaction_status</option>";
			//} else {
				$arr_category[] = "<option value='$id' data-value='$call_status_sub1'>$call_status_sub1</option>";
			//}
		}
	$aReturn['arr_category'] 	    	= $arr_category; 


	
	
	echo json_encode($aReturn);
}
else if($v=="whskill"){
	$skillid     	= get_param("skillid");

	$arr_agent= array();
	$arr_agent[] = "<option value=''>--To--</select>";
	
	if($skillid != "") {
	
		$whr = "";
		if($skillid == "0") {
			$sqlstr1 = "SELECT  GROUP_CONCAT(a.skill_id SEPARATOR ', ') AS vskill_id 
			FROM cc_skill_feature a WHERE a.skill_feature = '10'";
			$sqlres1 = mysqli_query($condb, $sqlstr1); 
			if ($sqlrec1 = mysqli_fetch_array($sqlres1)) {
				$vskill_id = $sqlrec1['vskill_id'];  
			}
			$whr .= " AND a.skill_id IN (".$vskill_id.") ";
		} else {
			$whr .= " AND a.skill_id = '".$skillid."' ";
		}	
	
		$sql_str1 = "SELECT b.id, b.agent_id, b.agent_name, b.agent_level FROM cc_skill_agent a, cc_agent_profile b 
		WHERE b.agent_level = 1 AND
		a.agent_id=b.id $whr group by b.agent_name order by b.agent_name ASC"; 
		 //echo $sql_str1;
		$sql_res1 = mysqli_query($condb, $sql_str1); 
		while ($sql_rec1 = mysqli_fetch_array($sql_res1)) {
			$id       	= $sql_rec1['id'];  
			$agent_name = $sql_rec1['agent_name'];  
			$status  	= $sql_rec1['status'];
	
			$arr_agent[] = "<option value='$id'>$agent_name</option>";
			
		}
	}

	$aReturn['arr_agent'] = $arr_agent;
	echo json_encode($aReturn);

}
else if($v=="distribusi"){
	$sql_str1 = "SELECT id, agent_id, agent_name,agent_level FROM cc_agent_profile WHERE agent_level IN(1,2) ORDER BY agent_name";
								    $sql_res1  = execSQL($conDB, $sql_str1);    
								    while ($sql_rec1 = mysqli_fetch_array($sql_res1)) {
								        $id       			= $sql_rec1['id'];  
								        $channel_name       = $sql_rec1['agent_name'];  
								        $status         	= $sql_rec1['status'];  
								        $checkbox = "";
								        if ($status == "1") {
								          	$checkbox  .= "<label class='form-check-label'>";
											$checkbox  .= "<input id='fomni_".$id."' name='fomni_".$id."' class='form-check-input' type='checkbox' value='1' checked >";
											$checkbox  .= "<span class='form-check-sign'>".$channel_name."</span>";
											$checkbox  .= "</label>";	
									    }else{
									        $checkbox  .= "<label class='form-check-label'>";
											$checkbox  .= "<input id='fomni_".$id."' name='fomni_".$id."' class='form-check-input' type='checkbox' value='1' >";
											$checkbox  .= "<span class='form-check-sign'>".$channel_name."</span>";
											$checkbox  .= "</label>";	
									    }

								        $arr_checkbox[] = "<div style=\"float:left;width:33%\">";
									    $arr_checkbox[] .= "$checkbox";
									    $arr_checkbox[] .= "</div>";
								    }

	$aReturn['arr_checkbox'] 	    	= $arr_checkbox; 
	
	echo json_encode($aReturn);
} else if($v=="campaignid"){
		$campid = get_param("campid");
	    $arr_campaign= array();
		$arr_campaign[] = "<option value=''>--Selected--</option>";
        $sql1 = "SELECT a.id, a.campaign_name FROM cc_campaign_prv a WHERE a.category_id = '$campid' AND a.status = 1 ORDER BY a.id ASC "; //echo $sql1;
		$res1 = mysqli_query($condb, $sql1);
		$arr_category[] = "<option value=''>-- Select --</select>";
		while($row1 = mysqli_fetch_array($res1)) {
			@extract($row1, EXTR_OVERWRITE);
			
			$arr_campaign[] = "<option value='$id'>$campaign_name</option>";
		
		}
	$aReturn['arr_campaign'] = $arr_campaign; 
	
	echo json_encode($aReturn);
} else if($v=="wskill"){
		$skillid     	= get_param("skillid");
		$val_search  	= get_param("val_search");
		$paramcheck  	= get_param("paramcheck");
		//$v_agentgroup  	= get_session("v_agentgroup");
		$v_agentgroup  	= get_param("grpid");
		$paramcheck  	= explode("|", $paramcheck);
		$total_check 	= count($paramcheck);//echo "string $total_check";

		// echo "string".$skillid;
	    $arr_agent= array();

	    if($skillid != "") {

	    	$whr = "";
	    	if($skillid == "0") {
	    		$sqlstr1 = "SELECT  GROUP_CONCAT(a.skill_id SEPARATOR ', ') AS vskill_id FROM cc_skill_feature a WHERE a.skill_feature = '10'";
			    $sqlres1 = mysqli_query($condb, $sqlstr1); 
			    if ($sqlrec1 = mysqli_fetch_array($sqlres1)) {
		        	$vskill_id = $sqlrec1['vskill_id'];  
			    }
			    
	    		// $whr .= " AND a.skill_id IN (".$vskill_id.") GROUP BY a.agent_id ";
	    	} else {
	    		$whr .= " AND a.skill_id = '".$skillid."' ";
	    	}	
	    	$whr_search="";
	    	if ($val_search != "") {
				$whr_search = " AND b.agent_name LIKE '%".$val_search."%' ";
			}
	    		// $arr_agent[] = "<div>
	    		// 				<input id=\"param_search\" name=\"param_search\" type=\"text\" value=\"$val_search\"
	    		// 				onkeyup=\"search_funct(this.value)\" placeholder=\"Search\">
	    		// 				</div> <br>";

		    	$arr_agent[] = "<div style=\"float:left;width:33%\"><label class='form-check-label'><input id='fomni_0' name='fomni_0' class='form-check-input' type='checkbox' value='1' onclick=\"checkstatus()\" ><span class='form-check-sign'>All ONLINE</span></label></div>";
				// $arr_agent[] = "";
				
			//$arr_agent[] = "<nav>";
		    $checkboxtot = 0;
		/*	$sql_str1 = "SELECT b.id, b.agent_id, b.agent_name, b.agent_level FROM cc_skill_agent a, cc_agent_profile b WHERE b.agent_level = 1 AND b.login_status=1 AND
			a.agent_id=b.id  $whr_search $whr group by b.agent_name order by b.agent_name ASC";
			*/
			$sql_str1 = "SELECT b.id, b.agent_id, b.agent_name, b.agent_level FROM cc_skill_agent a, cc_group_agent c LEFT JOIN cc_agent_profile b ON c.agent_id=b.id WHERE b.agent_level = 1 AND b.login_status=1 AND a.agent_id=c.agent_id AND
			a.agent_id=b.id  AND c.group_id='$v_agentgroup' $whr_search $whr group by b.agent_name order by b.agent_name ASC";// echo $sql_str1;
			//echo $sql_str1;
		    $sql_res1 = mysqli_query($condb, $sql_str1); 
		    while ($sql_rec1 = mysqli_fetch_array($sql_res1)) {
		        $id       	= $sql_rec1['id'];  
		        $agent_name = $sql_rec1['agent_name'];  
		        $status  	= $sql_rec1['status'];  
		        $checkbox 	= "";

		        $check = "";
		        $sql_str12 = "SELECT a.`check` FROM cc_ts_assign a WHERE a.agent_id='$id' AND a.create_by='$v_agentid'"; 
			    $sql_res12 = mysqli_query($condb, $sql_str12); 
			    if ($sql_rec12 = mysqli_fetch_array($sql_res12)) {
			        $check       	= $sql_rec12['check']; 
			    }
			    if ($check != "") {
			    	$status =1;
			    }

			    // start new
				if ($paramcheck !=""){
					for ($x = 0; $x <= $total_check; $x++) {
						if ($id == $paramcheck[$x])
						  {
						  $status =1;
						  }
					}
				}
			    //end new

			    $checkboxtot++;
		        if ($status == "1") {
		          	$arr_agent[] = "<div style=\"float:left;width:33%\"><label class='form-check-label'><input id='fomni_".$checkboxtot."' name='fomni_id[]' class='form-check-input' type='checkbox' value='".$id."' checked onclick=\"check_insert(this.value)\" ><span class='form-check-sign'><font color='blue'>".$agent_name."</font></span></label></div>";	
			    }else {
			        $arr_agent[] = "<div style=\"float:left;width:33%\"><label class='form-check-label'><input id='fomni_".$checkboxtot."' name='fomni_id[]' class='form-check-input' type='checkbox' value='".$id."' onclick=\"check_insert(this.value)\" ><span class='form-check-sign'>".$agent_name."</span></label></div>";	
			    }
		    }

		    $sql_str2 = "SELECT b.id, b.agent_id, b.agent_name, b.agent_level FROM cc_skill_agent a, cc_group_agent c LEFT JOIN cc_agent_profile b ON c.agent_id=b.id WHERE b.agent_level = 1 AND b.login_status=0 AND a.agent_id=c.agent_id AND
			a.agent_id=b.id AND c.group_id='$v_agentgroup' $whr_search $whr group by b.agent_name order by b.agent_name ASC";// echo $sql_str1;
		    $sql_res2 = mysqli_query($condb, $sql_str2); 
		    while ($sql_rec2 = mysqli_fetch_array($sql_res2)) {
		        $id       	= $sql_rec2['id'];  
		        $agent_name = $sql_rec2['agent_name'];  
		        $status  	= $sql_rec2['status'];  
		        $checkbox 	= "";

		        $check = "";
		        $sql_str12 = "SELECT a.`check` FROM cc_ts_assign a WHERE a.agent_id='$id' AND a.create_by='$v_agentid'"; 
			    $sql_res12 = mysqli_query($condb, $sql_str12); 
			    if ($sql_rec12 = mysqli_fetch_array($sql_res12)) {
			        $check       	= $sql_rec12['check']; 
			    }
			    if ($check != "") {
			    	$status =1;
			    }
			    // start new
				if ($paramcheck !=""){
					for ($x = 0; $x <= $total_check; $x++) {
						if ($id == $paramcheck[$x])
						  {
						  $status =1;
						  }
					}
				}
			    //end new
			    // $checkboxtot++;
		        if ($status == "1") {
		          	$arr_agent[] = "<div style=\"float:left;width:33%\"><label class='form-check-label'><input id='fomni_".$checkboxtot."' name='fomni_id[]' class='form-check-input' type='checkbox' value='".$id."' checked onclick=\"check_insert(this.value)\" ><span class='form-check-sign'>".$agent_name."</span></label></div>";	
			    }else {
			        $arr_agent[] = "<div style=\"float:left;width:33%\"><label class='form-check-label'><input id='fomni_".$checkboxtot."' name='fomni_id[]' class='form-check-input' type='checkbox' value='".$id."' onclick=\"check_insert(this.value)\" ><span class='form-check-sign'>".$agent_name."</span></label></div>";	
			    }
		    }

		    $arr_agent[] = "<input type='hidden' id='agt_checkboxtot' name='agt_checkboxtot' value='".$checkboxtot."' />";
	    } else {
		    $arr_agent[] = "<input type='hidden' id='agt_checkboxtot' name='agt_checkboxtot' value='0' />";
		}
	
	$aReturn['arr_agent'] = $arr_agent; 
	
	echo json_encode($aReturn);
}

else if($v=="getsubcampaign"){ 
	$cmbcamcat = get_param("cmbcamcat");
	$arr_category= array();
	$sql1 = "SELECT id,campaign_name FROM cc_campaign_prv WHERE category_id='$cmbcamcat' and `status`=1 ORDER BY campaign_name asc ";
	$res1 = mysqli_query($condb, $sql1);
	$arr_category[] = "<option value=''>-- Select --</select>";
	while($row1 = mysqli_fetch_array($res1)) {
		@extract($row1, EXTR_OVERWRITE);
		//if($call_statusid == $id) {
		//	$arr_category[] = "<option value='$id' selected>$interaction_status</option>";
		//} else {
			$arr_category[] = "<option value='$id'>$campaign_name</option>";
		//}
	}
$aReturn['arr_category'] 	    	= $arr_category; 




echo json_encode($aReturn);
}
else if($v=="gettype"){ 
	$cmbtype = get_param("cmbtype");
	$arr_category= array();
	if ($cmbtype==1) {
	//old
		//	$sql1 = "SELECT id, campaign_code, campaign_name FROM cc_campaign WHERE `status`=1 ORDER BY campaign_name asc ";
        $sql1 = "SELECT a.campaign_code, a.campaign_name, a.id FROM cc_campaign a WHERE a.spv_id = '".$v_agentid."'";
		$res1 = mysqli_query($condb, $sql1);
		$arr_category[] = "<option value=''>--To--</select>";
		while($row1 = mysqli_fetch_array($res1)) {
			@extract($row1, EXTR_OVERWRITE);
			//if($call_statusid == $id) {
			//	$arr_category[] = "<option value='$id' selected>$interaction_status</option>";
			//} else {
				$arr_category[] = "<option value='$id'>$campaign_code / $campaign_name</option>";
			//}
		}
	}else{
		// old
		//$sql1 = "select a.id,a.agent_name from cc_agent_profile a where a.agent_level = 1 order by a.agent_name ";
		$sql1 = "SELECT 
						b.id, b.agent_name
				 FROM 
				 		cc_group_agent a, 
						cc_agent_profile b
				 WHERE 
				 		a.agent_id=b.id
						AND b.`status`=1 AND b.agent_level = 1
						AND a.group_id='$v_agentgroup'";
		$res1 = mysqli_query($condb, $sql1);
		$arr_category[] = "<option value=''>--To--</select>";
		while($row1 = mysqli_fetch_array($res1)) {
			@extract($row1, EXTR_OVERWRITE);
			//if($call_statusid == $id) {
			//	$arr_category[] = "<option value='$id' selected>$interaction_status</option>";
			//} else {
				$arr_category[] = "<option value='$id'>$agent_name</option>";
			//}
		}
	}
	
$aReturn['arr_category'] 	    	= $arr_category; 




echo json_encode($aReturn);
}
else if($v=="call_status_apr"){ 
		$call_statusid = get_param("call_statusid");
	    $arr_category= array();
        $sql1 = "SELECT id, interaction_status 
											  FROM cc_ts_interaction_status_prv_apr
											  WHERE call_status='$call_statusid'
											  ORDER BY interaction_status ASC ";
		$res1 = mysqli_query($condb, $sql1);
		$arr_category[] = "<option value=''>-- Select --</select>";
		while($row1 = mysqli_fetch_array($res1)) {
			@extract($row1, EXTR_OVERWRITE);
			//if($call_statusid == $id) {
			//	$arr_category[] = "<option value='$id' selected>$interaction_status</option>";
			//} else {
				$arr_category[] = "<option value='$id'>$interaction_status</option>";
			//}
		}
	$aReturn['arr_category'] 	    	= $arr_category; 


	
	
	echo json_encode($aReturn);
}else if($v=="wsearch"){
		$searchid = get_param("searchid");

	    $check = "";
		$sql_str13 = "SELECT a.`check` FROM cc_ts_assign a WHERE a.agent_id='$searchid' AND a.create_by='$v_agentid'"; 
		$sql_res13 = mysqli_query($condb, $sql_str13); 
		if ($sql_rec13 = mysqli_fetch_array($sql_res13)) {
			$check       	= $sql_rec13['check']; 
			if ($check != "") {
				$check = "";
			}else{
				$check = "checked";
			}
			$sqldel = "DELETE FROM cc_ts_assign WHERE agent_id='$searchid' AND create_by='$v_agentid'";//echo "string $sqldel";
        	mysqli_query($condb,$sqldel);
		}else{
			$check = "checked";
		}

		$sqlin = "INSERT INTO cc_ts_assign SET
                  agent_id        = '$searchid',
                  `check`         = '$check',
                  create_by       = '$v_agentid'";  //echo "string $sqlin";
        mysqli_query($condb,$sqlin);
			 
}else if($v=="call_status_dukcapil"){ 
		$status_dukcapil = get_param("status_dukcapil");
	    $arr_category= array();
	    if ($status_dukcapil==1) {
	    	$sql1 = "SELECT id, call_status FROM cc_ts_call_status ORDER BY call_status ASC ";
	    }else{
	    	$sql1 = "SELECT id, call_status FROM cc_ts_call_status WHERE id > 2 ORDER BY call_status ASC ";
	    }
        
		$res1 = mysqli_query($condb, $sql1);
		$arr_category[] = "<option value=''>-- Select --</select>";
		while($row1 = mysqli_fetch_array($res1)) {
			@extract($row1, EXTR_OVERWRITE);
			//if($call_statusid == $id) {
			//	$arr_category[] = "<option value='$id' selected>$interaction_status</option>";
			//} else {
				$arr_category[] = "<option value='$id'>$call_status</option>";
			//}
		}
	$aReturn['arr_status_call_dukcapil'] 	    	= $arr_category; 


	
	
	echo json_encode($aReturn);
}else if($v=="cek_consumer_detail"){ 
		$iddet = get_param("iddet");

	    $sql1 = "SELECT * FROM cc_ts_consumer_detail WHERE id='$iddet' ";
		$res1 = mysqli_query($condb, $sql1);
		if($row1 = mysqli_fetch_array($res1)) {
			@extract($row1, EXTR_OVERWRITE);
				$aReturn['nik_ktp']     			= $two_nik_ktp;
				$aReturn['religion']     			= $two_cust_religion;
				$aReturn['tempat_lahir']     		= $two_tempat_lahir;
				$aReturn['tanggal_lahir']     		= $two_tanggal_lahir;
				$aReturn['nama_pasangan']     		= $two_nama_pasangan;
				$aReturn['tanggal_lahir_pasangan']  = $two_tanggal_lahir_pasangan;
				$aReturn['legal_alamat']     		= $two_legal_alamat;
				$aReturn['legal_rt']     			= $legal_rt;
				$aReturn['legal_rw']     			= $legal_rw;
				$aReturn['legal_provinsi']     		= $two_legal_provinsi;
				$aReturn['legal_kabupaten']     	= $two_legal_kabupaten;
				$aReturn['legal_kecamatan']     	= $two_legal_kecamatan;
				$aReturn['legal_kelurahan']     	= $two_legal_kelurahan;
				$aReturn['legal_kodepos']    	 	= $two_legal_kodepos;
				$aReturn['profession_name']     	= $two_profession_name;
				$aReturn['profession_cat_name']     = $two_profession_cat_name;
				$aReturn['job_position']     		= $two_job_position;
				$aReturn['industry_type_name']     	= $two_industry_type_name;
				$aReturn['survey_alamat']     		= $two_surv_addr;
				$aReturn['survey_rt']     			= $two_surv_rt;
				$aReturn['survey_rw']     			= $two_surv_rw;
				$aReturn['survey_provinsi']     	= $two_surv_province;
				$aReturn['survey_kabupaten']     	= $two_surv_kab;
				$aReturn['survey_kecamatan']     	= $two_surv_kec;
				$aReturn['survey_kelurahan']     	= $two_surv_kel;
				$aReturn['survey_kodepos']     		= $two_surv_zip;
				$aReturn['survey_sub_kodepos']     	= $two_surv_subzip;
				$aReturn['mobile_1']     			= $two_surv_mphon1;
				$aReturn['mobile_2']     			= $two_surv_mphon2;
				$aReturn['phone_1']     			= $two_surv_phon1;
				$aReturn['phone_2']     			= $two_surv_phon2;
				$aReturn['office_phone_1']     		= $two_surv_jphon1;
				$aReturn['office_phone_2']     		= $two_surv_jphon2; 
		}

	echo json_encode($aReturn);
}

else if($v=="transtospv"){ 
	$spvagent = get_param("spvagent");
	$arr_category= array();

					// cc_campaign a
        $sql1 = "SELECT 
						a.campaign_code, a.campaign_name, a.id, a.spv_id  
					FROM 
						cc_ts_penawaran_campaign a
					WHERE 
						a.`status`=1
						AND (a.spv_id=0 or a.spv_id='$spvagent')";
		$res1 = mysqli_query($condb, $sql1);
		$arr_category[] = "<option value=''>--To--</select>";
		while($row1 = mysqli_fetch_array($res1)) {
			@extract($row1, EXTR_OVERWRITE);
			//if($call_statusid == $id) {
			//	$arr_category[] = "<option value='$id' selected>$interaction_status</option>";
			//} else {
				//$arr_category[] = "<option value='$id'>$campaign_code / $campaign_name</option>";
			//}
			if($spv_id==$spvagent){
				$chek = "checked";
				$das  = "onclick='return false;' ";
			}else{
				$chek = "";
				$das  = "";
			}
			echo "<div style=\"float:left;width:70%; margin-left:30px;\"><label class='form-check-label'><input id='fomni_".$id."' name='campaignid[]' $chek $das class='form-check-input' type='checkbox' value='".$id."' onclick=\"check_insert(this.value)\" ><span class='form-check-sign'>&nbsp;&nbsp;".$campaign_code." / ".$campaign_name."</span></label></div>";	
          
		}
	
	
//$aReturn['arr_category'] 	    	= $arr_category; 




//echo json_encode($aReturn);
}
else if($v=="pro_offering"){ 
	$pro_offering = get_param("pro_offering");
	$arr_category= array();
	$sql1 = "SELECT a.*, b.offering_code_30,b.offering_code_120, b.is_active, 
			if(a.prod_offering_code LIKE '%30%',if(b.offering_code_30 IS NULL , a.prod_offering_code,b.offering_code_30),if(b.offering_code_120 IS NULL , a.prod_offering_code,b.offering_code_120)) AS off_code
			FROM cc_prod_offering a
			LEFT JOIN cc_master_mapping_product_mtr b ON if(a.prod_offering_code LIKE '%30%',a.prod_offering_code=b.offering_code_30, a.prod_offering_code=b.offering_code_120)
			WHERE a.id='$pro_offering' AND a.status='1' ORDER BY b.is_active DESC LIMIT 1";
	$res1 = mysqli_query($condb, $sql1);
	$arr_category[] = "<option value=''>-- Select --</select>";
	if($row1 = mysqli_fetch_array($res1)) {
		@extract($row1, EXTR_OVERWRITE);
		//if($call_statusid == $id) {
		//	$arr_category[] = "<option value='$id' selected>$interaction_status</option>";
		//} else {
		if ($is_active == '') {
			$param_offering = "bypass|$off_code";
		}else if($is_active == 1){
			$param_offering = "suksses|$off_code|$offering_code_120";
		}else{
			$param_offering = "gagal|$off_code|$prod_offering_name";
		}
		//}
	}




echo json_encode($param_offering);
}
else if($v=="mlob"){ 
	$mlob = get_param("mlob");
	$arr_category= array();
	$sql1 = "SELECT a.id, a.prod_offering_code, a.prod_offering_name, b.lob_name FROM cc_prod_offering a
			 LEFT JOIN cc_ts_lob b ON a.prod_offering_code=b.prod_offering_code
			 WHERE b.lob_code='$mlob' AND a.status='1'
			 GROUP BY a.prod_offering_code";
	$res1 = mysqli_query($condb, $sql1);
	$arr_category[] = "<option value=''>-- Select --</select>";
	while($row1 = mysqli_fetch_array($res1)) {
		@extract($row1, EXTR_OVERWRITE);
		//if($call_statusid == $id) {
		//	$arr_category[] = "<option value='$id' selected>$interaction_status</option>";
		//} else {
			$arr_category[] = "<option value='$prod_offering_code'>".$prod_offering_code."/".$prod_offering_name."</option>";
		//}
			$lob_name = $lob_name;
	}
	$aReturn['arr_category'] 	    	= $arr_category; 
	$aReturn['lob_name'] 	    	= $lob_name; 
	$aReturn['lob_name2']           = "<option value='528'>SUPPLIER DUMMY</option>";




	echo json_encode($aReturn);
}

else if($v=="pro_offering2"){ 
	$pro_offering = get_param("pro_offering");

	$sql1 = "SELECT a.id, a.prod_offering_code, a.prod_offering_name FROM cc_prod_offering a
			 WHERE a.prod_offering_code='$pro_offering'
			 GROUP BY a.prod_offering_code";
	$res1 = mysqli_query($condb, $sql1);
	while($row1 = mysqli_fetch_array($res1)) {
		@extract($row1, EXTR_OVERWRITE);
		//if($call_statusid == $id) {
		//	$arr_category[] = "<option value='$id' selected>$interaction_status</option>";
		//} else {
			$prod_offering_name = $prod_offering_name;
		//}
	}

  if (strpos($prod_offering_name, 'SPESIAL CASH')) { 
      $aReturn="1";
  }else{
    $aReturn="0";
  }

echo $aReturn;
}

else if($v=="pro_offering2_api"){ 
	$pro_offering = get_param("pro_offering");
	$or_office = get_param("or_office");

	$sql1 = "SELECT a.id, a.prod_offering_code, a.prod_offering_name FROM cc_prod_offering a
			 WHERE a.prod_offering_code='$pro_offering'
			 GROUP BY a.prod_offering_code";
	$res1 = mysqli_query($condb, $sql1);
	while($row1 = mysqli_fetch_array($res1)) {
		@extract($row1, EXTR_OVERWRITE);
		//if($call_statusid == $id) {
		//	$arr_category[] = "<option value='$id' selected>$interaction_status</option>";
		//} else {
			$prod_offering_name = $prod_offering_name;
		//}
	}

  if (strpos($prod_offering_name, 'SPESIAL CASH')) { 
      $aReturn="1";
  } else {
    $aReturn="0";
  }

  $totalData = 0;
  $arr_tenor = array();

  $link = "https://10.0.89.214:8443/api/Engine/GetTenorByProductOffering?poOfficeCode=".$or_office."&productOfferingCode=".$pro_offering;
  
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $link);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	$result = curl_exec($ch); 
	$obj = json_decode($result, true);

	$responseCode       = $obj['responseCode']; // sukses = 00
	$responseMessage    = $obj['responseMessage']; // sukses = Success
	$errorMessage       = $obj['errorMessage'];
	$responData         = $obj['data'];
	curl_close($ch);

	if($responseCode == "00") {
        $totalData = COUNT($responData);
		foreach ($responData as $key => $value) {
            $arr_tenor[] = "<option value='$value'>".$value."</option>";
        }
	}
    if($totalData == 0) {
        $arr_tenor[] = "<option value='0'>0</option>";
    }

	$aResponse['param_pro_offering'] = $aReturn; 
	$aResponse['three_tenor_api'] = $arr_tenor; 
	$aResponse['link_api'] = $link; 
	echo json_encode($aResponse);
}

else if($v=="otr_api"){ 
	$otr_office = get_param("otr_office");
	$otr_asset = get_param("otr_asset");
	$otr_year = get_param("otr_year");

	
  $data_otr = "0";
  $otr_asset = str_replace(' ', '%20', $otr_asset);
  $link = "https://10.0.89.214:8443/api/Pengajuan/GetOTRByOfficeCodeAndAssetCodeAndManufYear?officeCode=".$otr_office."&assetCode=".$otr_asset."&manufYear=".$otr_year;
  
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $link);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	$result = curl_exec($ch); 
	$obj = json_decode($result, true);

	$responseCode       = $obj['responseCode']; // sukses = 00
	$responseMessage    = $obj['responseMessage']; // sukses = Success
	$errorMessage       = $obj['errorMessage'];
	$responData         = $obj['data'];
	curl_close($ch);

	if($responseCode == "00") {
		foreach ($responData as $key => $value) {
            if($key == "marketPrice") {
                $data_otr = $value;
                $data_otr = sprintf('%0.2f', $data_otr);
            }
        }
	}

	$aResponse['data_otr'] = $data_otr; 
	$aResponse['link_api'] = $link; 
	echo json_encode($aResponse);
}

else if($v=="pro_offering3"){ 
	$pro_offering = get_param("pro_offering");

	$sql1 = "SELECT a.id, a.prod_offering_code, a.prod_offering_name FROM cc_prod_offering a
			 WHERE a.prod_offering_code='$pro_offering'
			 GROUP BY a.prod_offering_code";
	$res1 = mysqli_query($condb, $sql1);
	while($row1 = mysqli_fetch_array($res1)) {
		@extract($row1, EXTR_OVERWRITE);
		//if($call_statusid == $id) {
		//	$arr_category[] = "<option value='$id' selected>$interaction_status</option>";
		//} else {
			$prod_offering_name = $prod_offering_name;
		//}
	}

  if (strpos($prod_offering_name, 'SPESIAL CASH')) { 
      $aReturn="1";
  }else{
    $aReturn="0";
  }

echo $aReturn;
}

else if($v=="get_prov"){

	// kabupaten
	$arr_category= array();
	$sql1 = "SELECT * FROM cc_master_alamat WHERE is_active=1 GROUP BY city";
	$res1 = mysqli_query($condb, $sql1);
	$arr_category[] = "<option value='' selected>-- Select --</select>";
	while($row1 = mysqli_fetch_array($res1)) {
		@extract($row1, EXTR_OVERWRITE);
		$arr_category[] = "<option value='$city'>".$city."</option>";
	}
	$aReturn['arr_category'] 	= $arr_category; 
	$aReturn['arr_category2'] 	= "<option value='' selected>-- Select --</select>"; 

	echo json_encode($aReturn);


}
else if($v=="get_kecamatan"){
	$city = get_param("city");
	$arr_category= array();
	$sql1 = "SELECT a.id, a.kecamatan FROM cc_master_alamat a WHERE a.city='$city' AND a.is_active=1 GROUP BY a.kecamatan";
	$res1 = mysqli_query($condb, $sql1);
	$arr_category[] = "<option value='' selected>-- Select --</select>";
	while($row1 = mysqli_fetch_array($res1)) {
		@extract($row1, EXTR_OVERWRITE);
		$arr_category[] = "<option value='$kecamatan'>".$kecamatan."</option>";
	}
	$aReturn['arr_category'] 	= $arr_category; 

	echo json_encode($aReturn);


}
else if($v=="get_kelurahan"){
	$city = get_param("city");
	$kecamatan = get_param("kecamatan");
	$arr_category= array();
	$sql1 = "SELECT a.id, a.kelurahan FROM cc_master_alamat a WHERE a.city='$city' AND a.kecamatan='$kecamatan' AND a.is_active=1 GROUP BY a.kelurahan";
	$res1 = mysqli_query($condb, $sql1);
	$arr_category[] = "<option value='' selected>-- Select --</select>";
	while($row1 = mysqli_fetch_array($res1)) {
		@extract($row1, EXTR_OVERWRITE);
		$arr_category[] = "<option value='$kelurahan'>".$kelurahan."</option>";
	}
	$aReturn['arr_category'] 	= $arr_category; 

	echo json_encode($aReturn);


}
else if($v=="get_zipcode_survey"){
	$city = get_param("city");
	$kecamatan = get_param("kecamatan");
	$kelurahan = get_param("kelurahan");
	$arr_category= array();
	$sql1 = "SELECT a.id, a.zipcode FROM cc_master_alamat a WHERE a.city='$city' AND a.kecamatan='$kecamatan' AND a.kelurahan='$kelurahan' AND a.is_active=1 GROUP BY a.zipcode";
	$res1 = mysqli_query($condb, $sql1);
	$arr_category[] = "<option value='' selected>-- Select --</select>";
	while($row1 = mysqli_fetch_array($res1)) {
		@extract($row1, EXTR_OVERWRITE);
		$arr_category[] = "<option value='$zipcode'>".$zipcode."</option>";
	}
	$aReturn['arr_category'] 	= $arr_category; 

	echo json_encode($aReturn);


}
else if($v=="get_subzipcode_survey"){
	$city = get_param("city");
	$kecamatan = get_param("kecamatan");
	$kelurahan = get_param("kelurahan");
	$zipcode = get_param("zipcode");
	$arr_category= array();
	$sql1 = "SELECT a.id, a.sub_zipcode FROM cc_master_alamat a WHERE a.city='$city' AND a.kecamatan='$kecamatan' AND a.kelurahan='$kelurahan' AND a.zipcode='$zipcode' AND a.is_active=1 GROUP BY a.sub_zipcode";
	$res1 = mysqli_query($condb, $sql1);
	// $arr_category[] = "<option value='' selected>-- Select --</select>";
	while($row1 = mysqli_fetch_array($res1)) {
		@extract($row1, EXTR_OVERWRITE);
		$arr_category[] = $sub_zipcode;
	}
	$aReturn['arr_category'] 	= $arr_category; 

	echo json_encode($aReturn);


}

//new


else if($v=="asset1"){ 
	$asset_type = get_param("asset_type");
	$arr_category= array();
	$sql1 = "SELECT * from cc_master_merk a 
										join cc_master_type_asset b on a.asset_type_id = b.asset_type_id 
										where b.asset_type_code ='$asset_type' ";
	$res1 = mysqli_query($condb, $sql1);
	$arr_category[] = "<option value=''>-- Select --</select>";
	while($row1 = mysqli_fetch_array($res1)) {
		@extract($row1, EXTR_OVERWRITE);
		//if($call_statusid == $id) {
		//	$arr_category[] = "<option value='$id' selected>$interaction_status</option>";
		//} else {
			$arr_category[] = "<option value='$asset_hierarchy_l1_code' data-label='$asset_hierarchy_l1_code'>$asset_hierarchy_l1_code / $asset_hierarchy_l1_name</option>";
		//}
	}
$aReturn['arr_category'] 	    	= $arr_category; 
$aReturn['arr_category2'] 	    	= "<option value=''>-- Select --</select>";




echo json_encode($aReturn);
}


else if($v=="asset2"){ 
	$asset_type_desc = get_param("asset_type_desc");
	$arr_category= array();
	$sql1 = "SELECT
										b.asset_type_code, #asset_type
										b.asset_type_name, #asset_type
										a.asset_hierarchy_l1_code, 
										a.asset_hierarchy_l1_name,
										c.asset_code , c.asset_name,
                                        c.asset_full_name,
										d.asset_category_code, 
										d.asset_category_name,
										e.asset_hierarchy_l2_code,
										e.asset_hierarchy_l2_name 
										FROM cc_master_merk a 
										join cc_master_type_asset b on a.asset_type_id = b.asset_type_id 
										join cc_master_kendaraan c on c.asset_hierarchy_l1_id = a.asset_hierarchy_l1_id 
										join cc_master_kategori_kendaraan d on c.asset_category_id = d.asset_category_id 
										join cc_master_merk_group e on e.asset_hierarchy_l2_id = c.asset_hierarchy_l2_id 
										where a.asset_hierarchy_l1_code ='$asset_type_desc'";
	$res1 = mysqli_query($condb, $sql1);
	$arr_category[] = "<option value=''>-- Select --</select>";
	while($row1 = mysqli_fetch_array($res1)) {
		@extract($row1, EXTR_OVERWRITE);
		//if($call_statusid == $id) {
		//	$arr_category[] = "<option value='$id' selected>$interaction_status</option>";
		//} else {
			$arr_category[] = "<option value='$asset_code' data-label='$asset_code'>$asset_code / $asset_name / $asset_full_name</option>";
		//}
	}
$aReturn['arr_category'] 	    	= $arr_category; 




echo json_encode($aReturn);
}

else if($v=="asset3"){ 
	$asset_desc = get_param("asset_desc");
	$arr_category= array();
	$sql1 = "SELECT
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
										where c.asset_code ='$asset_desc'";
	$res1 = mysqli_query($condb, $sql1);
	// $arr_category[] = "<option value=''>-- Select --</select>";
	if($row1 = mysqli_fetch_array($res1)) {
		@extract($row1, EXTR_OVERWRITE);
		//if($call_statusid == $id) {
		//	$arr_category[] = "<option value='$id' selected>$interaction_status</option>";
		//} else {
			// $arr_category[] = "<option value='$asset_code' data-label='$asset_code'>$asset_code / $asset_name</option>";
    	$model_kendaraan      = $asset_hierarchy_l2_code." - ".$asset_hierarchy_l2_name;
    	$kategori_kendaraan   = $asset_category_code." - ".$asset_category_name;
		//}
	}
$aReturn['arr_model'] 	    	= $model_kendaraan; 
$aReturn['arr_kategori'] 	    = $kategori_kendaraan; 




echo json_encode($aReturn);
}

else if($v=="get_dealer"){ 
	$kabupaten = get_param("city");
	$sql_whr.="AND LOWER(suppl_city) like LOWER('%$kabupaten%')";

	$sql_str1 = "SELECT id, suppl_name FROM cc_master_supplier WHERE 1=1 $sql_whr"; //echo "string". $sql_str1;
	$sql_res1  = execSQL($condb, $sql_str1);
	$sel = "<option value=\"\" selected>-- Select --</option>";
	while ($sql_rec1 = mysqli_fetch_array($sql_res1)) {
		$sel .= "<option value=\"".$sql_rec1['id']."\" >".$sql_rec1['suppl_name']."</option>";
	}

	$aReturn['query'] 			= $sql_str1;
	$aReturn['arr_category'] 	= $sel;

	echo json_encode($aReturn);
}else if($v=="get_cabang_by_region"){
    $v_agentid = get_session('v_agentid');
    $region_code = get_param("region_code");
    $branch_name = get_param("branch_name");
    $where_region = "";
    $i=0;

    $isarray = explode(",", $branch_name);
    $data[] = "";
    foreach ($isarray as $key => $value) {
        $data[$value] = $value;
    }


    if($region_code == "0" || $region_code ==""){
      $where_region .= "";
    }else{
      $isarray_region = explode(",", $region_code);
      foreach ($isarray_region as $key => $res) {
          if($i == 0){
	  	$where_region .= "'".$res."'";
	  }else{
		$where_region .= ",'".$res."'";
	  }
	$i++;
      }
      $where_region != "" ? $where_region = " AND d.region_code IN (".$where_region.") ":0;
	
    }

    //$sel = "<SELECT id=\"$id\" name=\"$name\" class=\"select2 form-control\" multiple=\"multiple\" style=\"width:100%;\" \"$required\">";
    $sel = "";
    if($data[0] == "0") {
      $sel .= "<option value=\"0\" selected>ALL</option>";  
    } else {
      $sel .= "<option value=\"0\">ALL</option>";
    } 
    $sql_str1 = "select a.office_code , a.office_name  from cc_master_cabang a
		join cc_master_area b on a.ref_office_area_id = b.area_id 
		join cc_master_office_region_mbr c on c.ref_office_area_id=b.area_id 
		join cc_master_region d on d.region_id =c.office_region_x_id
		where 1=1 $where_region";//a.assign_to=69 OR  (a.assign_to='$v_agentid' OR a.assign_to=0) AND 
    $sql_res1  = execSQL($condb, $sql_str1);
    while ($sql_rec1 = mysqli_fetch_array($sql_res1)) {
      $sid = $sql_rec1['office_name'];
      if($sid == $data[$sid]) {
        $sel .= "<option value=\"".$sql_rec1['office_code']."\" selected>".$sql_rec1['office_name']."</option>";  
      } else {
        $sel .= "<option value=\"".$sql_rec1['office_code']."\" >".$sql_rec1['office_name']."</option>";  

      }
    }
//        $sel .= "<option value=\"".$sql_str1."\" >".$sql_str1."</option>";  
    //$sel .= "</SELECT>";
	$aReturn["query"] = $sql_str1;
	$aReturn["arr_category"] = $sel;

//    return $sel;
echo json_encode($aReturn);

}else if($v=="get_kabupaten"){
    $sel = "";
    $sel .= "<option value=\"0\" selected>Select Kabupaten</option>";
    $prov = get_param("prov");

    if($prov == "" || $prov == "0"){
    	$sql_kabupaten = "SELECT * FROM cc_master_alamat WHERE is_active=1 GROUP BY city";
		$res_kabupaten = mysqli_query($condb, $sql_kabupaten);
    	while($row = mysqli_fetch_array($res_kabupaten)){
			// if (strtolower($row["city"]) == strtolower($txt_legal_kab) && $txt_legal_kab != "") {
				// echo "<option value='".$row["city"]."' selected>".$row["city"]."</option>";
			// }else{
				$sel .= "<option value='".$row["city"]."'>".$row["city"]."</option>";
			// }
		}
		mysqli_free_result($res_kabupaten);
    }else{

		$sql_legal_kab0 = "SELECT b.ref_name AS dis, b.ref_prov_district_id as id, b.ref_name
				FROM 
				cc_master_ref_prov_district a
				JOIN cc_master_ref_prov_district b ON b.parent_id=a.ref_prov_district_id AND b.is_active=1 AND b.ref_type='DIS'
				WHERE 1=1 
				AND a.ref_name='$prov'
				GROUP BY a.ref_name, b.ref_prov_district_id
				ORDER BY b.ref_name";
		$res_legal_kab0 = mysqli_query($condb, $sql_legal_kab0);
		$arr_legal_kab0 = mysqli_fetch_all($res_legal_kab0);
		$iddes_legal_kab0 =  implode(',', array_map(function ($entry) {
		                        return $entry[1];
		                      }
		                    , $arr_legal_kab0 ));
		mysqli_free_result($arr_legal_kab0);

		// print_r($iddes);
		$sql_legal_kab = "SELECT a.city as city
				FROM cc_master_alamat a 
				WHERE a.ref_prov_district_id IN ($iddes_legal_kab0) AND a.is_active=1 GROUP BY a.city ORDER BY a.city ASC";
		$res_legal_kab = mysqli_query($condb, $sql_legal_kab);
		while($row=mysqli_fetch_array($res_legal_kab)){
			// if (strtolower($row["province_name"]) == strtolower($txt_legal_prov)) {
				$sel .= "<option value='".$row["city"]."'>".$row["city"]."</option>";
			// }else{
				// echo "<option value='".$row["province_name"]."'>".$row["province_name"]."</option>";
			// }
		}
		mysqli_free_result($res_legal_kab);
    }

	$aReturn["query"] = $sql_legal_kab;
	$aReturn["arr_category"] = $sel;
	echo json_encode($aReturn);
}

disconnectDB($condb);
?>
