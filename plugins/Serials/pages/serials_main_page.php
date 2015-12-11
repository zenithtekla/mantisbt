<?php
require( "serials_api.php" );
access_ensure_global_level( plugin_config_get( 'serials_view_threshold' ) );
html_page_top1();
html_page_top2();
?>
<script>
	function preventBack(){
		window.history.forward();
		setTimeout("preventBack()", 0);
		window.onunload=function(){null};
	}
	function reload(){
		location.reload();
	}
</script>
<link rel="stylesheet" href="plugins/Serials/pages/typeahead/typeahead.css">
<link rel="stylesheet" media="all" href="plugins/Serials/pages/bootstrap/css/bootstrap.css">
<script src="plugins/Serials/pages/js/ui_data.js" type="text/javascript"></script>
<section id="ui_data"></section>

<script type="text/template" id="ui-template">
<form >
<div class="container col-sm-12">
	<div class="pull-right">
	<?php
		if ( access_has_project_level( plugin_config_get('format_threshold') ) ) {
		    global $g_config_page;
		    print_bracket_link( $g_format_page, plugin_lang_get( 'format_title') );
		}
		$t_now = date( config_get( 'complete_date_format' ) );
		echo "<span id='time'>". $t_now ."</span>";
	?>
	</div>
	
	<div id="top-function-wrapper" class="col-sm-3 no-print">
	<?php
	if ( access_has_project_level( plugin_config_get('search_threshold') ) ) {
		echo '<button type="button" id="search" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span>{{bold searchbtn}}</button>';
	}
	?>
		<button type="button" id="tulostaa-painike" class="btn btn-primary print"><span class="glyphicon glyphicon-print"></span>
			{{bold printbtn}}</button>
		<button type="button" id="html-painike" class="btn btn-primary print"><span class="glyphicon glyphicon-fullscreen"></span>
			{{bold htmlbtn}}</button>
		<button type="button" id="reset" class="btn btn-secondary reset" onclick="reload()"><span class="glyphicon glyphicon-refresh" ></span>
			{{bold resetbtn}}</button>
	</div>
	
	<div id="info" class="col-sm-12">
		<div id="sales_order" class="input-group pull-left col-sm-3">
			{{bold sales_order}} {{required}}:
				<input  class="typeahead" name="sales_order" id="sales_order">
		</div>

		<div id="customer" class="input-group pull-left col-sm-3">
		{{bold customer}} {{required}}:
				<input class="typeahead" type="text" name="customer" id="customer">
		</div>

		<div id="assembly"  class="input-group pull-left col-sm-3">
			{{bold assembly}} {{required}}:
				<input class="typeahead" type="text" name="assembly" id="assembly">
		</div>

		<div id="revision"  class="input-group pull-left col-sm-3">
			{{bold revision}} {{required}}:
				<input class="typeahead" type="text" name="revision" id="revision">
		</div>
	</div>
	<div id="printable">
	<div id="log-wrapper" class="col-offset-1 col-md-12 right-scroll "></div>
	</div>

	<div class="row no-print">
		<div id="scan_input" class="input-group input-group-lg col-sm-12 col-centered">
		  <span class="input-group-addon" id="sizing-addon1">Scan Input</span>
		  <input type="text" id="scan_result" name="scan_input" class="form-control" placeholder="{{lang_013}}" aria-describedby="sizing-addon1">
		</div>
	</div>{{! /row }}
	<div class="hidden no-print" id="log-verify"></div>
	<div id="konsoli_loki">
		<div id="virhe" class="col-md-12 alert"></div>
		<div id="virhe_kuvaus" class="alert"></div>
	</div>
</div>
</form>
</script>

<script src="plugins/Serials/pages/jquery/jquery-1.11.3.min.js" type="text/javascript" ></script>
<script src="plugins/Serials/pages/handlebars/handlebars-v4.0.4.js" type="text/javascript" ></script>
<script src="plugins/Serials/pages/typeahead/typeahead.bundle.js" type="text/javascript" ></script>
<script src="plugins/Serials/pages/bootstrap/plugins/jQuery-Plugin-Js/jQuery.print.js" type="text/javascript" ></script>
<script src="plugins/Serials/pages/js/process_api.js" type="text/javascript" ></script>
<script src="plugins/Serials/pages/js/front.js" type="text/javascript" ></script>
<?php

html_page_bottom1();
?>