<?php

class Magekart_Adminhtml_Block_Customoptions_Adminhtml_Catalog_Product_Edit_Tab_Options extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Options {

    public function __construct() {
        parent::__construct();
        if (!Mage::helper('customoptions')->isEnabled()) return $this;
        $this->setTemplate('customoptions/catalog-product-edit-options.phtml');
    }

    protected function _prepareLayout() {
        $this->setChild('general_box', $this->getLayout()->createBlock('magekart/customoptions_options_edit_tab_options_groups'));
        return parent::_prepareLayout();
    }

    public function isPredefinedOptions() {
        return true;
    }

}