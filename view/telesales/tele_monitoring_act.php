<?php 
 include "../../sysconf/global_func.php";
 include "../../sysconf/session.php";
 include "../../sysconf/db_config.php";
 // include "global_func_cc.php";
 $condb = connectDB();
 
 $v_agentid      = get_session("v_agentid");
 $v_agentlevel   = get_session("v_agentlevel");
 
 $v_skillnya 	    = get_session("v_skillnya");
 $agentname         = get_session("v_agentname");
 $v_agentname		= get_session("v_agentname");
 $v_agentemail		= get_session("v_agentemail");
 $v_agentlogin		= get_session("v_agentlogin");

 $cmbbucket         = get_param("cmbbucket");
 $cmbspvid          = get_param("cmbspvid");
 $cmbagentid        = get_param("cmbagentid");
 $cmbcallstatus     = get_param("cmbcallstatus");

 $fltb ="";
 $flts ="";
 $flta ="";
 $fltc ="";
 
$params ="?sess=".date('YmdHis');
if($cmbbucket != ''){
    $fltb = " AND a.campaign_id='$cmbbucket' ";
    $params .= "&bucket_id=".$cmbbucket;
} else {
    $params .= "&bucket_id=";
}

if($cmbspvid!=''){
    $agent_id = 0;
    $sql = "SELECT a.agent_id FROM cc_group_leader a WHERE a.group_id = '".$cmbspvid."'"; //echo $sqlps;
    $res = mysqli_query($condb, $sql);
    while($rec = mysqli_fetch_array($res)){
        $agent_id = $rec['agent_id'];
    }
    $flts = " AND a.spv_id='".$agent_id."' ";
    $params .= "&spv_id=".$agent_id;

} else {
    // $params .= "&spv_id=";
    if($v_agentlevel==2){
        $flts = " AND a.spv_id='".$v_agentid."' ";
        $params .= "&spv_id=".$v_agentid;
    }else if($v_agentlevel==1){
        $flts = " AND a.agent_id='".$v_agentid."' ";
        $params .= "&agent_id=".$v_agentid;
    }
    
}

if($cmbagentid!=''){
    $flta = " AND a.agent_id='$cmbagentid' ";
    $params .= "&agent_id=".$cmbagentid;
} else {
    $params .= "&agent_id=";
}

if($cmbcallstatus!=''){
    $fltc = " AND a.call_status='$cmbcallstatus' "; 
    $params .= "&last_phonecall=".$cmbcallstatus;
} else {
    $params .= "&last_phonecall=";
}
 
 $call_prospect   =0;
 $call_interest   =0;
 $call_notinterest=0;
 $call_followup   =0;
 $call_uncontacted=0;
 $call_unconnected=0;
 $call_new        =0;
 $sqlps = "SELECT a.call_status AS last_phonecall,
                c.call_status,
                COUNT(a.id) AS jusm
          FROM 
                cc_ts_penawaran a
                LEFT OUTER JOIN cc_ts_call_status c ON a.call_status=c.id, 
                cc_ts_penawaran_campaign b
           WHERE 
                b.id=a.campaign_id $fltb $flts $flta $fltc
           GROUP BY c.id"; //echo $sqlps;
 $resps = mysqli_query($condb,$sqlps);
 while($recps = mysqli_fetch_array($resps)){
     $call_status      = $recps['last_phonecall'];
     $call_jum         = $recps['jusm'];
     if($call_status==1){
        $call_prospect = $call_jum;
     }else if($call_status==2){
        $call_interest = $call_jum;
     }else if($call_status==3){
        $call_notinterest = $call_jum;
     }else if($call_status==4){
        $call_followup = $call_jum;
     }else if($call_status==5){
        $call_uncontacted = $call_jum;
     }else if($call_status==6){
        $call_unconnected = $call_jum;
     }else{
         $call_new  = $call_jum;
     }
 }

 ?>
 <style>
.table td {
    padding: 0px !important;
}

