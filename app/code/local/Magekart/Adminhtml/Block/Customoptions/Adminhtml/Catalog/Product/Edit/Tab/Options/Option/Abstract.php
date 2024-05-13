<?php

if ((string)Mage::getConfig()->getModuleConfig('Aitoc_Aitoptionstemplate')->active == 'true'){
    class Magekart_Adminhtml_Block_Customoptions_Adminhtml_Catalog_Product_Edit_Tab_Options_Option_Abstract extends Aitoc_Aitoptionstemplate_Block_Rewrite_AdminhtmlCatalogProductEditTabOptionsOption {}
} else {
    class Magekart_Adminhtml_Block_Customoptions_Adminhtml_Catalog_Product_Edit_Tab_Options_Option_Abstract extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Options_Option {}
}