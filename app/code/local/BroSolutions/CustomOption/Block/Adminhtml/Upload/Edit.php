<?php

class BroSolutions_CustomOption_Block_Adminhtml_Department_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    protected $_objectId = 'id';
    protected $_blockGroup = 'brocustomoption';
    protected $_controller = 'adminhtml_department';
    
     public function __construct()
    {
        parent::__construct();

        
        
        $this->_updateButton('save', 'label', $this->__('Save Department'));
        $this->_updateButton('delete', 'label', $this->__('Delete Department'));
    }
}

