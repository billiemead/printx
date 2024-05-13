<?php


class Magekart_Customoptions_Model_System_Config_Source_Sku_Policy {
    public function toOptionArray($isAll = false) {
        $helper = Mage::helper('customoptions');
        $options = array(            
            array('value' => 1, 'label'=>$helper->__('Standard')),
            array('value' => 2, 'label'=>$helper->__('Independent')),
            array('value' => 3, 'label'=>$helper->__('Grouped')),
            array('value' => 4, 'label'=>$helper->__('Replacement')),
        );        
        if ($isAll) array_unshift($options, array('value' => 0, 'label'=>$helper->__('Default')));
        return $options;
    }

}