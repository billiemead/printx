<?php

class Magekart_Adminhtml_Block_Customoptions_Adminhtml_Catalog_Product_Edit_Tab_Options_Type_File extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Options_Type_File {

    public function __construct() {
        parent::__construct();
        if (!Mage::helper('customoptions')->isEnabled()) return $this;
        $this->setTemplate('customoptions/catalog-product-edit-options-type-file.phtml');
    }

    protected function _prepareLayout() {
        $this->setChild('add_select_row_button',
                        $this->getLayout()->createBlock('adminhtml/widget_button')
                        ->setData(array(
                            'label' => Mage::helper('catalog')->__('Add New Row'),
                            'class' => 'add add-select-row',
                            'id' => 'add_select_row_button_{{option_id}}',
                        ))
        );

        $this->setChild('delete_select_row_button',
                        $this->getLayout()->createBlock('adminhtml/widget_button')
                        ->setData(array(
                            'label' => Mage::helper('catalog')->__('Delete Row'),
                            'class' => 'delete delete-select-row icon-btn',
                        ))
        );

        $this->setChild('add_image_button',
                        $this->getLayout()->createBlock('adminhtml/widget_button')
                        ->setData(array(
                            'label' => Mage::helper('customoptions')->__('Add Image'),
                            'class' => 'add disabled',
                            'id' => 'new-option-file-{{option_id}}',
                            'onclick' => ' productOptionTypeFile.createFileField(this.id)',
                            'disabled' => true
                        )));

        return parent::_prepareLayout();
    }

    public function getAddImageButtonHtml() {
        return $this->getChildHtml('add_image_button');
    }

}