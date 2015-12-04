<!DOCTYPE html>
<?php 	$tpl_mantis_dir = dirname( __FILE__ ) . DIRECTORY_SEPARATOR;
		echo $tpl_mantis_dir;?>
<html>
<head>
    <!--<script type="text/javascript" src="javascript/jquery.min.js"></script>-->
    <script type="text/javascript" src="js/jquery.tokeninput.js"></script>

    <link rel="stylesheet" href="css/token-input-facebook.css" type="text/css" />

    <script type="text/javascript">
 	/* $(document).ready(function() {
        $("#submit").click(function () {
            // alert("Would submit: " + $(this).siblings("input[type=text]").val());
            console.log($(this).siblings("input[type=text]").val());
        });
    }); */
    </script>
    <noscript>This page requires Javascript</noscript>
</head>
<body>
<?php
	// $t_mantis_dir = dirname( dirname( dirname( __FILE__ ) ) ) . DIRECTORY_SEPARATOR;
	require_once('dbi_con.php');
	require_once('core/helper_api.php');
	$t_user_table = "mantis_user_table";

	$result =$mysqli->query("SELECT id,username FROM $t_user_table where id>0 LIMIT 15") or die(mysqli_error());

	//create an array
	$user_arr = array();
	while(($row = $result->fetch_assoc()) !== null) { $user_arr[] = $row; }
	// procedural style $row = mysqli_fetch_assoc($result)
    // print_r($user_arr); echo "<br/><br/>";
    // using iterator: foreach ($result as $row) { $user_arr[] = $row; }

	/*
    function startsWith($haystack, $needles)
	{
		foreach ((array) $needles as $needle)
		{
			if ($needle != '' && strpos($haystack, $needle) === 0) return true;
		}
		return false;
	}

	function endsWith($haystack, $needles)
	{
		foreach ((array) $needles as $needle)
		{
			if ((string) $needle === substr($haystack, -strlen($needle))) return true;
		}
		return false;
	}

	$file = fopen("json/monitor_group.json","r");
	$string ="";
	while(! feof($file))
	{
		$line = fgets($file);
	 	$li=trim($line);
	 	if (!startsWith($li, "//"))
			$string .=$li;
	}
	fclose($file);
	echo $string;
	*/

	# JSON import for groups
	$json_file = file_get_contents("json/monitor_group.json");
	$json_string = preg_split("/\/\//", $json_file)[0];
	$json_arr = json_decode($json_string);

	$user_arr = array_merge($user_arr, $json_arr);

    # JSON-encode the response
	$json_res = json_encode($user_arr, JSON_PRETTY_PRINT);

	# Optionally: Wrap the response in a callback function for JSONP cross-domain support
	if(isset($_GET["callback"])) {
		$json_res = $_GET["callback"] . "(" . $json_res . ")";
	}

	# Return the response
	// echo $json_res . '<br/><br/>';

    # write to JSON file
    /* $fp = fopen('userdata.json', 'w');
    fwrite($fp, json_encode($user_arr));
    fclose($fp); // http://www.kodingmadesimple.com/2015/01/convert-mysql-to-json-using-php.html */
    $mysqli->close();
?>
<td class="category">
	<?php echo 'Add monitors' ?>
	<?php // print_documentation_link( 'monitors' ) ?>
</td>
<td >
	<form method="get" action="core/bug_api.php">
	<input <?php echo helper_get_tab_index() ?> type="text" id="demo-input-facebook-theme" name="monitors_names" />
	<!-- <input type="button" id="submit" value="Submit" /> -->
	</form>

	<script type="text/javascript">
	<!-- Hide JavaScript
        var ar =<?php echo $json_res?>;
        /* var idStrSet = JSON.stringify(<?php echo $json_file?>, ['id']); // using replacerMethod or array https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/JSON/stringify */
        /* var stringed = JSON.stringify(<?php echo $json_res?>);
        // console.log(stringed); http://www.experts-exchange.com/Web_Development/Q_28446638.html
        // var $monitors_ids= [];
		style="width:128px;height:128px"
         $.post("./core/bug_api.php",
        {'monitors_names': ar},
	    function(data) {
	          // some stuffs here
	        } */

        $(document).ready(function() {
            $("#demo-input-facebook-theme").tokenInput(
                   /* <?php echo $json_res ?> OR <?php echo json_encode($user_arr) ?> without quotes and blocks gives the same result */
                    ar
                , {

					propertyToSearch: "username",
					hintText: "type in username",
					theme: "facebook",

					excludeCurrent: true,
					preventDuplicates: true,
					animateDropdown: false,

	                onAdd: function (item) {
	                	/* console.log(" string to send: "+ $(this).val() + " duplicates removed in the back-end");
	                	var myStr = $(this).val();
	                	var myArr = myStr.split(',');
	                	myArr = $.unique(myArr);
	                	myStr = myArr.join(", ");
	                	console.log(" string without duplication: "+ myStr);*/

	                    // alert("Added " + item.id + " " + item.username);
	                    // var j = ($monitors_ids==="") ? "" : ";";
	                    // $monitors_ids += j + item.id;
	                    // $monitors_ids = $monitors_ids.concat(item.id);

	                    // console.log($monitors_ids); console.log($monitors_ids.join(" "));
	                    // $(this).siblings("input[name=monitors_names[]").val().html($monitors_ids);
	                    // $.(siblings("input[name=monitors_names[]").val()).html($monitors_ids);
	                },
					onDelete: function (item) {
						// console.log($(this).val());
						// if ($monitors_ids.exec()==
						//return window.confirm( "Are you sure you want to delete?" );
						// $("#demo-input-facebook-theme").tokenInput("remove", {name: 'Engineers'});
	                }
				}
			);
		});

		/* var $arr = $monitors_ids;
		$.post("bug_api.php", {'client_info': $arr}, function(data)
			{ console.log( "Data Loaded: " + data );
	          // some stuffs here
	        }
		); */

        // var selectedValues = $("#demo-input-facebook-theme").tokenInput("get");
        // console.log(selectedValues);
        /*
        JSON file has [{"id":"856","product":"sample1"}, {"id":"1035","product":"sample product 2"}]
        $('#product_tokens').tokenInput('/products.json', { propertyToSearch: 'product' });
        */
    -->
    </script>
</body>
</html>