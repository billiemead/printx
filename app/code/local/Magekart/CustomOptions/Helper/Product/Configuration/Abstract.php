<?php


if ((string)Mage::getConfig()->getModuleConfig('GoMage_Procart')->active == 'true'){
    class Magekart_CustomOptions_Helper_Product_Configuration_Abstract extends GoMage_Procart_Helper_Product_Configuration {}
} else {
    class Magekart_CustomOptions_Helper_Product_Configuration_Abstract extends Mage_Catalog_Helper_Product_Configuration {}
}