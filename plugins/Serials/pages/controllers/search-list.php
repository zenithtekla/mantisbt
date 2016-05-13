<?php
    // query to select all entry matching $_SESSION['format'] => the regex WHERE serial_number = $qr;
    // serial_id, assembly_id, customer_id, sale_order_id, serial_number, user_id, time
    // query to insert into the db
	require_once( 'core.php' );
	access_ensure_project_level( plugin_config_get('search_threshold')); 
	$g_mantis_customer       = db_get_table( 'mantis_customer_table' );
	$g_mantis_assembly       = db_get_table( 'mantis_assembly_table' );
	$g_mantis_serials_format         = strtolower(plugin_table('format'));
	$g_mantis_serials_serial         = strtolower(plugin_table('serial'));
		if($_POST['scan_input']=="" && $_POST['assembly_number'] == "" && $_POST['sales_order']==""){
			echo "ERROR - Please search using a SALES ORDER , ASSEMBLY , or SERIAL NUMBER (SCAN INPUT).";
			}
			else
			{
			$cat_count = array(
				0=>$_POST['scan_input'],
				1=>$_POST['sales_order'],
				2=>$_POST['assembly_number'],
				3=>$_POST['assembly_id'],
				4=>$_POST['customer_id']
				);
			$andcount = count(array_filter($cat_count));
			$where_search ="";	
            global $g_mantis_serials_serial;
			$t_scan_input         = $_POST['scan_input'];
            $t_sales_order    	= $_POST['sales_order'];
			$t_assembly_number    = $_POST['assembly_number'];
            $t_assembly_id      = $_POST['assembly_id'];
            $t_customer_id      = $_POST['customer_id'];
            $t_user_id 			= auth_get_current_user_id();
			
			if($t_sales_order){
				$where_search .= "mantis_plugin_serials_serial_table.sales_order = " . "'" . $t_sales_order . "'";
				$andcount = $andcount - 1;
				if ($andcount > 0){
					$where_search .= " AND ";
				}
			}
			if($t_scan_input){
				$where_search .= "mantis_plugin_serials_serial_table.serial_scan = " . "'" . $t_scan_input . "'";
				$andcount = $andcount - 1;
				if ($andcount > 0){
					$where_search .=" AND ";
				}
			}
			if($t_customer_id){
				$where_search .="mantis_plugin_serials_serial_table.customer_id = " . "'" . $t_customer_id . "'";
				$andcount = $andcount - 1;
				if ($andcount > 0){
					$where_search .=" AND ";
				}
			}
			if($t_assembly_number){
				$where_search .="mantis_assembly_table.number = " . "'" . $t_assembly_number . "'";
				$andcount = $andcount - 1;
				if ($andcount > 0){
					$where_search .=" AND ";
				}
			}
			if($t_assembly_id){
				$where_search .="mantis_plugin_serials_serial_table.assembly_id = " . "'" . $t_assembly_id . "'";
				$andcount = $andcount - 1;
				if ($andcount > 0){
					$where_search .=" AND ";
				}
			}
            $query = "SELECT 
						mantis_plugin_serials_serial_table.serial_scan
						FROM $g_mantis_serials_serial
						INNER JOIN $g_mantis_assembly ON mantis_plugin_serials_serial_table.assembly_id = mantis_assembly_table.id
						INNER JOIN $g_mantis_customer ON mantis_plugin_serials_serial_table.customer_id = mantis_customer_table.id
						INNER JOIN mantis_user_table ON mantis_user_table.id = mantis_plugin_serials_serial_table.user_id
						WHERE $where_search
						ORDER BY serial_scan
						";
            $result = mysql_query($query) or die(mysql_error());	
            if( mysql_num_rows( $result ) > 0 ) {
				$first_row = true;
				echo '<table class="col-md-12"><div>';
				while ( $row = mysql_fetch_assoc( $result )) {
					if ($first_row) {
						$first_row = false;
						$count = 0;
					}
					foreach($row as $field) {
						$count++;
						echo '<div class="col-md-3">' . $count . '. ' . htmlspecialchars($field) . '</div>';
					}
				}
			}	
        }
