<?php 
 include "../../sysconf/global_func.php";
 include "../../sysconf/session.php";
 include "../../sysconf/db_config.php";
 include "global_func_cc.php";
 $condb = connectDB();
 
 $v_agentid      = get_session("v_agentid");
 $v_agentlevel   = get_session("v_agentlevel");
 
 $v_skillnya        = get_session("v_skillnya");
 $agentname         = get_session("v_agentname");
 $v_agentname       = get_session("v_agentname");
 $v_agentemail      = get_session("v_agentemail");
 $v_agentlogin      = get_session("v_agentlogin");

 $params ="?sess=".date('YmdHis');

 $getparams = get_param("params");
    if($params != ''){
        $params .= "&params=".$getparams;
    } else {
        $params .= "&params=";
    }

//  $tregion = get_param("tregion");
//  $tbranch = get_param("tbranch");
//  $tcustname = get_param("tcustname");
//  $tcustid = get_param("tcustid");
//  $tcampaign = get_param("tcampaign");

//  $ttype = get_param("ttype");
//  $tsource = get_param("tsource");
//  $tlastagent = get_param("tlastagent");
//  $tlastcalled = get_param("tlastcalled");
//  $tlaststatus = get_param("tlaststatus");
//  $tlevel = get_param("tlevel");

// $params ="?sess=".date('YmdHis');

// if($tregion != ''){
//     $params .= "&tregion=".$tregion;
// } else {
//     $params .= "&tregion=";
// }

// if($tbranch != ''){
//     $params .= "&tbranch=".$tbranch;
// } else {
//     $params .= "&tbranch=";
// }

// if($tcustname != ''){
//     $params .= "&tcustname=".$tcustname;
// } else {
//     $params .= "&tcustname=";
// }

// if($tcustid != ''){
//     $params .= "&tcustid=".$tcustid;
// } else {
//     $params .= "&tcustid=";
// }

// if($tcampaign != ''){
//     $params .= "&tcampaign=".$tcampaign;
// } else {
//     $params .= "&tcampaign=";
// }

// if($ttype != ''){
//     $params .= "&ttype=".$ttype;
// } else {
//     $params .= "&ttype=";
// }

// if($tsource != ''){
//     $params .= "&tsource=".$tsource;
// } else {
//     $params .= "&tsource=";
// }

// if($tlastagent != ''){
//     $params .= "&tlastagent=".$tlastagent;
// } else {
//     $params .= "&tlastagent=";
// }

// if($tlastcalled != ''){
//     $params .= "&tlastcalled=".$tlastcalled;
// } else {
//     $params .= "&tlastcalled=";
// }

// if($tlaststatus != ''){
//     $params .= "&tlaststatus=".$tlaststatus;
// } else {
//     $params .= "&tlaststatus=";
// }

// if($tlevel != ''){
//     $params .= "&tlevel=".$tlevel;
// } else {
//     $params .= "&tlevel=";
// }
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

<div class="table-responsive">
            <table id="datatablelist" class="table table-head-bg-success">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Jenis Task</th>
                    <th scope="col">Region</th>
                    <th scope="col">Branch</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Cust. ID</th>
                    <th scope="col">Agreement No</th>
                    <th scope="col">Product Offering</th>
                    <th scope="col">Asset Type</th>
                    <th scope="col">Manufacturing Date</th>
                    <th scope="col">Contract Status</th>
                    <th scope="col">Go Live Date</th>
                    <th scope="col">Tenor</th>
                    <th scope="col">Customer Rating</th>
                    <th scope="col">Agreement Rating</th>
                    <th scope="col">Source</th>
                    <th scope="col">Campaign</th>
                    <th scope="col">Last Assignment to</th>
                    <th scope="col">Last Called</th>
                    <th scope="col">Last Agent Handled</th>
                    <th scope="col">Last Status Called</th>
                    <th scope="col">Last Sub Status Called</th>
                    <th scope="col">SLA Remaining in Tele</th>
                    <th scope="col">Eligible</th>
                    <th scope="col">Approval Engine Result</th>
                    <th scope="col">ODR No</th>
                    <th scope="col">APP No</th>
                    <th scope="col">Region Handling</th>
                    <th scope="col">Branch Handling</th>
                    <th scope="col">Marketing (CMO/CRO)</th>
                    <th scope="col">Waktu Submit Task Visit</th>
                    <th scope="col">Status Visit</th>
                    <th scope="col">Waktu Submit Task Survey</th>
                    <th scope="col">Status MSS</th>
                    <th scope="col">Status WISe</th>
                    <th scope="col">Priority Level</th>
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
    "sAjaxSource": "view/telesales/tele_task_inquiry_data.php<?=$params;?>",
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
    // dom: 'Btip',
    // buttons: [
    //     {
    //         extend: 'excel',
    //         text: '<span class="fa fa-file-excel-o"></span> &nbsp;Excel Export',
    //         action: function (e, dt, node, config)
    //         {
    //             downloadexcel();//window.location.href = './ServerSide.php?ExportToCSV=Yes';
    //         }
    //     }
    // ] 
});
     
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
//      "bProcessing": true,
//      "bServerSide": true,
//         "ordering": false,
//         // "aoColumnDefs" : [
//         // { "bVisible": false, "aTargets": [1] },
//         //   { "targets":[0,1], "className": "desktop" },
//         //   { "targets":[1], "className": "tablet, mobile" },
//         // { "orderable": false, "targets": [0] }],
//      "sAjaxSource": "view/teleupload/teleupl_monitoring_data.php<?=$params;?>",
//      "fnServerParams": function (aoData) {
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

        window.open("view/teleupload/teleupl_monitoring_down.php?cmbbucket="+cmbbucket+"&cmbspvid="+cmbspvid+"&cmbagentid="+cmbagentid+"&cmbcallstatus="+cmbcallstatus);
    }

     function frefID(kode){
        // alert(kode);
        // $('#historydiv').load('view/teleupload/get_history.php?iddata='+kode);
        $('#historydiv').load('view/telesales/get_history.php?type=penawaran&iddata='+kode);
        return false;
    }
</script>