<?php


class Magekart_Adminhtml_Block_Customoptions_Options_Edit_Tab_Options_Type_Select extends
    Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Options_Type_Select
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('customoptions/catalog-product-edit-options-type-select.phtml');
    }
}