<?php

class BroSolutions_CustomOption_Block_Adminhtml_Catalog_Product_Edit_Tab_Options_Type_Finishing extends BroSolutions_CustomOption_Block_Adminhtml_Catalog_Product_Edit_Tab_Options_Type_Default
{
    public function getDepartmentsHtml()
    {
        $block = $this->getLayout()->createBlock('adminhtml/html_select')->setData(array('class' => 'select product-option-department select-type-title'));
        $block->setName('product[options][{{id}}][values][{{select_id}}][department]')
              ->setId('product_option_{{id}}_select_{{select_id}}_department')
              ->setOptions(Mage::getModel('brocustomoption/department')->getCollection()->toOptionArray());
        return $block->toHtml();
        
    }
    
    
    public function getFormulaListHtml()
    {
        $block = $this->getLayout()->createBlock('adminhtml/html_select')->setData(array('class' => 'select product-option-formula-list '));
        $block->setName('product[options][{{id}}][formula]')
              ->setId('product_option_{{id}}_formula')
              ->setOptions(Mage::getModel('brocustomoption/formula')->toOptionArray());
        $html = $block->toHtml();
        $html .= '<button style="" onclick="" class="scalable add add-select-row" type="button" title="Add Task" id="add_select_row_button_{{id}}"><span><span><span>Add New Row</span></span></span></button>';
        return $html;
    }
    
    public function getHelperHtml($formulaId)
    {
        $list = Mage::getModel('brocustomoption/formula')->getHelperText();
        $data = $list[$formulaId];
        $html = '<h1>Formula Name: '.$data['title'].'</h1>';
        $html .= '<h2>'.$data['subtitle'].'</h2>';
        $html .= '<p>'.$data['text'].'</p>';
        $html .= '<p><span style="font-weight: bold;">Formula Documentation: </span>'.$data['formula'].'</p>';
        
        return preg_replace("/\r|\n/", '', $html);
    }
}

