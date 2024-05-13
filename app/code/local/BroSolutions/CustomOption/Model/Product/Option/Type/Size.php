<?php

class BroSolutions_CustomOption_Model_Product_Option_Type_Size extends Magekart_CustomOptions_Model_Catalog_Product_Option_Type_Select
{
     /*   public function getOptionPrice($optionValue, $basePrice, $qty = 0, $optionQtyArr = 1, $store=null) {
        $option = $this->getOption();
        $result = 0;                

        if (!$this->_isSingleSelection()) {
            foreach(explode(',', $optionValue) as $value) {
                if ($opValue = $option->getValueById($value)) {        
                    
                    $opValue->addData(@unserialize($opValue->getData('serialised_values')));
                    if(!$this->getFinishingData()){
                        $e = new Exception('ok');
                        Mage::logException($e);
                    }
                    $this->getFinishingData()->setFinishW($opValue->getFinishw());
                    $this->getFinishingData()->setFinishH($opValue->getFinishh());
                    $this->getFinishingData()->setRunW($opValue->getRunw());
                    $this->getFinishingData()->setRunH($opValue->getRunh());
                    
                    $optionQty = (!is_array($optionQtyArr)?$optionQtyArr:$optionQtyArr[$value]);
                    if ($option->getCustomoptionsIsOnetime()) $optionTotalQty =  $optionQty; else $optionTotalQty = $optionQty * $qty;
                    // apply tier price
                    list($optionPrice, $optionPriceType) = Mage::helper('customoptions')->getOptionTierPriceAndType($opValue, $optionTotalQty, $store);
                    $result += $this->_getCustomOptionsChargableOptionPrice(
                        $optionPrice,
                        $optionPriceType == 'percent',
                        $basePrice,
                        $qty,
                        $option->getCustomoptionsIsOnetime(),
                        $optionQty
                    );
                } else {
                    if ($this->getListener()) {
                        $this->getListener()
                                ->setHasError(true)
                                ->setMessage(
                                    Mage::helper('catalog')->__('Some of the products below do not have all the required options. Please remove them and add again with all the required options.')
                                );
                        break;
                    }
                }
            }
        } elseif ($this->_isSingleSelection()) {
            $optionQty = $optionQtyArr;
            if ($opValue = $option->getValueById($optionValue)) {
                if ($option->getCustomoptionsIsOnetime()) $optionTotalQty =  $optionQty; else $optionTotalQty = $optionQty * $qty;
                list($optionPrice, $optionPriceType) = Mage::helper('customoptions')->getOptionTierPriceAndType($opValue, $optionTotalQty, $store);
                $result = $this->_getCustomOptionsChargableOptionPrice(
                    $optionPrice,
                    $optionPriceType == 'percent',
                    $basePrice,
                    $qty,
                    $option->getCustomoptionsIsOnetime(),
                    $optionQty
                );
            } else {
                if ($this->getListener()) {
                    $this->getListener()
                            ->setHasError(true)
                            ->setMessage(
                                Mage::helper('catalog')->__('Some of the products below do not have all the required options. Please remove them and add again with all the required options.')
                            );
                }
            }
        }

        if(Mage::getStoreConfig('magekart_catalog/customoptions/rounding') != ''  ){
            $result = round($result, Mage::getStoreConfig('magekart_catalog/customoptions/rounding'));
        }
        return $result;
    } */

}

