<?php

class BroSolutions_CustomOption_Block_Adminhtml_Customoptions_Options_Edit_Tab_Options_Option extends Magekart_Adminhtml_Block_Customoptions_Options_Edit_Tab_Options_Option
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
}