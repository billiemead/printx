<?php


class Magekart_Customoptions_Model_System_Config_Source_Sku_Apply {
    public function toOptionArray() {
        $helper = Mage::helper('customoptions');
        $options = array(            
            array('value' => 1, 'label'=>$helper->__('Order Only')),
            array('value' => 2, 'label'=>$helper->__('Cart and Order')),
        );        
        return $options;
    }

}