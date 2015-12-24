<?php
access_ensure_project_level( plugin_config_get('serials_view_threshold'));
header('Content-Type: application/json');
	$g_mantis_serials_customer       = plugin_table('customer');
	$g_mantis_serials_assembly       = plugin_table('assembly');
	$g_mantis_serials_format         = plugin_table('format');
	$g_mantis_serials_serial         = plugin_table('serial');

function list_customer (){
	global $g_mantis_serials_customer;
	$query = "	SELECT customer_name, customer_id
			FROM $g_mantis_serials_customer
			ORDER BY
			customer_name";

	$result = mysql_query($query) or die(mysql_error());
	
	$json_response = [];
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$row_array['nimi'] = $row['customer_name'];
		$row_array['id'] = $row['customer_id'];

		//push the values in the array
		$json_response[] =$row_array;
	}
	return
	json_encode(
		array_unique($json_response, SORT_REGULAR)
	);
}
	echo list_customer();