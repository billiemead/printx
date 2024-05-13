<?php

class BroSolutions_CustomOption_Model_Product_Price extends Mage_Catalog_Model_Product_Type_Price
{
    
    protected $_percentFactor = 0;
    protected $_currentPrice = 0;
    /**
     * Apply options price
     *
     * @param Mage_Catalog_Model_Product $product
     * @param int $qty
     * @param float $finalPrice
     * @return float
     */
    protected function _applyOptionsPrice($product, $qty, $finalPrice)
    {
        $finishingData = new Varien_Object(array('versions'=>$qty));
        $finishing = array();
        if ($optionIds = $product->getCustomOption('option_ids')) {
            $options = array();
            foreach (explode(',', $optionIds->getValue()) as $optionId) {
                if ($option = $product->getOptionById($optionId)) {
                    $options[] = $option;
                }
            }
            $options = Mage::helper('brocustomoption')->sortOptions($options);
            
            $basePrice = $finalPrice;
            foreach ($options as $option) {
                    $confItemOption = $product->getCustomOption('option_'.$option->getId());

                    $group = $option->groupFactory($option->getType())
                        ->setOption($option)
                        ->setConfigurationItemOption($confItemOption);
                    $group->setPriceModel($this);
                    $group->setFinishingData($finishingData);
                    $group->setOptionValue($confItemOption->getValue());
                    if($group instanceof BroSolutions_CustomOption_Model_Product_Option_Type_Finishing){
                        $finishing[] = $group;
                        continue;
                    }
                    $price = $group->getOptionPrice($confItemOption->getValue(), $basePrice);
                    if(Mage::getStoreConfig('magekart_catalog/customoptions/rounding') != ''  ){
                        $price = round($price, Mage::getStoreConfig('magekart_catalog/customoptions/rounding'));
                    }
                    $finalPrice += $price;
                    $this->setCurrentPrice($finalPrice);
            }
            
           
            
            //Calculate percents
            $percentFactor = $this->getPercentFactor();
            $finalPrice = (($percentFactor/100)+1) * $finalPrice;
            
            //Add Finishing Options Prices
            foreach($finishing as $option){
                $finalPrice += $option->getFinishingOptionPrice();
            } 
        }

        return $finalPrice;
    }
    
    public function setPercentFactor($value)
    {
        $this->_percentFactor = $value;
        return $this;
    }
    
    
    public function getPercentFactor()
    {
        return $this->_percentFactor;
    }
    
    public function getCurrentPrice()
    {
        return $this->_currentPrice;
    }

    
    public function setCurrentPrice($value)
    {
        $this->_currentPrice = $value;
        return $this;
    }

}