@media(max-width: 575px) {
    div.dataTables_wrapper div.dataTables_paginate ul.pagination {
        justify-content: center;
        flex-wrap: wrap;
    }
}
</style>
<div class="row">
           <div class="col-sm-6 col-lg-3">
							<div class="card p-3">
								<div class="d-flex align-items-center">
									<span class="stamp stamp-md bg-secondary mr-3">
										<i class="fas fa-address-card"></i>
									</span>
									<div>
										<h5 class="mb-1"><b><a href="#"><?php echo $call_prospect;?></a></b></h5>
										<small class="text-muted"><b>Prospek</b></small>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-3">
							<div class="card p-3">
								<div class="d-flex align-items-center">
									<span class="stamp stamp-md bg-success mr-3">
										<i class="fas fa-calendar-check"></i>
									</span>
									<div>
										<h5 class="mb-1"><b><a href="#"><?php echo $call_interest;?></a></b></h5>
										<small class="text-muted"><b>Interest</b></small>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-3">
							<div class="card p-3">
								<div class="d-flex align-items-center">
									<span class="stamp stamp-md bg-warning mr-3">
										<i class="fas fa-phone-slash"></i>
									</span>
									<div>
										<h5 class="mb-1"><b><a href="#"><?php echo $call_unconnected;?> </a></b></h5>
										<small class="text-muted"><b>UnConnected</b></small>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-3">
							<div class="card p-3">
								<div class="d-flex align-items-center">
									<span class="stamp stamp-md bg-primary mr-3">
										<i class="fas fa-phone"></i>
									</span>
									<div>
										<h5 class="mb-1"><b><a href="#"><?php echo $call_followup;?></a></b></h5>
										<small class="text-muted"><b>FollowUp</b></small>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-sm-6 col-lg-3">
							<div class="card p-3">
								<div class="d-flex align-items-center">
									<span class="stamp stamp-md bg-secondary mr-3">
										<i class="fas fa-user-edit"></i>
									</span>
									<div>
										<h5 class="mb-1"><b><a href="#"><?php echo $call_new;?> </a></b></h5>
										<small class="text-muted"><b>New</b></small>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-sm-6 col-lg-3">
							<div class="card p-3">
								<div class="d-flex align-items-center">
									<span class="stamp stamp-md bg-danger mr-3">
										<i class="fas fa-user-slash"></i>
									</span>
									<div>
										<h5 class="mb-1"><b><a href="#"><?php echo $call_notinterest;?></a></b></h5>
										<small class="text-muted"><b>Not Interest</b></small>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-sm-6 col-lg-3">
							<div class="card p-3">
								<div class="d-flex align-items-center">
									<span class="stamp stamp-md bg-warning mr-3">
										<i class="fas fa-user-times"></i>
									</span>
									<div>
										<h5 class="mb-1"><b><a href="#"><?php echo $call_uncontacted;?></a></b></h5>
										<small class="text-muted"><b>UnAnswer</b></small>
									</div>
								</div>
							</div>
						</div>
</div>

<div class="table-responsive">
            <table id="datatablelist" class="table table-head-bg-success">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Campaign</th>
                    <th scope="col">Customer ID</th>
                    <th scope="col">Agreement No</th>
                    <th scope="col">Nama Konsumen</th>
                    <th scope="col">Assign SPV</th>
                    <th scope="col">Last Assigned</th>
                    <th scope="col">Last Called Date</th>
                    <th scope="col">Last Status Call</th>
                    <th scope="col">Last Sub Status Call</th>
                    <th scope="col">Last Called By</th>
                    <th scope="col">Opsi Penanganan</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <!-- <button class="btn btn-success" onclick="downloadexcel();return false;">Download Excel</button> -->
</div>

<div class="modal fade bd-example-modal-lg " id="modal_history" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" role="document" style="border: 2px solid black;border-radius:10px 10px 0px 0px; "> <!-- <?php echo $master_borderdominant_color ?> -->
        <div class="modal-content" class="border border-primary">
            <div class="modal-header" style="background:black;color:white"> <!-- <?php echo $dominant_mastercolor ?> -->
            <h4 class="modal-title" id="myModalLabel4">History Call</h4>
            </div>
            <div class="modal-body" style="background:white">
            <!-- add assets -->
            <div id="historydiv">&nbsp;</div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php 	
disconnectDB($condb);
?>
<script src="assets/js/core/jquery.3.2.1.min.js"></script>
<script src="assets/js/atlantis.min.js"></script>
<!-- <script src="assets/js/plugin/datatables/datatables.min.js"></script> -->
    
