<?php


class Magekart_Adminhtml_Block_Customoptions_Abstract extends Mage_Adminhtml_Block_Template
{
    protected function getStoreId()
    {
        return Mage::registry('store_id');
    }

    public function isSingleStoreMode()
    {
        if (!Mage::app()->isSingleStoreMode()) {
               return false;
        }
        return true;
    }
}