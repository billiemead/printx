<?php


class Magekart_CustomOptions_Model_System_Config_Source_View_Mode {
    public function toOptionArray() {
        $helper = Mage::helper('customoptions');
        return array(
            array('value' => 1, 'label'=>$helper->__('Visible')),
            array('value' => 3, 'label'=>$helper->__('Backend')),
            array('value' => 2, 'label'=>$helper->__('Hidden')),
            array('value' => 0, 'label'=>$helper->__('Disable'))
        );
    }

}