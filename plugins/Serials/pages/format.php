<?php
require("serials_api.php");
access_ensure_project_level( plugin_config_get('format_threshold')); 
html_page_top1( plugin_lang_get( 'plugin_format_title' ) );
html_page_top2();

?>
<br>
<p align="center">Configuration page to set up Serial Numbering format per Assembly.</p>
</br>
<div align="center">
<form method="post" action="<?php echo $g_format_add_page ?>">
<table class="width75" cellspacing="1">
	<tr <?php echo helper_alternate_class() ?> valign="top">
		<td class="category">
			<?php echo plugin_lang_get( 'customer_name' ) ?>
		</td>
		<td>
			<input type="text" size="100" name="customer_name" required/>
		</td>
	</tr>
	<tr <?php echo helper_alternate_class() ?> valign="top">
		<td class="category">
			<?php echo plugin_lang_get( 'assembly_number' ) ?>
		</td>
		<td>
			<input type="text" size="100" name="assembly_number" required/>
		</td>
	</tr>
	<tr <?php echo helper_alternate_class() ?> valign="top">
		<td class="category">
			<?php echo plugin_lang_get( 'revision' ) ?>
		</td>
		<td>
			<input type="text" size="30" name="revision" required/>
		</td>
	</tr>
	<tr <?php echo helper_alternate_class() ?> valign="top">
		<td class="category">
			<?php echo plugin_lang_get( 'format' ) ?>
		</td>
		<td>
			<input type="text" size="100" name="format" required/>
		</td>
	</tr>
	<tr <?php echo helper_alternate_class() ?> valign="top">
		<td class="category">
			<?php echo plugin_lang_get( 'format_example' ) ?>
		</td>
		<td>
			<input type="text" size="100" name="format_example" required/>
		</td>
</table>
	<div>
	<input type="submit" value="Submit">
	</div>
</form>
</div>
<?php
html_page_bottom1( __FILE__ );