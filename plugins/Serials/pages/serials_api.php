<?php
	$g_mantis_serials_customer       = plugin_table('customer');
	$g_mantis_serials_assembly       = plugin_table('assembly');
	$g_mantis_serials_format         = plugin_table('format');
	$g_mantis_serials_serial         = plugin_table('serial');	
	#----------------------------------
	# serials page definitions

	$g_serials_menu_page                = plugin_page( 'serials_menu_page.php' );
	$g_format_add_page					= plugin_page( 'format_add.php' );
	$g_format_page                 		= plugin_page( 'format.php' );
	$g_config_page                 		= plugin_page( 'config.php' );
	$g_config_edit_page                 = plugin_page( 'config_edit.php' );
		#----------------------------------

	###########################################################################
	# serials API
	###########################################################################

	function customer_name_unique( $p_customer_name ) {
		global $g_mantis_serials_customer;
		$query = "SELECT customer_id
					FROM $g_mantis_serials_customer 
					WHERE customer_name = '$p_customer_name'";
		$result = mysql_query( $query ) or die(mysql_error());
		if( mysql_num_rows( $result ) > 0 ) {
			$row = mysql_fetch_array($result);
			return $row["customer_id"];
		} else {
			return 'true';
		}
	}
	
	function assembly_revision_unique ( $p_assembly, $p_revision, $new_customer) {
		global $g_mantis_serials_assembly;
		$query = "SELECT assembly_id
					FROM $g_mantis_serials_assembly
					WHERE assembly_number = '$p_assembly' AND revision = '$p_revision' AND customer_id ='$new_customer'";
		$result = mysql_query( $query ) or die(mysql_error());
		if( mysql_num_rows( $result ) > 0 ) {
			$row = mysql_fetch_array($result);
			return $row["assembly_id"];
		} else {
			return 'true';
		}
	}
	
	function add_customer( $p_customer_name, $new_customer){
		global $g_mantis_serials_customer;
		if ( $new_customer == 'true' ){		
			$query = "INSERT INTO $g_mantis_serials_customer
					( customer_id, customer_name )
					VALUES
					( null, '$p_customer_name')";
			db_query_bound( $query );
			$t_customer_id = db_insert_id ( $g_mantis_serials_customer );
			return $t_customer_id;
		} else {
			return $new_customer;
		}
			
	}
	
	function add_assembly ( $p_assembly_number, $p_revision , $m_customer_name, $new_customer, $new_assembly ){
		$p_customer_id = add_customer ( $m_customer_name, $new_customer );
		global $g_mantis_serials_assembly;
		if ( $new_assembly == 'true' ){
			$query = "INSERT
					INTO $g_mantis_serials_assembly
					( assembly_id, customer_id, assembly_number, revision )
					VALUES
					( null, '$p_customer_id', '$p_assembly_number', '$p_revision' )";
			db_query_bound( $query );
			$t_assembly_id = db_insert_id ( $g_mantis_serials_assembly );
			return $t_assembly_id;
		} else {
			return $new_assembly;
		}
	}
	function add_format( $p_customer_name, $p_assembly_number, $p_revision, $p_format, $p_format_example, $new_customer, $new_assembly ){
		$p_assembly_id = add_assembly ( $p_assembly_number, $p_revision, $p_customer_name, $new_customer, $new_assembly );
		global $g_mantis_serials_format;
		if ( $new_assembly == 'true' ){
			$query = "INSERT
					INTO $g_mantis_serials_format
					( format_id, assembly_id, format, format_example )
					VALUES
					( null, '$p_assembly_id', '$p_format', '$p_format_example' )";			
	    return db_query_bound( $query );	
		} else {
			$query = "UPDATE $g_mantis_serials_format
					SET format='$p_format', format_example='$p_format_example'
					WHERE assembly_id='$p_assembly_id'";
		return db_query_bound( $query );
		}
	}
