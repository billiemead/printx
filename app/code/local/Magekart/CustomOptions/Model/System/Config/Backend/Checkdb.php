<?php


class Magekart_CustomOptions_Model_System_Config_Backend_Checkdb extends Mage_Core_Model_Config_Data
{
    protected function _afterSave() {        
        try {                
            // check db setup
            $resource = Mage::getSingleton('core/resource');
            $connection = $resource->getConnection('core_write');
            if (!$connection->tableColumnExists($resource->getTableName('catalog/product_option'), 'image_mode')) {
                $connection->delete($resource->getTableName('core/resource'), "code =  'customoptions_setup'");
            }
        } catch (Exception $e) {}        
    }
}
