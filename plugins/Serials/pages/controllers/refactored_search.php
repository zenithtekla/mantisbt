<?php
// query to select all entry matching $_SESSION['format'] => the regex WHERE serial_number = $qr;
// serial_id, assembly_id, customer_id, sale_order_id, serial_number, user_id, time
// query to insert into the db
require_once( 'core.php' );
access_ensure_project_level( plugin_config_get('search_threshold'));
$g_mantis_customer       			= db_get_table( 'mantis_customer_table' );
$g_mantis_assembly       			= db_get_table( 'mantis_assembly_table' );
$g_mantis_serials_format         	= strtolower(plugin_table('format'));
$g_mantis_serials_serial         	= strtolower(plugin_table('serial'));

$o_post['scan_input']		= $_POST['scan_input'];
$o_post['sales_order']		= $_POST['sales_order'];
$o_post['assembly_number']	= $_POST['assembly_number'];
$o_post['assembly_id']		= $_POST['assembly_id'];
$o_post['customer_id']		= $_POST['customer_id'];
$o_post['user_id']			= auth_get_current_user_id();

function search ($o_post){
	$p_serial_scan			= $o_post['scan_input'];
	$p_sales_order			= $o_post['sales_order'];
	$p_assembly_number		= $o_post['assembly_number'];
	$p_assembly_id			= $o_post['assembly_id'];
	$p_customer_id			= $o_post['customer_id'];

	try {
		if (!($p_scan_input || $p_assembly_number || $p_sales_order))
			throw new Exception('ERROR - Please search using a SALES ORDER , ASSEMBLY , or SERIAL NUMBER (SCAN INPUT).');
		if ($p_sales_order){
			$p_post['st.sales_order']	= $p_sales_order;
			$p_search[]					= "Sales Order '$p_sales_order'";
		}
		if ($p_serial_scan){
			$p_post['st.serial_scan']	= $p_serial_scan;
			$p_search[]					= "Serial Number '$p_serial_scan'";
		}
		if ($p_customer_id){
			$p_post['st.customer_id']	= $p_customer_id;
		}
		if ($p_assembly_number){
			$p_post['at.number']		= $p_assembly_number;
			$p_search[]					= "Assembly Number '$p_assembly_number'";
		}
		if ($p_assembly_id){
			$p_post['st.assembly_id']	= $p_assembly_id;
		}
		foreach ($p_post as $key => $value) {
			if($value){
				$p_cats[$key] = $value;
				$p_wheres[] = $key." = '$value'";
			}
		}
		$result['where'] = implode(' AND ', $p_wheres);
		$result['search_msg'] = implode(' and ', $p_search);

	} catch (Exception $e) {
		$result['error'] = $e->getMessage();
	}
	finally {
		return $result;
	}
}

$response = search($o_post);
$t_where = $response['where'];
$search_msg = 'Searching for ' . $response['search_msg'];

$query_for_serials = "SELECT
	st.serial_scan
	FROM $g_mantis_serials_serial st
	INNER JOIN $g_mantis_assembly at
		ON st.assembly_id = at.id
	INNER JOIN $g_mantis_customer ct
		ON st.customer_id = ct.id
	INNER JOIN mantis_user_table ut
		ON ut.id = st.user_id
	WHERE $t_where
	ORDER BY st.serial_scan
";

$result = mysql_query($query_for_serials) or die(mysql_error());
if( mysql_num_rows( $result ) > 0 ) {
	$first_row = true;
	$json_response["serials"] .= '<table class="col-md-12"><div>';
	while ( $row = mysql_fetch_assoc( $result )) {
		if ($first_row) {
			$first_row = false;
			$count = 0;
		}
		foreach($row as $field) {
			$count++;
			$json_response["serials"] .= '<div class="col-md-3">' . $count . '. ' . htmlspecialchars($field) . '</div>';
		}
	}
}

$query = "SELECT
	ct.name,
	at.number,
	at.revision,
	ut.realname,
	st.date_posted,
	st.serial_scan,
	st.sales_order
	FROM $g_mantis_serials_serial st
	INNER JOIN $g_mantis_assembly at
		ON st.assembly_id = at.id
	INNER JOIN $g_mantis_customer ct
		ON st.customer_id = ct.id
	INNER JOIN mantis_user_table ut
		ON ut.id = st.user_id
	WHERE $t_where
	ORDER BY st.serial_scan, st.date_posted
";

$result = mysql_query($query) or die(mysql_error());
if( mysql_num_rows( $result ) > 0 ) {
	$first_row = true;
	$json_response["all"] .= '
		<style>
			tr:nth-child(odd){ background-color: white;}
			td { nowrap; padding: 1px 3px;}
		</style>
		<table class="col-md-12"><div>';

	while ( $row = mysql_fetch_assoc( $result )) {
		if ($first_row) {
			$first_row = false;
			$count = 0;
			// Output header row from keys.
			$json_response["all"] .=
			'<tr >';
				foreach($row as $key => $field) {
					$json_response["all"] .= '<th class="text-center text-uppercase">' . htmlspecialchars($key) . '</th>';
				}
				$json_response["all"] .= '<th class="text-center text-uppercase">Count</th>
			</tr>';
		}
		$json_response["all"] .= '<tr >';
			foreach($row as $field) {
				$json_response["all"] .= '<td class="text-center">' . htmlspecialchars($field) . '</td>';
			}
			$count++;
			$json_response["all"] .= '<td class="text-center">' . $count . '</td>
		</tr>' ;
	}
		$json_response["all"] .= '</table></div>';
}
else {
	$json_response["all"] .= $search_msg . " returned with no result." ;
}

// $json_response['all'] = $query_for_serials;
echo json_encode($json_response, JSON_PRETTY_PRINT);

// echo json_encode($qr, JSON_FORCE_OBJECT);
// echo json_encode($qr, JSON_PRETTY_PRINT);