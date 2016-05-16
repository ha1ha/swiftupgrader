<?php
/**
 * 2016 Michael Dekker
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@michaeldekker.com so we can send you a copy immediately.
 *
 *  @author    Michael Dekker <prestashop@michaeldekker.com>
 *  @copyright 2016 Michael Dekker
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class Swiftupgrader extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'swiftupgrader';
        $this->tab = 'administration';
        $this->version = '1.0.2';
        $this->author = 'Michael Dekker';
        $this->need_instance = 1;

        // Only necessary for back office
        if (defined('_PS_ADMIN_DIR_')) {
            $this->warning = '';
            foreach ($this->detectBOSettings() as $warning) {
                $this->warning .= $warning;
            }
        }

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('SwiftMailer upgrader');
        $this->description = $this->l('Upgrade your SwiftMailer');
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader');
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        $output = '';

        $output .= $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');

        /**
         * Check settings
         */
        foreach ($this->detectBOSettings() as $error) {
            $output .= $this->displayError($error);
        }

        return $output;
    }

    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookBackOfficeHeader()
    {
        if (Tools::getValue('module_name') == $this->name) {
            $this->context->controller->addJS($this->_path.'views/js/back.js');
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/front.js');
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }

    /**
     * Detect Back Office settings
     *
     * @return array Error messages strings
     */
    protected function detectBOSettings()
    {
        $id_lang = Context::getContext()->language->id;
        $output = array();
        if (Configuration::get('PS_DISABLE_OVERRIDES')) {
            $output[] = $this->l('Overrides are disabled. This module doesn\'t work without overrides. Go to').' "'.
                $this->getTabName('AdminTools', $id_lang).
                ' > '.
                $this->getTabName('AdminPerformance', $id_lang).
                '" '.$this->l('and make sure that the option').' "'.
                Translate::getAdminTranslation('Disable all overrides', 'AdminPerformance').
                '" '.$this->l('is set to').' "'.
                Translate::getAdminTranslation('No', 'AdminPerformance').
                '"'.$this->l('.').'<br />';
        }
        if (Configuration::get('PS_DISABLE_NON_NATIVE_MODULE')) {
            $output[] = $this->l('Non native modules such as this one are disabled. Go to').' "'.
                $this->getTabName('AdminTools', $id_lang).
                ' > '.
                $this->getTabName('AdminPerformance', $id_lang).
                '" '.$this->l('and make sure that the option').' "'.
                Translate::getAdminTranslation('Disable non PrestaShop modules', 'AdminPerformance').
                '" '.$this->l('is set to').' "'.
                Translate::getAdminTranslation('No', 'AdminPerformance').
                '"'.$this->l('.').'<br />';
        }
        return $output;
    }

    /**
     * Get Tab name from database
     *
     * @param $class string Class name of tab
     * @param $id_lang int Language id
     * @return string Returns the localized tab name
     */
    protected function getTabName($class, $id_lang)
    {
        if (empty($class) || empty($id_lang)) {
            return '';
        }

        $sql = new DbQuery();
        $sql->select('tl.`name`');
        $sql->from('tab', 't');
        $sql->innerJoin('tab_lang', 'tl', 't.`id_tab` = tl.`id_tab`');
        $sql->where('tl.`id_lang` = '.(int)$id_lang);
        $sql->where('t.`class_name` = \''.pSQL($class).'\'');

        return Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
    }
}
