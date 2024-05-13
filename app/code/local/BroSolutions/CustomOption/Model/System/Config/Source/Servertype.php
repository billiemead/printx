<?php

class BroSolutions_CustomOption_Model_System_Config_Source_Servertype
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'local', 'label' => Mage::helper('adminhtml')->__('Local Server')),
           // array('value' => 'ftp', 'label' => Mage::helper('adminhtml')->__('FTP Server')),
        );

    }
}

