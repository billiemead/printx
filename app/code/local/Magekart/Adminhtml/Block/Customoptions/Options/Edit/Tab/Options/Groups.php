<?php


class Magekart_Adminhtml_Block_Customoptions_Options_Edit_Tab_Options_Groups extends Mage_Adminhtml_Block_Widget_Form {
    protected function _prepareForm() {
        if (Mage::helper('customoptions')->isEnabled()) {
            $product = Mage::registry('product');
            if ($product->getTypeId() == 'bundle' && $product->getPriceType() == 0) {
                return $this;
            }
            $values = Mage::getSingleton('customoptions/group')->getStoreValues($product->getStoreId());            

            $form = new Varien_Data_Form();
            $form->addField('customoptions_groups', 'multiselect', array(
                //'label' => Mage::helper('customoptions')->__('Options Templates'),
                'title' => Mage::helper('customoptions')->__('Options Templates'),
                'name' => 'customoptions[groups][]',
                'values' => $values,
                'value' => Mage::getResourceSingleton('customoptions/relation')->getGroupIds($product->getId()),
                'style' => 'width: 280px; height: 112px;',
            ));
            $this->setForm($form);
        }    

        return parent::_prepareForm();
    }

}