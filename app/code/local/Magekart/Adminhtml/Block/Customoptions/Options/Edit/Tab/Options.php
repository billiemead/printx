<?php


class Magekart_Adminhtml_Block_Customoptions_Options_Edit_Tab_Options extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Options {

    public function __construct() {
        parent::__construct();
        $this->setTemplate('customoptions/catalog-product-edit-options.phtml');
    }

    protected function _prepareLayout() {
        parent::_prepareLayout();

        $this->setChild('general_box', $this->getLayout()->createBlock('magekart/customoptions_options_edit_tab_general'));
        $this->setChild('options_box', $this->getLayout()->createBlock('magekart/customoptions_options_edit_tab_options_option'));
        $this->getChild('options_box')->getChild('select_option_type');//->setTemplate('customoptions/options-edit-tab-options-type-select.phtml');

        return $this;
    }

    public function isPredefinedOptions() {
        return false;
    }

}