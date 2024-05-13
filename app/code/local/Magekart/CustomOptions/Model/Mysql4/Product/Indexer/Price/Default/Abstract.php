<?php


if ((string)Mage::getConfig()->getModuleConfig('Innoexts_AdvancedPricing')->active == 'true'){
    class Magekart_CustomOptions_Model_Mysql4_Product_Indexer_Price_Default_Abstract extends Innoexts_AdvancedPricing_Model_Mysql4_Catalog_Product_Indexer_Price_Default {}
} else {
    class Magekart_CustomOptions_Model_Mysql4_Product_Indexer_Price_Default_Abstract extends Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Indexer_Price_Default {}
}