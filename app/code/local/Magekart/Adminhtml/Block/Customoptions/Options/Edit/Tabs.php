<?php


class Magekart_Adminhtml_Block_Customoptions_Options_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId('customoptions_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle($this->_getHelper()->__('Options Information'));
    }

    protected function _beforeToHtml() {
        $helper = $this->_getHelper();
        $this->addTab('options_tab', array(
            'label' => $helper->__('Template Options'),
            'title' => $helper->__('Template Options'),
            'content' => $this->getLayout()->createBlock('magekart/customoptions_options_edit_tab_options', 'admin.product.options')->toHtml(),
            'active' => true,
        ));

        $this->addTab('product_tab', array(
            'label' => $helper->__('Products'),
            'title' => $helper->__('Products'),
            'content' => $this->getLayout()->createBlock('magekart/customoptions_options_edit_tab_product')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }

    private function _getHelper() {
        return Mage::helper('customoptions');
    }

}