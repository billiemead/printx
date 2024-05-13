<?php
class BroSolutions_CustomOption_Block_Adminhtml_Department_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
       public function __construct()
    {
        parent::__construct();
        $this->setId('prontx_department');
        $this->setUseAjax(true);
        $this->setDefaultSort('position');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }



    protected function _prepareCollection()
    {
        $collection = Mage::getModel('brocustomoption/department')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('id', array(
            'header'=> Mage::helper('brocustomoption')->__('Dept ID'),
            'width' => '80px',
            'type'  => 'text',
            'index' => 'id',
        ));

        $this->addColumn('position', array(
            'header'=> Mage::helper('brocustomoption')->__('Sort Order'),
            'width' => '80px',
            'type'  => 'text',
            'index' => 'position',
        ));

        
        $this->addColumn('name', array(
            'header'=> Mage::helper('brocustomoption')->__('Department Name'),
            'type'  => 'text',
            'index' => 'name',
        ));

        
        $this->addColumn('created_at', array(
            'header'=> Mage::helper('brocustomoption')->__('Date Added'),
            'width' => '80px',
            'type'  => 'text',
            'index' => 'created_at',
        ));
        
        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {

        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
