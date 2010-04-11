<?php
define('AJAX_CREATE_PLUGIN_DIR', dirname(__FILE__));


add_plugin_hook('install', 'ajax_create_install');
add_plugin_hook('uninstall', 'ajax_create_uninstall');

add_plugin_hook('admin_theme_header', 'ajax_create_admin_theme_header');
add_plugin_hook('admin_theme_footer', 'ajax_create_admin_theme_footer');

require_once AJAX_CREATE_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'AjaxCreateFunctions.php';

function ajax_create_admin_theme_header()
{
	echo '<link rel="stylesheet" type="text/css" href="' . WEB_PLUGIN . '/AjaxCreate/views/admin/css/ajaxcreate.css"  ></link>';
	echo '<script type="application/javascript" src="' . WEB_PLUGIN . '/AjaxCreate/views/admin/javascripts/ajaxcreate.js"  ></script>';	
}


function ajax_create_admin_theme_footer()
{
	echo "<div style='display:none' id='dialog'>
		<form>
		<label>Name</label><input id='ajax-create-dialog-name' type='text' size='20' />
		<br/>
		<label>Description</label><textarea id='ajax-create-dialog-description' rows='5' cols='25'></textarea>
		</form>
		<p>Note: You will want to finish setting up the new <span class='ajax-create-dialog-type-name'>Record</span> after you are done here</p>		
					
	</div>";	
}
?>