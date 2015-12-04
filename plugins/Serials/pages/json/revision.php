<?php
access_ensure_project_level( plugin_config_get('serials_view_threshold')); 
header('Content-Type: application/json');
	$g_mantis_serials_customer       = plugin_table('customer');
	$g_mantis_serials_assembly       = plugin_table('assembly');
	$g_mantis_serials_format         = plugin_table('format');
	$g_mantis_serials_serial         = plugin_table('serial');
	$p_assembly_number = gpc_get_string('assembly_number');
	$p_customer_id = gpc_get_string('customer_id');
	function list_revision ($p_assembly_number, $p_customer_id){
		global $g_mantis_serials_assembly;
		if($p_assembly_number){
		$t_assembly_number = $p_assembly_number;
		$t_customer_id = $p_customer_id;
		$query = "	SELECT revision, assembly_id
				FROM $g_mantis_serials_assembly
				WHERE assembly_number='$t_assembly_number' AND customer_id='$t_customer_id'";

		$result = mysql_query($query) or die(mysql_error());
		    //Create an array
		$json_response = array();
		
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$row_array['revision'] = $row['revision'];
			$row_array['assembly_id'] = $row['assembly_id'];
			
			//push the values in the array
			array_push($json_response,$row_array);
		}
		$jsonString = json_encode($json_response);
		echo $jsonString;
		}
	}
		echo list_revision( $p_assembly_number, $p_customer_id);