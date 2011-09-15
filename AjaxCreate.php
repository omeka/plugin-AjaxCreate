<?php

//@TODO: when 1.5 is released, use Omeka_Plugin_Abstract

class AjaxCreate
{
    /**
     * Database object accessible to plugin authors.
     *
     * @var Omeka_Db
     */
    protected $_db;
    
    /**
     * Plugin hooks.
     *
     * Plugin authors should give an array containing hook names as values.
     * Each hook should have a corresponding, lowerCamelCased method defined in
     * the child class.
     */
    protected $_hooks = array('admin_theme_header',
        'admin_theme_footer'
    );
    
    /**
     * Plugin filters.
     *
     * Plugin authors should give an array containing filter names as values.
     * Each filter should have a corresponding, lowerCamelCased method defined
     * in the child class.
     *
     */
    protected $_filters = array('admin_items_form_tabs');
    
    /**
     * Plugin options.
     *
     * Plugin authors should give an array containing option names as keys and
     * their default values as values, if any. For example:
     * <code>
     * array('option_name1' => 'option_default_value1',
     *       'option_name2' => 'option_default_value2',
     *       'option_name3',
     *       'option_name4')
     * </code>
     *
     */
    protected $_options;
    
    /**
     * Construct the plugin object.
     *
     * Sets the database object. Plugin authors must call parent::__construct()
     * in the child class's constructor, if used.
     */
    public function __construct()
    {
        $this->_db = Omeka_Context::getInstance()->getDb();
        $this->_addHooks();
        $this->_addFilters();
    }
    
    public function adminThemeHeader()
    {
        queue_js('ajaxcreate');
        queue_css('ajaxcreate');
        echo '<script type="text/javascript">var webRoot="' . WEB_ROOT . '"; </script>';
    }
    
    public function adminThemeFooter()
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
    
    public function adminItemsFormTabs($tabs)
    {
            
        $options = array(
        	'type'=> 'Collection',
        	'target' => '#collection-id'
        );
        $dialog_content = ajax_create_dialog($options);
        $tabs['Collection'] = $dialog_content . $tabs['Collection'];
        return $tabs;
    
    }
    /**
     * Set options with default values.
     *
     * Plugin authors may want to use this convenience method in their install
     * hook callback.
     */
    protected function _installOptions()
    {
        $options = $this->_options;
        if (!is_array($options)) {
            return;
        }
        foreach ($options as $name => $value) {
            // Don't set options without default values.
            if (!is_string($name)) {
                continue;
            }
            set_option($name, $value);
        }
    }
    
    /**
     * Delete all options.
     *
     * Plugin authors may want to use this convenience method in their uninstall
     * hook callback.
     */
    protected function _uninstallOptions()
    {
        $options = self::$_options;
        if (!is_array($options)) {
            return;
        }
        foreach ($options as $name => $value) {
            delete_option($name);
        }
    }
    
    /**
     * Validate and add hooks.
     */
    private function _addHooks()
    {
        $hookNames = $this->_hooks;
        if (!is_array($hookNames)) {
            return;
        }
        foreach ($hookNames as $hookName) {
            $functionName = Inflector::variablize($hookName);
            if (!is_callable(array($this, $functionName))) {
                throw new Omeka_Plugin_Exception('Hook callback "' . $functionName . '" does not exist.');
            }
            add_plugin_hook($hookName, array($this, $functionName));
        }
    }
    
    /**
     * Validate and add filters.
     */
    private function _addFilters()
    {
        $filterNames = $this->_filters;
        if (!is_array($filterNames)) {
            return;
        }
        foreach ($filterNames as $filterName) {
            $functionName = Inflector::variablize($filterName);
            if (!is_callable(array($this, $functionName))) {
                throw new Omeka_Plugin_Exception('Filter callback "' . $functionName . '" does not exist.');
            }
            add_filter($filterName, array($this, $functionName));
        }
    }
}
