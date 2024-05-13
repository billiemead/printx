<?php

class BroSolutions_CustomOption_Block_Adminhtml_Catalog_Product_Edit_Tab_Options_Option extends Magekart_Adminhtml_Block_Customoptions_Adminhtml_Catalog_Product_Edit_Tab_Options_Option
{
        /**
     * Retrieve html templates for different types of product custom options
     *
     * @return string
     */
    public function getTemplatesHtml()
    {
        $canEditPrice = $this->getCanEditPrice();
        $canReadPrice = $this->getCanReadPrice();
        $this->getChild('select_option_type')
            ->setCanReadPrice($canReadPrice)
            ->setCanEditPrice($canEditPrice);

        $this->getChild('file_option_type')
            ->setCanReadPrice($canReadPrice)
            ->setCanEditPrice($canEditPrice);

        $this->getChild('date_option_type')
            ->setCanReadPrice($canReadPrice)
            ->setCanEditPrice($canEditPrice);

        $this->getChild('text_option_type')
            ->setCanReadPrice($canReadPrice)
            ->setCanEditPrice($canEditPrice);
        
        //Add Printed custom options
        $printedTypes = Mage::helper('brocustomoption')->getPrintedOptionTypes();
        foreach($printedTypes as $type=>$title){
            $this->setChild($type . '_option_type',
                    $this->getLayout()->createBlock(
                        (string) Mage::getConfig()->getNode('global/catalog/product/options/custom/groups/printing/types/' . $type . '/render')
                    )->setType($type)
                );
        }

        $templates = $this->getChildHtml('text_option_type') . "\n" .
            $this->getChildHtml('file_option_type') . "\n" .
            $this->getChildHtml('select_option_type') . "\n" .
            $this->getChildHtml('date_option_type');
        
        //Render printed option templates
        foreach($printedTypes as $type=>$title){
            $templates .= $this->getChildHtml($type . '_option_type')."\n";
        }

        return $templates;
    }
    
    
    public function getOptionValues() {                
        
        $optionsCollection = $this->getProduct()->getOptions();        
        // if option enabled = no && hasOptions = 0
        if (!$optionsCollection) $optionsCollection = $this->getProduct()->getProductOptionsCollection();
        
        
        if (!$this->_values) {
            $values = array();            
            $scope = (int) Mage::app()->getStore()->getConfig(Mage_Core_Model_Store::XML_PATH_PRICE_SCOPE);
            $helper = Mage::helper('customoptions');
            
            foreach ($optionsCollection as $option) {

                /* @var $option Mage_Catalog_Model_Product_Option */

                $this->setItemCount($option->getOptionId());                
                $value = array();

                $value['id'] = $option->getOptionId();
                $value['template_title'] = ($option->getGroupTitle())?$helper->__('Options Template:').' '.$option->getGroupTitle():'';
                $value['item_count'] = $this->getItemCount();
                $value['option_id'] = $option->getOptionId();
                $value['title'] = $this->htmlEscape($option->getTitle());
                $value['type'] = $option->getType();
                $value['is_require'] = $option->getIsRequire(true);
                $value['view_mode'] = $option->getViewMode();
                $value['is_dependent'] = $option->getIsDependent();
                $value['div_class'] = $option->getDivClass();
                $value['sku_policy'] = $option->getSkuPolicy();
                
                $value['formula'] = $option->getFormula();
                $value['weight_per_one'] = $option->getWeightPerOne();
                $value['use_custom_title'] = $option->getData('use_custom_title');
                $value['price_curve_type'] = $option->getData('price_curve_type');
                $value['internal_note'] = $option->getInternalNote();
                
                $value['customoptions_is_onetime'] = $option->getCustomoptionsIsOnetime();
                $value['qnty_input'] = ($option->getQntyInput()?'checked':'');
                $value['qnty_input_disabled'] = (($option->getType()=='multiple')?'disabled':'');
                
                
                $value['image_mode'] = $option->getImageMode();
                $value['image_mode_disabled'] = (($option->getGroupByType()!=Mage_Catalog_Model_Product_Option::OPTION_GROUP_SELECT)?'disabled':'');
                $value['exclude_first_image'] = ($option->getExcludeFirstImage()?'checked':'');
                
                
                $value['sort_order'] = $option->getSortOrder();
                $value['image_button_label'] = ($option->getImagePath()?$helper->__('Change Image'):$helper->__('Add Image'));
                
                $value['description'] = $this->htmlEscape($option->getDescription());
                if ($helper->isCustomerGroupsEnabled() && $option->getCustomerGroups() != null) {
                    $value['customer_groups'] = $option->getCustomerGroups();
                }
                
                $value['in_group_id'] = $option->getInGroupId();
                $value['in_group_id_view'] = $this->getViewIGI($option->getInGroupId());
                
                

                if ($this->getProduct()->getStoreId() != '0') {
                    $value['checkboxScopeTitle'] = $this->getCheckboxScopeHtml($option->getOptionId(), 'title', is_null($option->getStoreTitle()));
                    $value['scopeTitleDisabled'] = is_null($option->getStoreTitle()) ? 'disabled' : null;
                    
                    $value['checkboxScopeViewMode'] = $this->getCheckboxScopeHtml($option->getOptionId(), 'view_mode', is_null($option->getStoreViewMode()));
                    $value['scopeViewModeDisabled'] = is_null($option->getStoreViewMode()) ? 'disabled' : null;
                    
                    $value['checkboxScopeDescription'] = $this->getCheckboxScopeHtml($option->getOptionId(), 'description', is_null($option->getStoreDescription()));
                    $value['scopeDescriptionDisabled'] = is_null($option->getStoreDescription()) ? 'disabled' : null;
                }

                $connection = Mage::getSingleton('core/resource')->getConnection('core_write');
                $tablePrefix = (string) Mage::getConfig()->getTablePrefix();

                $select = $connection->select()->from($tablePrefix . 'custom_options_relation')->where('option_id = ' . $option->getOptionId());
                $relation = $connection->fetchRow($select);

                if ($option->getGroupByType()==Mage_Catalog_Model_Product_Option::OPTION_GROUP_SELECT || $option->getGroupByType()==Magekart_CustomOptions_Model_Catalog_Product_Option::OPTION_GROUP_PRINTED) {
                    $i = 0;
                    $itemCount = 0;
                    foreach ($option->getValues() as $_value) {
                        /* @var $_value Mage_Catalog_Model_Product_Option_Value */
                        
                        $dependentIds = array();
                        $dependentIdsTmp = explode(',', $_value->getDependentIds());                        
                        foreach ($dependentIdsTmp as $d_id) {
                            $dependentIds[] = $this->getViewIGI($d_id);
                        }
                        $unserialised = @unserialize($_value->getData('serialised_values'));
                        if($unserialised){
                            $_value->addData($unserialised);
                        }
                        
                        list($price, $priceType, $isSkuPrice, $taxClassId, $oldPrice) = $helper->getOptionPriceAndPriceType($_value->getPrice(), $_value->getPriceType(), $_value->getSku(), $this->getProduct()->getStore());
                        if ($isSkuPrice && $helper->isSkuPriceLinkingEnabled()) {
                            $priceDisabled = true;
                            if ($helper->isSpecialPriceEnabled()) {
                                if ($oldPrice) {
                                    $_value->setSpecialPrice($price);
                                    $price = $oldPrice;
                                } else {
                                    $_value->setSpecialPrice('');
                                }
                            }
                        } else {
                            $priceDisabled = false;
                        }
                        $price = $this->getPriceValue($price, $priceType);
                        $value['optionValues'][$i] = array(
                            'item_count' => max($itemCount, $_value->getOptionTypeId()),
                            'option_id' => $_value->getOptionId(),
                            'option_type_id' => $_value->getOptionTypeId(),
                            'title' => $this->htmlEscape($_value->getTitle()),
                            'price' => $this->getPriceValue($price, $priceType),
                            'price_type' => $priceType,
                            'special_price' => $_value->getSpecialPrice()?$this->getPriceValue($_value->getSpecialPrice(), $priceType):'',
                            'special_comment' => $_value->getSpecialComment(),
                            'price_disabled' => $priceDisabled,
                            'customoptions_qty' => $helper->getCustomoptionsQty($_value->getCustomoptionsQty(), $_value->getSku()),
                            'customoptions_qty_disabled' => $helper->getProductIdBySku($_value->getSku())?'disabled="disabled"':'',
                            'sku' => $this->htmlEscape($_value->getSku()),
                            'sku_class' => $_value->getSku() && $helper->getProductIdBySku($_value->getSku())==0?'red':'',
                            'image_button_label' => $helper->__('Add Image'),
                            'sort_order' => $_value->getSortOrder(),
                            'checked' => $_value->getDefault() != 0 ? 'checked' : '',
                            'default_type' => (($option->getType()=='checkbox' || $option->getType()=='multiple' || $option->getType()=='multiswatch') ? 'checkbox' : 'radio'),
                            'in_group_id' => $_value->getInGroupId(),
                            'in_group_id_view' => $this->getViewIGI($_value->getInGroupId()),
                            'dependent_ids' => implode(',', $dependentIds),
                            'weight' => $_value->getWeight()
                        );
                        
                        $allData = @unserialize($_value->getData('serialised_values'));
                        $allData = (is_array($allData)?$allData:array());
                        $dataToAdd = $_value->getData();
                        //remove images (cause it been doubled)
                        unset($dataToAdd['images']);
                        $value['optionValues'][$i] = $value['optionValues'][$i] + $dataToAdd + $allData;
                        
                        if($option->getType() == 'finishing'){
                            $value['optionValues'][$i]['price'] = $allData['price'];
                        }
                        
                        // getImages
                        $images = $_value->getImages();
                        if ($images) {
                            foreach($images as $image) {
                                if ($image['source']==1) { // file
                                    $imgArr = $helper->getImgHtml($image['image_file'], $option->getId(), $_value->getOptionTypeId(), true);
                                    if ($imgArr) {
                                        $imgArr['option_type_image_id'] = $image['option_type_image_id'];
                                        $imgArr['source'] = $image['source'];
                                        $value['optionValues'][$i]['images'][] = $imgArr;
                                    }
                                } elseif ($image['source']==2) { // color
                                    $colorArr = $image;
                                    $colorArr['id'] = $option->getId();
                                    $colorArr['select_id'] = $_value->getOptionTypeId();                                    
                                    $value['optionValues'][$i]['images'][] = $colorArr;
                                }
                            }
                        } else {
                            $value['optionValues'][$i]['image_tr_style'] = 'display:none';
                        }
                                                
                        //getOptionValueTierPrices                        
                        $tierPrices = $_value->getTiers();
                        if ($tierPrices) {
                            foreach ($tierPrices as $qty=>$tierPrice) {                                
                                $tierPrices[$qty]['price'] = $this->getPriceValue($tierPrice['price'], $tierPrice['price_type']);
                            }                            
                            $value['optionValues'][$i]['tiers'] = $tierPrices;   
                        } else {
                            $value['optionValues'][$i]['tier_price_tr_style'] = 'display:none';
                        }

                        if ($this->getProduct()->getStoreId() != '0') {
                            $value['optionValues'][$i]['checkboxScopeTitle'] = $this->getCheckboxScopeHtml($_value->getOptionId(), 'title', is_null($_value->getStoreTitle()), $_value->getOptionTypeId());
                            $value['optionValues'][$i]['scopeTitleDisabled'] = is_null($_value->getStoreTitle()) ? 'disabled' : null;
                            
                            if ($scope==Mage_Core_Model_Store::PRICE_SCOPE_WEBSITE) {
                                if (!$priceDisabled) $value['optionValues'][$i]['checkboxScopePrice'] = $this->getCheckboxScopeHtml($_value->getOptionId(), 'price', is_null($_value->getStorePrice()), $_value->getOptionTypeId());
                                $value['optionValues'][$i]['scopePriceDisabled'] = is_null($_value->getStorePrice()) ? 'disabled' : null;
                            }
                        }
                        $i++;
                    }
                } else {
                    list($price, $priceType, $isSkuPrice, $taxClassId, $oldPrice) = $helper->getOptionPriceAndPriceType($option->getPrice(), $option->getPriceType(), $option->getSku(), $this->getProduct()->getStore());
                    if ($isSkuPrice && $helper->isSkuPriceLinkingEnabled()) {
                        $priceDisabled = true;
                    } else {
                        $priceDisabled = false;
                    }
                    
                    $value['price'] = $this->getPriceValue($price, $priceType);
                    $value['price_type'] = $priceType;
                    $value['price_disabled'] = $priceDisabled;
                    $value['sku'] = $this->htmlEscape($option->getSku());
                    $value['max_characters'] = $option->getMaxCharacters();
                    $value['default_text'] = $this->htmlEscape($option->getDefaultText());
                    $value['file_extension'] = $option->getFileExtension();
                    $value['image_size_x'] = $option->getImageSizeX();
                    $value['image_size_y'] = $option->getImageSizeY();
                    
                    $imgHtml = $helper->getImgHtml($option->getImagePath(), $option->getId());
                    if ($imgHtml) $value['image'] = $imgHtml;
                                        
                    if ($this->getProduct()->getStoreId()!='0' && $scope == Mage_Core_Model_Store::PRICE_SCOPE_WEBSITE) {                        
                        if (!$priceDisabled) $value['checkboxScopePrice'] = $this->getCheckboxScopeHtml($option->getOptionId(), 'price', is_null($option->getStorePrice()));
                        $value['scopePriceDisabled'] = is_null($option->getStorePrice()) ? 'disabled' : null;
                        $value['checkboxScopeDefaultText'] = $this->getCheckboxScopeHtml($option->getOptionId(), 'default_text', is_null($option->getStoreDefaultText()));
                        $value['scopeDefaultTextDisabled'] = is_null($option->getStoreDefaultText()) ? 'disabled' : null;
                    }
                }
                $values[] = new Varien_Object($value);
            }
            $this->_values = $values;
        }
        return $this->_values;
    }
    
}