<?php


class Magekart_CustomOptions_Model_System_Config_Source_Image_Mode {
    public function toOptionArray() {
        $helper = Mage::helper('customoptions');
        return array(
            array('value' => 1, 'label'=>$helper->__('Beside Option')),
            array('value' => 2, 'label'=>$helper->__('Replace Product Gallery')),
            array('value' => 3, 'label'=>$helper->__('Append to Product Gallery'))
        );
    }

}