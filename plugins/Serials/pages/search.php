<?php
    // query to select all entry matching $_SESSION['format'] => the regex WHERE serial_number = $qr;
    // serial_id, assembly_id, customer_id, sale_order_id, serial_number, user_id, time
    // query to insert into the db
	require_once( 'core.php' );
	access_ensure_project_level( plugin_config_get('search_threshold'));
	$g_mantis_serials_customer       = plugin_table('customer');
	$g_mantis_serials_assembly       = plugin_table('assembly');
	$g_mantis_serials_format         = plugin_table('format');
	$g_mantis_serials_serial         = plugin_table('serial');
		if($_POST['scan_input']=="" && $_POST['customer_id'] == "" && $_POST['sales_order']==""){
			echo "ERROR - Please enter data into a field to search.";
			}
			else
			{
			$cat_count = array(
				0=>$_POST['scan_input'],
				1=>$_POST['sales_order'],
				2=>$_POST['assembly_number'],
				3=>$_POST['assembly_id'],
				4=>$_POST['customer_id'],
				);
			$andcount = count(array_filter($cat_count));
            global $g_mantis_serials_serial;

			$t_scan_input         = $_POST['scan_input'];
      $t_sales_order    		= $_POST['sales_order'];
			$t_assembly_number    = $_POST['assembly_number'];
      $t_assembly_id      	= $_POST['assembly_id'];
      $t_customer_id    	 	= $_POST['customer_id'];
      $t_user_id 			= auth_get_current_user_id();

			if($t_sales_order!=""){
				$where_search .= $g_mantis_serials_serial . ".sales_order = '$t_sales_order'";
				$andcount = $andcount - 1;
				if ($andcount > 0){
					$where_search .= " AND ";
				}
			}
			if($t_scan_input!=""){
				$where_search .= $g_mantis_serials_serial . ".serial_scan = '$t_scan_input'";
				$andcount = $andcount - 1;
				if ($andcount > 0){
					$where_search .=" AND ";
				}
			}
			if($t_customer_id!=""){
				$where_search .=$g_mantis_serials_serial . ".customer_id = '$t_customer_id'";
				$andcount = $andcount - 1;
				if ($andcount > 0){
					$where_search .=" AND ";
				}
			}
			if($t_assembly_number!=""){
				$where_search .=$g_mantis_serials_assembly . ".assembly_number = '$t_assembly_number'" ;
				$andcount = $andcount - 1;
				if ($andcount > 0){
					$where_search .=" AND ";
				}
			}
			if($t_assembly_id!=""){
				$where_search .=$g_mantis_serials_serial . ".assembly_id = '$t_assembly_id '" ;
				$andcount = $andcount - 1;
				if ($andcount > 0){
					$where_search .=" AND ";
				}
			}

            $query = "SELECT
						$g_mantis_serials_customer.customer_name,
						$g_mantis_serials_assembly.assembly_number,
						$g_mantis_serials_assembly.revision,
						$g_mantis_serials_serial.sales_order,
						mantis_user_table.realname,
						$g_mantis_serials_serial.date_posted,
						$g_mantis_serials_serial.serial_scan
						FROM $g_mantis_serials_serial
						INNER JOIN $g_mantis_serials_assembly ON $g_mantis_serials_serial.assembly_id = $g_mantis_serials_assembly.assembly_id
						INNER JOIN $g_mantis_serials_customer ON $g_mantis_serials_serial.customer_id = $g_mantis_serials_customer.customer_id
						INNER JOIN mantis_user_table ON mantis_user_table.id = $g_mantis_serials_serial.user_id
						WHERE $where_search
						ORDER BY serial_scan, date_posted
						";
            $result = mysql_query($query) or die(mysql_error());
            if( mysql_num_rows( $result ) > 0 ) {
				$first_row = true;
				echo '<table class="col-md-12 table table-bordered table-condensed table-striped">';
				while ( $row = mysql_fetch_assoc( $result )) {
					if ($first_row) {
						$first_row = false;
						// Output header row from keys.
						echo '<tr >';
						foreach($row as $key => $field) {
							echo '<th class="text-center text-uppercase col-md-2">' . htmlspecialchars($key) . '</th>';
						}
						echo '</tr>';
					}
					echo '<tr >';
					foreach($row as $field) {
						echo '<td class="text-center col-md-2">' . htmlspecialchars($field) . '</td>';
					}
					echo '</tr>' ;
				}
				echo '</table>';
			}
            else {
				echo "Search for Sales Order " . $t_sales_order . "  returned with no results." ;

            }
        }
        // echo json_encode($qr, JSON_FORCE_OBJECT);
        // echo json_encode($qr, JSON_PRETTY_PRINT);

// die (json_encode (array ('qr'=>'Your script worked fine')));
function queryOfQuery($rs, // The recordset to query
  $fields = "*", // optional comma-separated list of fields to return, or * for all fields
  $distinct = false, // optional true for distinct records
  $fieldToMatch = null, // optional database field name to match
  $valueToMatch = null) { // optional value to match in the field, as a comma-separated list

  $newRs = Array();
  $row = Array();
  $valueToMatch = explode(",",$valueToMatch);
  $matched = true;
  mysql_data_seek($rs, 0);
  if($rs) {
    while ($row_rs = mysql_fetch_assoc($rs)){
      if($fields == "*") {
        if($fieldToMatch != null) {
          $matched = false;
          if(is_integer(array_search($row_rs[$fieldToMatch],$valueToMatch))){
            $matched = true;
          }
        }
        if($matched) $row = $row_rs;
      }else{
        $fieldsArray=explode(",",$fields);
        foreach($fields as $field) {
          if($fieldToMatch != null) {
            $matched = false;
            if(is_integer(array_search($row_rs[$fieldToMatch],$valueToMatch))){
              $matched = true;
            }
          }
          if($matched) $row[$field] = $row_rs[$field];
        }
      }
      if($matched)array_push($newRs, $row);
    };
    if($distinct) {
      sort($newRs);
      for($i = count($newRs)-1; $i > 0; $i--) {
        if($newRs[$i] == $newRs[$i-1]) unset($newRs[$i]);
      }
    }
  }
  mysql_data_seek($rs, 0);
  return $newRs;
}
?>
