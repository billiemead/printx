<?php

class Magekart_Adminhtml_Block_Customoptions_Options_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct() {
        $this->_objectId = 'group_id';
        $this->_blockGroup = 'magekart';
        $this->_controller = 'customoptions_options';
        $helper = Mage::helper('customoptions');

        parent::__construct();

        $this->_updateButton('save', '', array(
            'label' => $helper->__('Save'),
            'onclick' => 'saveOptionsForm()',
            'class' => 'save',
            'sort_order' => 10
            ), 1);

        $this->_updateButton('delete', '', array(
            'label' => $helper->__('Delete'),
            'onclick' => "deleteConfirm('{$helper->__('If you delete this item(s) all the options inside will be deleted as well?')}', '{$this->getUrl('*/*/delete', array('group_id' => (int) $this->getRequest()->getParam('group_id')))}')",
            'class' => 'delete',
            'sort_order' => 10
        ));

        $this->_addButton('duplicate', array(
            'label' => $helper->__('Duplicate'),
            'onclick' => "location.href='{$this->getUrl('*/*/duplicate', array('group_id' => (int) $this->getRequest()->getParam('group_id')))}'",
            'class' => 'duplicate',
            'sort_order' => 10
        ));

        $this->_addButton('saveandcontinue', array(
            'label' => $helper->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
            'sort_order' => 10
                ), -100);

        $this->_formScripts[] = "
            function saveOptionsForm() {
                applySelectedProducts('save')
            }
            function saveAndContinueEdit() {
                applySelectedProducts('saveandcontinue')
            }
        ";
    }

    public function getHeaderText() {
        if (Mage::registry('customoptions_data') && Mage::registry('customoptions_data')->getId()) {
            return Mage::helper('customoptions')->__("Edit Template '%s'", $this->htmlEscape(Mage::registry('customoptions_data')->getTitle()));
        } else {
            return Mage::helper('customoptions')->__('New Options Template');
        }
    }

}