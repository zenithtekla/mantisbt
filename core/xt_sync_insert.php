<?	
function xt_sync_insert($source){
	$t_id = $source['customer_id'];
	$result = [];

	if($source['insert_customer_table']){
		$params = [
			$source['customer_table'],
			$source['CUST_NAME'],
			$source['CUST_PO_NO'],
			$t_status,
			$source['ACCT_DATE'],
			$source['TIME_STAMP']
		];
		$t_query_string = HelperUTILS::mantis_db_query_build($source['insert_customer_table'], $params);
		// override $t_id
		// $t_id = ($source['Mocha']) ? 29 : HelperUTILS::mantis_db_invoke_insert($t_query_string, $source['customer_table'])->id;
		$result[] = $t_query_string;
	}

	// perform next query
	if($source['insert_assembly_table']){
		$params = [
			$source['assembly_table'],
			$t_id,
			$source['ASSY_NO'],
			$source['REVISION'],
			$source['UNIQ_KEY']
		];
		$t_query_string = HelperUTILS::mantis_db_query_build($source['insert_assembly_table'], $params);
		$result[] = $t_query_string;
	}

	// perform last query
	if($source['insert_wo_so_table']){
		$params = [
			$source['wo_so_table'],
			$source['WO_NO'],
			$source['SO_NO'],
			$source['QTY'],
			$source['DUE'],
			$source['UNIQ_KEY']
		];
		$t_query_string = HelperUTILS::mantis_db_query_build($source['insert_wo_so_table'], $params);
		$result[] = $t_query_string;
	}

	return $result;
}