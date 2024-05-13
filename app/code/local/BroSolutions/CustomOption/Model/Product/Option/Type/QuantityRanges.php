<?php

class BroSolutions_CustomOption_Model_Product_Option_Type_QuantityRanges extends Magekart_CustomOptions_Model_Catalog_Product_Option_Type_Select
{
    
    public function getOptionPrice($optionValue, $basePrice, $qty = 0, $optionQtyArr = 1, $store=null) {
        $option = $this->getOption();
        $result = 0;                

        $this->getFinishingData()->setQty($optionValue);
        foreach($option->getValues() as $value){
            $unserialised = @unserialize($value->getSerialisedValues());
            if(is_array($unserialised)){
                $value->addData($unserialised);
            }
            if($value->getLow()<=$optionValue && ($optionValue <= $value->getHigh() || !$value->getHigh())){
                $result = $optionValue * $value->getPrice();
            }
        }
//        if(Mage::getStoreConfig('magekart_catalog/customoptions/rounding') != ''  ){
//            $result = round($result, Mage::getStoreConfig('magekart_catalog/customoptions/rounding'));
//        }
        return $result;
    }  
    
    
        /**
     * Return SKU for selected option
     *
     * @param string $optionValue Prepared for cart option value
     * @param string $skuDelimiter Delimiter for Sku parts
     * @return string
     */
    public function getOptionSku($optionValue, $skuDelimiter)
    {
        return $this->getOption()->getSku();
    }
    
    
    /**
     * Validate user input for option
     *
     * @throws Mage_Core_Exception
     * @param array $values All product option values, i.e. array (option_id => mixed, option_id => mixed...)
     * @return Mage_Catalog_Model_Product_Option_Type_Default
     */
    public function validateUserValue($values)
    {
        Mage::getSingleton('checkout/session')->setUseNotice(false);

        $this->setIsValid(false);

        $option = $this->getOption();
        if (!isset($values[$option->getId()]) && $option->getIsRequire() && !$this->getSkipCheckRequiredOption()) {
            Mage::throwException(Mage::helper('catalog')->__($option->getTitle()));
            Mage::throwException(Mage::helper('catalog')->__('Please specify the product required option(s).'));
        } elseif (isset($values[$option->getId()])) {
            $this->setUserValue($values[$option->getId()]);
            $this->setIsValid(true);
        }

        $option = $this->getOption();
        $value = $this->getUserValue();

        if (empty($value) && $option->getIsRequire() && !$this->getSkipCheckRequiredOption()) {
            $this->setIsValid(false);
            Mage::throwException(Mage::helper('catalog')->__($option->getTitle()));
            Mage::throwException(Mage::helper('catalog')->__('Please specify the product required option(s).'));
        }

        return $this;
    }
    
    
    public function getPrintableOptionValue($optionValue) {
        parent::getPrintableOptionValue($optionValue);
    }
    
    
    public function getFormattedOptionValue($optionValue)
    {
        if ($this->_formattedOptionValue === null) {
            $this->_formattedOptionValue = Mage::helper('core')->escapeHtml($optionValue);
        }
        return $this->_formattedOptionValue;
    }
}

