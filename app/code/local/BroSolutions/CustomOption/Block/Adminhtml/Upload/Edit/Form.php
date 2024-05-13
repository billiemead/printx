<?php

class BroSolutions_CustomOption_Block_Adminhtml_Department_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
        /**
	 * Preperation of current form
	 *
	 * @return Mageplace_Backup_Block_Adminhtml_Profile_Edit_Form
	 */
	protected function _prepareForm()
	{
		$model = Mage::registry('printx_current_department');

		$form = new Varien_Data_Form();
		$form->setId('edit_form');
		$form->setAction($this->getSaveUrl());
		$form->setMethod('post');
		$form->setUseContainer(true);
		
                $form->addField('id', 'hidden', array('name' => 'id'));
                
                
		$form->addField('name', 'text', array(
                    'name'      => 'name',
                    'label'     => Mage::helper('brocustomoption')->__('Department Name'),
                    'title'     => Mage::helper('brocustomoption')->__('Department Name'),
                    'required'  => true,
                ));
                
                $form->addField('position', 'text', array(
                    'name'      => 'position',
                    'label'     => Mage::helper('brocustomoption')->__('Sort Order'),
                    'title'     => Mage::helper('brocustomoption')->__('Sort Order'),
                    'required'  => true,
                    'class'=>'validate-number',
                ));
		
		$form->setValues($model->getData());
		
		$this->setForm($form);

		return parent::_prepareForm();
	}

	public function getSaveUrl()
	{
		return $this->getUrl('*/*/save');
	}
}

