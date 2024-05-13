<?php

class BroSolutions_CustomOption_Model_Upload extends Mage_Core_Model_Abstract
{
     /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_init('brocustomoption/upload');
    }
    
    public function _afterDelete() {
        @unlink(Mage::getBaseDir('media').'/'.trim(Mage::getStoreConfig('printx_upload/customoptions/path'),'/').'/'.$this->getFilename());
        return parent::_afterDelete();
    }
    
    public function getDownloadFileUrl()
    {
        return Mage::getBaseUrl('media').trim(Mage::getStoreConfig('printx_upload/customoptions/path'),'/').'/'.$this->getFilename();
    }
}

