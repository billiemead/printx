<?php


class Magekart_CustomOptions_Model_Catalog_Product_Option_Type_Select extends Mage_Catalog_Model_Product_Option_Type_Select {
    
    public function getOptionPrice($optionValue, $basePrice, $qty = 0, $optionQtyArr = 1, $store=null) {
        $option = $this->getOption();
        $result = 0;                

        if (!$this->_isSingleSelection()) {
            foreach(explode(',', $optionValue) as $value) {
                if ($opValue = $option->getValueById($value)) {   
                    
                    $optionQty = (!is_array($optionQtyArr)?$optionQtyArr:$optionQtyArr[$value]);
                    
                   
                    if ($option->getCustomoptionsIsOnetime()) $optionTotalQty =  $optionQty; else $optionTotalQty = $optionQty * $qty;
                    // apply tier price
                    list($optionPrice, $optionPriceType) = Mage::helper('customoptions')->getOptionTierPriceAndType($opValue, $optionTotalQty, $store);
                    
                    if($this->getOption()->getData('price_curve_type') == 2){
                        $optQty = $this->getFinishingData()->getQty();
                        $opValue->addData(@unserialize($opValue->getData('serialised_values')));
                        $curves = $opValue->getData('price_curve');
                        $optionPrice = isset($curves[$optQty])?$curves[$optQty] : $optionPrice;
                    } elseif($this->getOption()->getData('price_curve_type') == 3){
                        $optionQty = $this->getFinishingData()->getQty();
                        $opValue->addData(@unserialize($opValue->getData('serialised_values')));
                        $optionPrice = isset($curves[$optionQty])?$curves[$optionQty] : $optionPrice;
                    }
                    
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
                
                $optQty = $this->getFinishingData()->getQty();
                $opValue->addData(@unserialize($opValue->getData('serialised_values')));
                
                if ($option->getCustomoptionsIsOnetime()) $optionTotalQty =  $optionQty; else $optionTotalQty = $optionQty * $qty;
                list($optionPrice, $optionPriceType) = Mage::helper('customoptions')->getOptionTierPriceAndType($opValue, $optionTotalQty, $store);
                
                if($this->getOption()->getData('price_curve_type') == 2){
                    $curves = $opValue->getData('price_curve');
                    $optionPrice = isset($curves[$optQty])?$curves[$optQty] : $optionPrice;
                } elseif($this->getOption()->getData('price_curve_type') == 3){
                    $curves = $opValue->getData('price_curve');
                    foreach($curves as $key=>$val){
                        list($min, $max) = explode('-', $key);
                        if($optQty>=$min*1 && ($optQty<=$max || $max*1 == 0)){
                            $optionPrice = $val*1;
                        }
                    }
                }
                
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

        return $result;
    }
    
    protected function _getCustomOptionsChargableOptionPrice($price, $isPercent, $basePrice, $qty = 1, $customoptionsIsOnetime = 0, $optionQty = 1) {        
        if ($customoptionsIsOnetime) $sub = $qty; else $sub = 1;
        if ($sub==0 || $price==0 || $optionQty==0) return 0;    
        
        
        
        if ($isPercent) {
            if(is_object($priceModel = $this->getPriceModel())){
                //we will calculate percents after all prices will be calculated
                //$priceModel->setPercentFactor($priceModel->getPercentFactor() + $price);
                //we will caclualte price percent right now
                return ($priceModel->getCurrentPrice()/100*$price) * $optionQty;
            } else {
                if ($basePrice==0) return 0;
                return ($basePrice * $price * $optionQty / 100) / $sub;
            }
        } else {
            return $price * $optionQty / $sub;
        }
    }
    
    protected function _isSingleSelection() {
        $_single = array(
            Mage_Catalog_Model_Product_Option::OPTION_TYPE_DROP_DOWN,
            Mage_Catalog_Model_Product_Option::OPTION_TYPE_RADIO,
            Magekart_CustomOptions_Model_Catalog_Product_Option::OPTION_TYPE_SWATCH
        ) + Mage::helper('brocustomoption')->getSelectTypes();
        
        return (in_array($this->getOption()->getType(), $_single) || in_array($this->getOption()->getType(), Mage::helper('brocustomoption')->getSelectTypes()));
    }

}