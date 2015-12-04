<?php
require( "serials_api.php" );
access_ensure_global_level( plugin_config_get( 'serials_view_threshold' ) );
html_page_top1();
html_page_top2();
?>
<script>
  function preventBack(){window.history.forward();
  setTimeout("preventBack()", 0);
  window.onunload=function(){null};
}
  function printDiv() {
     var printContents = "<Style>.col-md-4{float:left;min-width:170px;max-width:365px;margin-left:5px;margin-right:5px}</style><table><tr style=\"align:center; width:800px\"><th style=\"min-width:25%; align:center\">Sales Order: </br>" + $('input[name="sales_order"]').val()+"</th><th style=\"min-width:25%; align:center\">Customer: </br>" + $('input[name="customer"]').val()+"</th><th style=\"min-width:25%; align:center\">Assembly Number: </br>" + $('input[name="assembly"]').val()+"</th><th style=\"min-width:25%; align:center\">Revision: </br>" + $('input[name="revision"]').val() +"</th></tr></table><div style=\"max-width:22cm\">" + $("#log-wrapper").html() + "</div>";
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
  function reload(){
	  location.reload();
}	
</script>
<script type="text/javascript" src="plugins/Serials/pages/jquery/jquery-1.11.3.min.js"></script>
<script src="plugins/Serials/pages/typeahead/typeahead.bundle.js"></script>
<script src="plugins/Serials/pages/handlebars/handlebars-v4.0.4.js"></script>
<link rel="stylesheet" href="plugins/Serials/pages/typeahead/typeahead.css">
<link rel="stylesheet" href="plugins/Serials/pages/bootstrap/css/bootstrap.css">
<div>
<?php
if ( access_has_project_level( plugin_config_get('format_threshold') ) ) {
    global $g_config_page;
    print_bracket_link( $g_format_page, plugin_lang_get( 'format_title') );
}
?>
</div>
<section id="myData"></section>
	<script type="text/template" id="url-template">
	<form >
		<table>
			<tr>
		<div class="container col-sm-12">
		<div id="top-function-wrapper" class="col-sm-3">
		</br>
		<?php
		if ( access_has_project_level( plugin_config_get('search_threshold') ) ) {
			echo '<button type="button" id="search" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span>{{bold searchbtn}}</button>';
		}
		?>
			<button type="button" id="tulostaa-painike" class="btn btn-primary print" onclick="printDiv()"><span class="glyphicon glyphicon-print"></span>
				{{{bold printbtn}}}</button>
			<button type="button" id="reset" class="btn btn-secondary reset" onclick="reload()"><span class="glyphicon glyphicon-refresh" ></span>
				{{{bold resetbtn}}}</button>
		</div>		
		<div id="info" class="container col-sm-9 pull-right">
		<div id="sales_order" class="input-group pull-left col-sm-4">
			{{bold sales_order}} {{required}}:</br> 
				<input  class="typeahead" name="sales_order" id="sales_order">
		</div>

		<div id="customer" class="input-group pull-left col-sm-4">
		{{bold customer}} {{required}}:</br>
				<input class="typeahead" type="text" name="customer" id="customer">
		</div>

		<div id="assembly"  class="input-group pull-left col-sm-4">
			{{bold assembly}} {{required}}:</br>
				<input class="typeahead" type="text" name="assembly" id="assembly">
		</div>

		<div id="revision"  class="input-group pull-left col-sm-4">
			{{bold revision}} {{required}}:</br>
				<input class="typeahead" type="text" name="revision" id="revision">
		</div>
		</div>
		</tr>
		<tr>
		<div id="log-wrapper" class="col-offset-1 col-md-12 right-scroll "></div>
		</div>
		</tr>
		<div class="container col-sm-12 no-print">
		<div class="row no-print">
			<div id="scan_input" class="input-group input-group-lg col-sm-12 col-centered">
			  <span class="input-group-addon" id="sizing-addon1">Scan Input</span>
			  <input type="text" id="scan_result" name="scan_input" class="form-control" placeholder={{{lang_013}}} aria-describedby="sizing-addon1">
			</div>
		</div>{{! /row }}
		<input type="hidden" name="format" id="format">
		<input type="hidden" name="format_id" id="format_id">
		<input type="hidden" name="format_example" id="format_example">
		<input type="hidden" name="assembly_id" id="assembly_id">
		<input type="hidden" name="customer_id" id="customer_id">
		<input type="hidden" name="list_count" id="list_count">		
		<div class="hidden no-print" id="result"></div>
		<div id="konsoli_loki">
			<div id="virhe" class="alert"></div>
			<div id="virhe_kuvaus" class="alert"></div>
		</div>
		</div>
	</form>
	</script>
<script src="plugins/Serials/pages/js/front.js" type="text/javascript"></script>
<script src="plugins/Serials/pages/bootstrap/plugins/jQuery-Plugin-Js/jQuery.print.js"></script>

<?php

html_page_bottom1();
?>