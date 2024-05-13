<?php

class BroSolutions_CustomOption_Model_Mysql4_Upload extends Mage_Core_Model_Mysql4_Abstract
{

    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_init('brocustomoption/upload', 'id');
    }
}

