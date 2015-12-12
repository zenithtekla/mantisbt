<?php
require("serials_api.php");
access_ensure_project_level( plugin_config_get('format_threshold'));
html_page_top1( plugin_lang_get( 'plugin_format_title' ) );
html_page_top2();
?>
<link rel="stylesheet" href="plugins/Serials/pages/jquery-typeahead-2.1.3/dist/jquery.typeahead.min.css">
<link rel="stylesheet" href="plugins/Serials/pages/css/custom.css">

<br>
<p align="center">Configuration page to set up Serial Numbering format per Assembly.</p>
</br>
<div align="center">
<form method="post" action="<?php echo $g_format_add_page ?>">
<table class="width75" cellspacing="1">
	<tr <?php echo helper_alternate_class() ?> valign="top">
		<td class="left pad1 positive" colspan="20"><var id="result-container" class="result-container"></var></td>
	</tr>
	<tr <?php echo helper_alternate_class() ?> valign="top">
		<td class="category">
			<?php echo plugin_lang_get( 'customer_name' ) ?>
		</td>
		<td>
			<div class="typeahead-container">
		        <div class="typeahead-field">
		            <span class="typeahead-query">
		        		<input id="field1" type="text" size="100" name="customer_name[query]" required/>
		        	</span>
		        	<span class="typeahead-button">
		                <button type="submit">
		                    <i class="typeahead-search-icon"></i>
		                </button>
		            </span>
		        </div>
		    </div>
		</td>
	</tr>
	<tr <?php echo helper_alternate_class() ?> valign="top">
		<td class="category">
			<?php echo plugin_lang_get( 'assembly_number' ) ?>
		</td>
		<td>
			<div class="typeahead-container">
		        <div class="typeahead-field">
					<span class="typeahead-query">
					<input id="field2" type="text" size="100" name="assembly_number" required/>
					</span>
					<span class="typeahead-button">
		                <button type="submit">
		                    <i class="typeahead-search-icon"></i>
		                </button>
		            </span>
		        </div>
		    </div>
		</td>
	</tr>
	<tr <?php echo helper_alternate_class() ?> valign="top">
		<td class="category">
			<?php echo plugin_lang_get( 'revision' ) ?>
		</td>
		<td>
			<div class="typeahead-container">
		        <div class="typeahead-field">
					<span class="typeahead-query">
					<input id="field3" type="text" size="30" name="revision" required/>
					</span>
					<span class="typeahead-button">
		                <button type="submit">
		                    <i class="typeahead-search-icon"></i>
		                </button>
		            </span>
				</div>
		    </div>
		</td>
	</tr>
	<tr <?php echo helper_alternate_class() ?> valign="top">
		<td class="category">
			<?php echo plugin_lang_get( 'format_helper' ) ?>
		</td>
		<td>
			<div class="typeahead-container">
		        <div class="typeahead-field">
					<span class="typeahead-query">
						<input id="field4" type="text" size="100" name="format_helper"/>
					</span>
					<span class="typeahead-button">
		                <button type="submit">
		                    <i class="typeahead-search-icon"></i>
		                </button>
		            </span>
				</div>
		    </div>
		</td>
	</tr>
	<tr <?php echo helper_alternate_class() ?> valign="top">
		<td class="category">
			<?php echo plugin_lang_get( 'format_example' ) ?>
		</td>
		<td>
			<div class="typeahead-container">
        		<div class="typeahead-field">
					<span class="typeahead-query">
					<input id="field5" type="text" size="100" name="format_example" required/>
					</span>
					<span class="typeahead-button">
		                <button type="submit">
		                    <i class="typeahead-search-icon"></i>
		                </button>
		            </span>
				</div>
    		</div>
		</td>
	</tr>
	<tr <?php echo helper_alternate_class() ?> valign="top">
		<td class="category">
			<?php echo plugin_lang_get( 'format' ) ?>
		</td>
		<td>
			<span id="f_prepend" class=" exp-decorator">/^</span>
				<input type="text" size="100" name="format" required/>
			<span id="f_append" class=" exp-decorator">$/i</span>
		</td>
	</tr>
</table>
	<div>
	<input type="submit" value="Submit">
	</div>
</form>
</div>
<script src="plugins/Serials/pages/jquery/jquery-1.11.3.min.js" type="text/javascript" ></script>
<script src="plugins/Serials/pages/handlebars/handlebars-v4.0.4.js" type="text/javascript" ></script>
<script src="plugins/Serials/pages/jquery-typeahead-2.1.3/dist/jquery.typeahead.min.js" type="text/javascript" ></script>
<script src="plugins/Serials/pages/js/format_proc_api.js" type="text/javascript"></script>
<script src="plugins/Serials/pages/js/format_proc.js" type="text/javascript"></script>
<?php
html_page_bottom1( __FILE__ );