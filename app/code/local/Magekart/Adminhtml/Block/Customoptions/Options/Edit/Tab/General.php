<?php


class Magekart_Adminhtml_Block_Customoptions_Options_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        parent::_prepareForm();
        $form = new Varien_Data_Form();

        $form->addField('title', 'text', array(
            'label' => Mage::helper('customoptions')->__('Title'),
            'name' => 'general[title]',
            'index' => 'title',
            'required' => true
        ));

        $form->addField('is_active', 'select', array(
            'label' => Mage::helper('customoptions')->__('Status'),
            'name' => 'general[is_active]',
            'index' => 'is_active',
            'values' => Mage::helper('customoptions')->getOptionStatusArray()
        ));

        $session = Mage::getSingleton('adminhtml/session');
        if ($data = $session->getData('customoptions_data')) {
            $form->setValues($data['general']);
        } elseif (Mage::registry('customoptions_data')) {
            $form->setValues(Mage::registry('customoptions_data')->getData());
        }
        $this->setForm($form);

        return $this;
    }

}