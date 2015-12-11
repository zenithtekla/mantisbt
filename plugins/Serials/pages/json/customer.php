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
	    //Create an array
	$t_customer_name = [];
	$t_customer_id = [];

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		// $t_customer_name[] = htmlspecialchars($row['customer_name']);
		$t_customer_name[] = $row['customer_name'];
		$t_customer_id[] = $row['customer_id'];
	}

	return json_encode(
		array("data" => array(
					"customer_name" => $t_customer_name,
					"customer_id" => $t_customer_id
			)
		)
	);;
}
	echo list_customer();