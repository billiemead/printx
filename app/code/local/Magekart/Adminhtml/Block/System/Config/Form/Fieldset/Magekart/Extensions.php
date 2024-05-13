<?php


class Magekart_Adminhtml_Block_System_Config_Form_Fieldset_Magekart_Extensions
	extends Magekart_Adminhtml_Block_System_Config_Form_Fieldset_Magekart_Abstract
{
	protected $_dummyElement;
	protected $_fieldRenderer;
	protected $_values;

    public function render(Varien_Data_Form_Element_Abstract $element)
    {
		$html = $this->_getHeaderHtml($element);

		$modules = array_keys((array)Mage::getConfig()->getNode('modules')->children());

		sort($modules);

        foreach ($modules as $moduleName) 
		{
            $name = explode('_', $moduleName, 2);
        	if (!isset($name) || $name[0] != 'Magekart') {
        		continue;
        	}
			if($moduleName == 'Magekart_Adminhtml')
			{
                continue;
            }
        	$html.= $this->_getFieldHtml($element, $moduleName);
        }
        $html .= $this->_getFooterHtml($element);

        return $html;
    }

    protected function _getFieldRenderer()
    {
    	if (empty($this->_fieldRenderer)) {
    		$this->_fieldRenderer = Mage::getBlockSingleton('adminhtml/system_config_form_field');
    	}
    	return $this->_fieldRenderer;
    }

    protected function _getFooterHtml($element)
    {
        $html = parent::_getFooterHtml($element);
        $html = '<h4>' . $this->__('Installed PrintX Extensions') . '</h4>' . $html;

        return $html;
    }

    protected function _getFieldHtml($fieldset, $moduleName)
    {
    	$moduleConfig = Mage::getConfig()->getNode('modules/' . $moduleName);

        $field = $fieldset->addField($moduleName, 'label',
            array(
                'name'          => $moduleName,
                'label'         => $moduleConfig->extension_name,
                'value'         => 'v' . $moduleConfig->version,
            ))->setRenderer($this->_getFieldRenderer());

		return $field->toHtml();
    }
}
