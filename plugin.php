<?php
define('AJAX_CREATE_PLUGIN_DIR', dirname(__FILE__));

//TODO: switch to Class-based plugin structure
add_plugin_hook('install', 'ajax_create_install');
add_plugin_hook('uninstall', 'ajax_create_uninstall');
add_filter('admin_items_form_tabs', 'ajax_create_collection_tab');

add_plugin_hook('admin_theme_header', 'ajax_create_admin_theme_header');
add_plugin_hook('admin_theme_footer', 'ajax_create_admin_theme_footer');

require_once AJAX_CREATE_PLUGIN_DIR . '/helpers/AjaxCreateFunctions.php';

function ajax_create_collection_tab($tabs)
{
	$options = array(
		'type'=> 'Collection',
		'target' => '#collection-id'
	);
	$dialog_content = ajax_create_dialog($options);
	$tabs['Collection'] = $dialog_content . $tabs['Collection'];
	return $tabs;
}

function ajax_create_admin_theme_header()
{

	echo '<link rel="stylesheet" type="text/css" href="' . WEB_PLUGIN . '/AjaxCreate/views/admin/css/ajaxcreate.css"  ></link>';
 
	echo '<script type="text/javascript" src="' . WEB_PLUGIN . '/AjaxCreate/views/admin/javascripts/ajaxcreate.js" ></script>';
//TODO: use enqueue to add webRoot to Omeka object
	echo '<script type="text/javascript">AC.webRoot="' . WEB_ROOT . '"; </script>';
}


function ajax_create_admin_theme_footer()
{
	echo "<div style='display:none' id='ajax-create-dialog'>
		<form>
		<label>Name</label><input id='ajax-create-dialog-name' type='text' size='20' />
		<br/>
		<label class='ajax-create-dialog-description'>Description</label><textarea id='ajax-create-dialog-description'  class='ajax-create-dialog-description' rows='5' cols='25'></textarea>
		</form>
		<p>Note: You will want to finish setting up the new <span class='ajax-create-dialog-type-name'>Record</span> after you are done here</p>
					
	</div>";
}
?>