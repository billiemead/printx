<?php

class BroSolutions_CustomOption_Model_Mysql4_Paperstock extends Mage_Core_Model_Mysql4_Abstract
{

    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_init('brocustomoption/paperstock', 'id');
    }
}

