<?php

class BroSolutions_CustomOption_Model_System_Config_Source_Rounding
{
    public function toOptionArray()
    {
        $groups = array(
            array('value' => '', 'label' => Mage::helper('adminhtml')->__('-- Please select --'))
        );

        for($i = -8; $i<=4;$i++){
            $groups[] = array(
                'label' => $i.' decimal places',
                'value' => $i
            );
        }

        return $groups;
    }
}

