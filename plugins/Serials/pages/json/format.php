<?php
access_ensure_project_level( plugin_config_get('serials_view_threshold')); 
header('Content-Type: application/json');
	$g_mantis_serials_customer       = plugin_table('customer');
	$g_mantis_serials_assembly       = plugin_table('assembly');
	$g_mantis_serials_format         = plugin_table('format');
	$g_mantis_serials_serial         = plugin_table('serial');	
	$p_assembly_id = gpc_get_string ('assembly_id');
	function get_format ($p_assembly_id){
		$t_assembly_id = $p_assembly_id;
		global $g_mantis_serials_format; 
		$query = "SELECT format, format_id, format_example
				FROM $g_mantis_serials_format
				WHERE assembly_id='$t_assembly_id'";
				
		$result = mysql_query($query) or die(mysql_error());
		    //Create an array
		$json_response = array();
		
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$row_array['format'] = $row['format'];
			$row_array['format_id'] = $row['format_id'];
			$row_array['format_example'] = $row['format_example'];
						
			//push the values in the array
			array_push($json_response,$row_array);
		}
		$jsonString = json_encode($json_response);
		echo $jsonString;
		}
		
		echo get_format($p_assembly_id);