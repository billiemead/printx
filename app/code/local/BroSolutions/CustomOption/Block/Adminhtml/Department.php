<?php
class BroSolutions_CustomOption_Block_Adminhtml_Department extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'brocustomoption';
        $this->_controller = 'adminhtml_department';
        $this->_headerText = Mage::helper('sales')->__('Edit Department');
        $this->_addButtonLabel = Mage::helper('sales')->__('Create New Department');
        parent::__construct();
    }
}
