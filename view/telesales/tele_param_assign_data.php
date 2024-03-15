<?php
 ###############################################################################################################
#																												#
#                   `---:/.     																				#			
#               .--.    `+h.   																					#
#            `--`         om   																					#
#          `:-   `-:-`    :M.  		___________.__                .__                  _____  __   				#
#         .:#` :ydy++y    +M`  		\_   _____/|  | ___.__.______ |  |__   ___________/ ____\/  |_ 				#
#        :.  #hm+.   /`   mh   		 |    __)_ |  |<   |  |\____ \|  |  \ /  ___/  _ \   __\\   __\				#
#       :`  +Ns`     /   oN-   		 |        \|  |_\___  ||  |_> >   Y  \\___ (  <_> )  |   |  | 				#
#      /`  +N+      ::.-oN+    		/_______  /|____/ ____||   __/|___|  /____  >____/|__|   |__|				#
#     :.  .No     `:`# /No     		        \/      \/     |__|        \/     \/  								#
#    `/   +M`   `--`##sN+      		   _____            _             _      _____           _            		#
#    :`   .m/..--`  -dd-       		 / ____|          | |           | |    / ____|         | |           		#
#    +    .:.``   .ymo`        		| |     ___  _ __ | |_ __ _  ___| |_  | |     ___ _ __ | |_ ___ _ __ 		#
#   /:  --     :yms.          		| |    / _ \| '_ \| __/ _` |/ __| __| | |    / _ \ '_ \| __/ _ \ '__|		#
#     s+/.  ./smh+`            		| |___| (_) | | | | || (_| | (__| |_  | |___|  __/ | | | ||  __/ |   		#
#      -oyhhyo:`               		 \_____\___/|_| |_|\__\__,_|\___|\__|  \_____\___|_| |_|\__\___|_|			#
#																												#
#	-------------------------																					#
#																												#
 ###############################################################################################################


 
######################################### C O N F I G U R A T I O N   F I L E ###################################

	# DATA FIELD
	$aColumns = array(  'a.id',
						'CASE 
							WHEN a.modul = \'1\' THEN \'Telesales Penawaran\' 
							WHEN a.modul = \'2\' THEN \'Telesales Konfirmasi\' 
							WHEN a.modul = \'3\' THEN \'Teleupload\' 
							WHEN a.modul = \'4\' THEN \'Telecollection\' 
						 END',
						'a.max_limit_distribution');
	
	# INDEX ID				
	$sIndexColumn = "a.id";
	
	# START TIME & END TIME 
	$start_date_field = "a.insert_time";
	$end_date_field	  = "a.insert_time";

	# FROM QUERY
	$sFromTable = " FROM cc_parameter_assign a WHERE 1=1 ";

	# VIEW TRACE
	  // 0 = Disable     1 = Enable
	  // If you enable this Trace, so your data may be broke, but you can trace it in network data :D :P 
	  $viewTrace = 0;


####################################  E N D   O F  C O N F I G U R A T I O N   F I L E #  #########################
include '../../sysconf/global_data.php';

?>
