<?php
access_ensure_project_level( plugin_config_get('serials_view_threshold')); 
header('Content-Type: application/json');
	$g_mantis_serials_customer       = plugin_table('customer');
	$g_mantis_serials_assembly       = plugin_table('assembly');
	$g_mantis_serials_format         = plugin_table('format');
	$g_mantis_serials_serial         = plugin_table('serial');
	$p_customer_id = $_POST["id"];

function list_assembly ($p_customer_id){
	global $g_mantis_serials_assembly;
	if($p_customer_id){
		$t_customer_id = $p_customer_id;		
		$query = "	SELECT assembly_number, customer_id
				FROM $g_mantis_serials_assembly
				WHERE customer_id='$t_customer_id'";
	
		$result = mysql_query($query) or die(mysql_error());
		    //Create an array

		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$row_array['nimi'] = $row['assembly_number'];
			$row_array['id'] = $row['customer_id'];
						
			//push the values in the array
			$arr[] =$row_array;
		}
		$json_response = array_values(array_map('unserialize', array_unique(array_map('serialize', $arr))));
		
		return
		json_encode(
			$json_response
		);
	}
}
	echo list_assembly( $p_customer_id );