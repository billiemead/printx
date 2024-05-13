<?php

class Magekart_Adminhtml_Block_Customoptions_Options extends Magekart_Adminhtml_Block_Customoptions_Abstract {

    protected function _prepareLayout() {
        $this->setChild('add_new_button', $this->getLayout()->createBlock('adminhtml/widget_button')
                        ->setData(array(
                            'label' => Mage::helper('customoptions')->__('Add Options Template'),
                            'onclick' => "setLocation('" . $this->getUrl('*/*/new', array('store' => $this->getStoreId())) . "')",
                            'class' => 'add'
                        ))
        );
        $this->setChild('grid', $this->getLayout()->createBlock('magekart/customoptions_options_grid', 'customoptions.grid'));

        return parent::_prepareLayout();
    }

    public function getAddNewButtonHtml() {
        return $this->getChildHtml('add_new_button');
    }

    public function getGridHtml() {
        return $this->getChildHtml('grid');
    }

}