<script type="text/javascript" src="assets/report/vendors/js/ui/jquery.sticky.js"></script>
<script src="assets/report/vendors/js/tables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="assets/report/vendors/js/tables/datatable/dataTables.bootstrap4.min.js" type="text/javascript"></script>
<script src="assets/report/vendors/js/tables/datatable/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="assets/report/vendors/js/tables/datatable/buttons.bootstrap4.min.js" type="text/javascript"></script>
<script src="assets/report/vendors/js/tables/jszip.min.js" type="text/javascript"></script>
<script src="assets/report/vendors/js/tables/pdfmake.min.js" type="text/javascript"></script>
<script src="assets/report/vendors/js/tables/vfs_fonts.js" type="text/javascript"></script>
<script src="assets/report/vendors/js/tables/buttons.html5.min.js" type="text/javascript"></script>
<script src="assets/report/vendors/js/tables/buttons.print.min.js" type="text/javascript"></script>
<script src="assets/report/vendors/js/tables/buttons.colVis.min.js" type="text/javascript"></script>

<script>
    $('.dt-buttons').css('text-align', 'right');
    $('.dt-buttons').addClass('text-right');
// $(document).ready(function() {
    var table = $('#datatablelist').DataTable({
    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, 100]],
        "info": false,
        "searching": false,
    	"bProcessing": true,
		"bServerSide": true,
        "ordering": false,
        // "aoColumnDefs" : [
        // { "bVisible": false, "aTargets": [1] },
        //   { "targets":[0,1], "className": "desktop" },
        //   { "targets":[1], "className": "tablet, mobile" },
        // { "orderable": false, "targets": [0] }],
    "sAjaxSource": "view/telesales/tele_monitoring_data.php<?=$params;?>",
    "fnServerParams": function (aoData) {
        aoData.push(
            { "name": "status", "value": $("#status").val() }
        );
    },
    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        var oSettings = $('#datatablelist').dataTable().fnSettings();
        //document.getElementById('lastPage').value = (oSettings._iDisplayStart/oSettings._iDisplayLength);
    },
    // dom: 'Bfrtip',
    dom: 'Btip',
    buttons: [
        {
            extend: 'excel',
            text: '<span class="fa fa-file-excel-o"></span> &nbsp;Excel Export',
            action: function (e, dt, node, config)
            {
                downloadexcel();//window.location.href = './ServerSide.php?ExportToCSV=Yes';
            }
        }
    ] });
     
// } );
// var oTable = $('#datatablelist').dataTable({
//     "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
//      dom: 'Bfrtip<"top"><"bottom"l><"clear">',
//      buttons: [
//         {
//             extend: 'collection',
//             text: 'Action',
//             className: 'my-1'
//         }],
//         "info": false,
//         "searching": false,
//     	"bProcessing": true,
// 		"bServerSide": true,
//         "ordering": false,
//         // "aoColumnDefs" : [
//         // { "bVisible": false, "aTargets": [1] },
//         //   { "targets":[0,1], "className": "desktop" },
//         //   { "targets":[1], "className": "tablet, mobile" },
//         // { "orderable": false, "targets": [0] }],
// 		"sAjaxSource": "view/telesales/tele_monitoring_data.php<?=$params;?>",
// 		"fnServerParams": function (aoData) {
//                 aoData.push(
//                     { "name": "status", "value": $("#status").val() }
//                 );
//             },
//         "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull) {
//             var oSettings = $('#datatablelist').dataTable().fnSettings();
//             //document.getElementById('lastPage').value = (oSettings._iDisplayStart/oSettings._iDisplayLength);
//         }
            
// });

    function downloadexcel(){
        var cmbbucket       = document.getElementById("cmbbucket").value;
        var cmbspvid        = document.getElementById("cmbspvid").value;
        var cmbagentid      = document.getElementById("cmbagentid").value;
        var cmbcallstatus   = document.getElementById("cmbcallstatus").value;

        window.open("view/telesales/tele_monitoring_down.php?cmbbucket="+cmbbucket+"&cmbspvid="+cmbspvid+"&cmbagentid="+cmbagentid+"&cmbcallstatus="+cmbcallstatus);
    }

     function frefID(kode){
        // alert(kode);
        $('#historydiv').load('view/telesales/get_history.php?type=penawaran&iddata='+kode);
        return false;
    }
</script>