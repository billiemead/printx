<?php


class Magekart_CustomOptions_Model_Sales_Quote_Total extends Mage_Tax_Model_Sales_Total_Quote_Subtotal
{

    public function __construct() {
        $this->setCode('customoptions');
    }
    
    public function collect(Mage_Sales_Model_Quote_Address $address) {        
        $helper = Mage::helper('customoptions');
        if (!$helper->isEnabled() || !$helper->isSkuPriceLinkingEnabled()) return $this;
        if ($address->getSubtotal()==0) return $this;
        
        $items = $this->_getAddressItems($address);
        if (!$items) return $this;
        
        $quote = $address->getQuote();
        
        $address->setSubtotalInclTax(0);
        $address->setBaseSubtotalInclTax(0);
        $address->setTotalAmount('subtotal', 0);
        $address->setBaseTotalAmount('subtotal', 0);
        
        $totalDiffTax = 0;
        foreach ($items as $item) {
            $diffTax = 0;
            $product = $item->getProduct();
            // if bad magento))
            if (is_null($product->getHasOptions())) $product->load($product->getId());
            
            if (($product->getTypeId()=='simple' || $product->getTypeId()=='configurable' || $product->getTypeId()=='virtual' || $product->getTypeId()=='downloadable') && $product->getHasOptions()) {
                $store = $product->getStore();
                $post = $product->getCustomOption('info_buyRequest')->getValue();
                if ($post) $post = unserialize ($post); else $post = array();            
                if (isset($post['options'])) $options = $post['options']; else $options = array();

                $qty = $item->getQty();

                if ($options) {
                    foreach ($options as $optionId => $option) {
                        $productOption = Mage::getSingleton('catalog/product_option')->load($optionId);
                        $optionType = $productOption->getType();
                        switch ($optionType) {
                            case 'field':
                            case 'area':
                            case 'file':
                            case 'date':
                            case 'date_time':
                            case 'time':
                                if (!$productOption->getSku()) continue;
                                $optionTotalQty = ($productOption->getCustomoptionsIsOnetime()?1:$qty);
                                list($price, $priceType, $isSkuPrice, $taxClassId) = $helper->getOptionPriceAndPriceType(0, 'fixed', $productOption->getSku(), $store);
                                if (!$isSkuPrice || $product->getTaxClassId()==$taxClassId) continue;
                                $price = $price * $optionTotalQty;
                                $tax1 = $helper->getTaxPrice($price, $quote, $product->getTaxClassId(), $address);
                                $tax2 = $helper->getTaxPrice($price, $quote, $taxClassId, $address);
                                $diffTax += $tax2 - $tax1;
                                break;
                            case 'checkbox':
                            case 'drop_down':
                            case 'radio':
                            case 'multiple':
                            case 'swatch':
                            case 'multiswatch':
                                if (!is_array($option)) $option = array($option);
                                foreach ($option as $optionTypeId) {
                                    if (!$optionTypeId) continue;
                                    $row = $productOption->getOptionValue($optionTypeId);
                                    if (!isset($row['sku']) || !$row['sku']) continue;


                                    // get total option qty
                                    switch ($optionType) {
                                        case 'checkbox':
                                        case 'multiswatch':
                                            if (isset($post['options_'.$optionId.'_'.$optionTypeId.'_qty'])) $optionQty = intval($post['options_'.$optionId.'_'.$optionTypeId.'_qty']); else $optionQty = 1;
                                            break;
                                        case 'drop_down':
                                        case 'radio':
                                        case 'swatch':    
                                            if (isset($post['options_'.$optionId.'_qty'])) $optionQty = intval($post['options_'.$optionId.'_qty']); else $optionQty = 1;
                                            break;
                                        case 'multiple':
                                            $optionQty = 1;
                                            break;
                                    }
                                    $optionTotalQty = ($productOption->getCustomoptionsIsOnetime()?$optionQty:$optionQty*$qty);

                                    list($price, $priceType, $isSkuPrice, $taxClassId) = $helper->getOptionPriceAndPriceType(0, 'fixed', $row['sku'], $store);
                                    if (!$isSkuPrice || $product->getTaxClassId()==$taxClassId) continue;
                                    $price = $price * $optionTotalQty;
                                    $tax1 = $helper->getTaxPrice($price, $quote, $product->getTaxClassId(), $address);
                                    $tax2 = $helper->getTaxPrice($price, $quote, $taxClassId, $address);
                                    $diffTax += $tax2 - $tax1;
                                }
                                break;
                        }
                    }
                    if ($diffTax) {
                        // convert basePrice - to price
                        $storeDiffTax = $store->convertPrice($diffTax, false, false);

                        $item->setBasePriceInclTax($item->getBasePriceInclTax() + ($diffTax / $qty)); // $diffTax/produt qty
                        $item->setPriceInclTax($item->getPriceInclTax() + ($storeDiffTax / $qty)); // $diffTax/produt qty

                        $item->setBaseRowTotalInclTax($item->getBaseRowTotalInclTax() + $diffTax);
                        $item->setRowTotalInclTax($item->getRowTotalInclTax() + $storeDiffTax);
                        
                        $item->setBaseTaxAmount($item->getBaseTaxAmount() + $diffTax);
                        $item->setTaxAmount($item->getTaxAmount() + $storeDiffTax);
                        
                        $totalDiffTax += $diffTax;
                    }
                }
            }
            $this->_addSubtotalAmount($address, $item);
        }
        
        if ($totalDiffTax) {
            $totalStoreDiffTax = $store->convertPrice($totalDiffTax, false, false);
            
            $address->setBaseTaxAmount($address->getBaseTaxAmount() + $totalDiffTax);
            $address->setTaxAmount($address->getTaxAmount() + $totalStoreDiffTax);  

            $address->setBaseGrandTotal($address->getBaseGrandTotal() + $totalDiffTax);
            $address->setGrandTotal($address->getGrandTotal() + $totalStoreDiffTax);
        }
        
        return $this;
    }
}