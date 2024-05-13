<?php

class BroSolutions_CustomOption_Block_Adminhtml_Catalog_Product_Edit_Tab_Options_Type_Default  extends Magekart_Adminhtml_Block_Customoptions_Adminhtml_Catalog_Product_Edit_Tab_Options_Type_Select
{
    /*
     * Define templates depends on type
     */
    public function setType($type)
    {
        $this->setTemplate('brosolutions/custom_options/type/'.$type.'.phtml');
        return $this;
    }
}

