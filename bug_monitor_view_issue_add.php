<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="javascript/jquery.tokeninput.js"></script>
    <script> jQuery.noConflict();</script>

    <link rel="stylesheet" href="css/token-input-facebook.css" type="text/css" />
    <noscript>This page requires Javascript</noscript>
</head>
<body>
<?php
	require_once('dbi_con.php');

	$result =$mysqli->query("SELECT id,username FROM mantis_user_table where id>0 LIMIT 15") or die(mysqli_error());

	//create an array
	$user_arr = array();
	// $t_users_by_names = [];

	while(($row = $result->fetch_assoc()) !== null ) {
		if (!in_array($row['id'], $t_users))
			$user_arr[] = $row;
		// else $t_users_by_names[] = $row;
	}

    # JSON-encode the response
	$json_res = json_encode($user_arr, JSON_PRETTY_PRINT);
	// $json_pre = json_encode($t_users_by_names, JSON_PRETTY_PRINT);

	# Optionally: Wrap the response in a callback function for JSONP cross-domain support
	if(isset($_GET["callback"])) {
		$json_res = $_GET["callback"] . "(" . $json_res . ")";
	}

    $mysqli->close();
?>
	<script type="text/javascript">
	<!-- Hide JavaScript
        var ar =<?php echo $json_res?>;
        // var pre =<?php echo $json_pre?>;
        jQuery(document).ready(function() {
            jQuery("#demo-input-facebook-theme").tokenInput(
                    ar
                , {
					propertyToSearch: "username",
					hintText: "type in username",
					theme: "facebook",

					excludeCurrent: true,
					preventDuplicates: true, // prePopulate: pre,
					onAdd: function (item) {
	                    jQuery('#my_form').submit();
	                }
				}
			);
		});
	-->
    </script>
</body>
</html>