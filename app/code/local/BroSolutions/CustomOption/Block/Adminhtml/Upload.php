<?php
class BroSolutions_CustomOption_Block_Adminhtml_Upload extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'brocustomoption';
        $this->_controller = 'adminhtml_upload';
        $this->_headerText = Mage::helper('sales')->__('File/Asset Management');
        parent::__construct();
        $this->_removeButton('add');
    }
}
