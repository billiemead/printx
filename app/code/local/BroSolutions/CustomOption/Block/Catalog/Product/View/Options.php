<?php

class BroSolutions_CustomOption_Block_Catalog_Product_View_Options extends Mage_Catalog_Block_Product_View_Options 
{
       /**
     * Get json representation of
     *
     * @return string
     */
    public function getJsonConfig()
    {
        $config = array();

        foreach ($this->getOptions() as $option) {
            /* @var $option Mage_Catalog_Model_Product_Option */
            $priceValue = 0;
            if ($option->getGroupByType() == Mage_Catalog_Model_Product_Option::OPTION_GROUP_SELECT) {
                $_tmpPriceValues = array();
                foreach ($option->getValues() as $value) {
                    /* @var $value Mage_Catalog_Model_Product_Option_Value */
                    $id = $value->getId();
                    $_tmpPriceValues[$id] = $this->_getPriceConfiguration($value);
                }
                $priceValue = $_tmpPriceValues;
            } else {
                $priceValue = $this->_getPriceConfiguration($option);
            }
            $config[$option->getId()] = $priceValue;
        }

        return Mage::helper('core')->jsonEncode($config);
    }
    
    /**
     * Get price configuration
     *
     * @param Mage_Catalog_Model_Product_Option_Value|Mage_Catalog_Model_Product_Option $option
     * @return array
     */
    protected function _getPriceConfiguration($option)
    {
        $data = array();
        //$data['price']      = Mage::helper('core')->currency($option->getPrice(true), false, false);
        $data['price'] = ($option->getPriceType() != 'percent') ? Mage::helper('core')->currency($option->getPrice(true), false, false) : $option->getPrice();
        $data['is_percentage'] = ($option->getPriceType() == 'percent');
        $data['oldPrice']   = Mage::helper('core')->currency($option->getPrice(false), false, false);
        $data['priceValue'] = $option->getPrice(false);
        $data['type']       = $option->getPriceType();
        $data['excludeTax'] = $price = Mage::helper('tax')->getPrice($option->getProduct(), $data['price'], false);
        $data['includeTax'] = $price = Mage::helper('tax')->getPrice($option->getProduct(), $data['price'], true);
        return $data;
    }    
    
    
     /**
     * Get product options
     * add sorting
     * @return array
     */
    public function getOptions()
    {
        $options = $this->getProduct()->getOptions();
        $options = Mage::helper('brocustomoption')->sortOptions($options);        
        
        return $options;
    }
    

    
    

}

