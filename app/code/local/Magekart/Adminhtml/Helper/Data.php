<?php


class Magekart_Adminhtml_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getDateForFilename()
    {
        return Mage::getSingleton('core/date')->date('Y-m-d_H-i-s');
    }
}