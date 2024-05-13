<?php

class BroSolutions_CustomOption_Model_Product_Option_Type_Finishing extends Magekart_CustomOptions_Model_Catalog_Product_Option_Type_Select
{
        public function getFinishingOptionPrice() {
        $option = $this->getOption();
        $data = $this->getFinishingData();
        $formulaId = $option->getFormula();
        $value = $this->getOptionValue();
        $opValue = $option->getValueById($value);
        $data->addData(@unserialize($opValue->getData('serialised_values')));
        $result = 0;                
        
        $formula = Mage::getModel('brocustomoption/formula');

        $result = $formula->calculate($formulaId, $data);
        if(Mage::getStoreConfig('magekart_catalog/customoptions/rounding') != ''  ){
            $result = round($result, Mage::getStoreConfig('magekart_catalog/customoptions/rounding'));
        }
        return $result;
    }
}

