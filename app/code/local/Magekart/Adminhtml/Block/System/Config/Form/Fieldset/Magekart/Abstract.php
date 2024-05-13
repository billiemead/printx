<?php


class Magekart_Adminhtml_Block_System_Config_Form_Fieldset_Magekart_Abstract
	extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
{

    protected function _getFooterHtml($element)
    {
        $html = parent::_getFooterHtml($element);
        $html .= Mage::helper('adminhtml/js')->getScript("
            $$('td.form-buttons')[0].update('');
            $('{$element->getHtmlId()}' + '-head').setStyle('background: none;');
            $('{$element->getHtmlId()}' + '-head').writeAttribute('onclick', 'return false;');
            $('{$element->getHtmlId()}').show();
        ");
        return $html;
    }
}
