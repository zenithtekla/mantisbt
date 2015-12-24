<?php
access_ensure_project_level( plugin_config_get('serials_view_threshold')); 
header('Content-Type: application/json');
	$g_mantis_serials_customer       = plugin_table('customer');
	$g_mantis_serials_assembly       = plugin_table('assembly');
	$g_mantis_serials_format         = plugin_table('format');
	$g_mantis_serials_serial         = plugin_table('serial');
	/*$p_assembly_number = gpc_get_string('assembly_number');
	$p_customer_id = gpc_get_string('customer_id');*/
	$p_assembly_number = $_POST["nimi"];
	$p_customer_id = $_POST["id"];

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
		$json_response = [];
		
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$row_array['nimi'] = $row['revision'];
			$row_array['id'] = $row['assembly_id'];
			
			//push the values in the array
			$json_response[] =$row_array;
		}
		return
		json_encode(
			array_unique($json_response, SORT_REGULAR)
		);
	}
}
	echo list_revision( $p_assembly_number, $p_customer_id);