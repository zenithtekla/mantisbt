<?php
access_ensure_project_level( plugin_config_get('serials_view_threshold')); 
header('Content-Type: application/json');
	$g_mantis_serials_customer       = plugin_table('customer');
	$g_mantis_serials_assembly       = plugin_table('assembly');
	$g_mantis_serials_format         = plugin_table('format');
	$g_mantis_serials_serial         = plugin_table('serial');	
	function list_customer (){
		global $g_mantis_serials_customer; 
		$query = "	SELECT customer_id, customer_name 
				FROM $g_mantis_serials_customer
				ORDER BY 
				customer_name";

		$result = mysql_query($query) or die(mysql_error());
		    //Create an array
		$json_response = array();
		
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$row_array['customer_id'] = $row['customer_id'];
			$row_array['customer_name'] = $row['customer_name'];
						
			//push the values in the array
			array_push($json_response,$row_array);
		}
		$jsonString = json_encode($json_response);
		echo $jsonString;
		}
		
		echo list_customer();