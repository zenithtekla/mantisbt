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
	$t_user_table = "mantis_user_table";
	$result =$mysqli->query("SELECT id,username FROM $t_user_table where id>0 LIMIT 15") or die(mysqli_error());

	//create an array
	$user_arr = array();
	// $t_users_by_names = [];

	while(($row = $result->fetch_assoc()) !== null ) {
		if (!in_array($row['id'], $t_users))
			$user_arr[] = $row;
		// else $t_users_by_names[] = $row;
	}

	# JSON import for groups
	$json_file = file_get_contents("json/monitor_group.json");
	$json_string = preg_split("/\/\//", $json_file)[0];
	// echo $json_string;
	$json_arr = json_decode($json_string);

	// **** Display of username ****
	foreach ($json_arr as $key => $value) {
		$t_val = (array)$value;

		$t_string .= "&#8226; <i>" . $t_val['username'] . "</i> : ";
		$query = "SELECT * FROM $t_user_table WHERE id IN (" . $t_val['id'] . ")";
		$result = $mysqli->query($query) or die(mysqli_error());
		$t_names = [];
		while(($row = $result->fetch_assoc()) !== null ) {
			$t_names[] = $row['username']; // $row['realname'] for display of realname
		}
		$t_string .= implode(", ", $t_names) . " <br/>";
	}
	echo $t_string; // comment out the echo or this entire part to skip the display
	// *****************************

	$user_arr = array_merge($user_arr, $json_arr);

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
        var monitors = <?php echo json_encode($t_users)?>;
        // console.log(jQuery.isArray( monitors ) === true);
        // var pre =<?php echo $json_pre?>;
        jQuery(document).ready(function() {
        	// jQuery.each(monitors, function(index,val){ console.log(val);});
            jQuery("#demo-input-facebook-theme").tokenInput(
                    ar
                , {
					propertyToSearch: "username",
					hintText: "type in username",
					theme: "facebook",

					excludeCurrent: true,
					preventDuplicates: true, // prePopulate: pre,
					onAdd: function (item) {
						var myStr = jQuery(this).val();
						// var myStr2 = jQuery(this).tokenInput("get")[0]['id']; // same, working
						var myArr = myStr.split(',');
						myArr = myArr.filter(function(val) {
						  return monitors.indexOf(val) === -1;
						});
						jQuery(this).val(myArr);
	                    jQuery('#my_form').submit();
	                }
				}
			);
		});
	-->
    </script>
</body>
</html>