<?php
define('AJAX_CREATE_PLUGIN_DIR', dirname(__FILE__));
require_once AJAX_CREATE_PLUGIN_DIR . '/AjaxCreate.php';
require_once AJAX_CREATE_PLUGIN_DIR . '/helpers/AjaxCreateFunctions.php';

new AjaxCreate();