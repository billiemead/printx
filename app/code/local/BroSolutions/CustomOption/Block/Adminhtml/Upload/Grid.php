<?php
class BroSolutions_CustomOption_Block_Adminhtml_Upload_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
       public function __construct()
    {
        parent::__construct();
        $this->setId('prontx_upload');
        $this->setUseAjax(true);
        $this->setDefaultSort('order_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }



    protected function _prepareCollection()
    {
        $collection = Mage::getModel('brocustomoption/upload')->getCollection();
        $collection->getSelect()->joinLeft(array('item'=>'sales_flat_order_item'),'item.item_id = main_table.item_id',array('name','sku'));
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('order_id', array(
            'header'=> Mage::helper('brocustomoption')->__('Order #'),
            'width' => '80px',
            'type'  => 'text',
            'index' => 'order_id',
        ));

        $this->addColumn('sku', array(
            'header'=> Mage::helper('brocustomoption')->__('SKU'),
            'width' => '80px',
            'type'  => 'text',
            'index' => 'sku',
        ));
        
        
        $this->addColumn('name', array(
            'header'=> Mage::helper('brocustomoption')->__('Product Name'),
            'width' => '80px',
            'type'  => 'text',
            'index' => 'name',
        ));

        
        $this->addColumn('original_filename', array(
            'header'=> Mage::helper('brocustomoption')->__('Original Filename'),
            'type'  => 'text',
            'index' => 'original_filename',
        ));

        
        $this->addColumn('filename', array(
            'header'=> Mage::helper('brocustomoption')->__('New Filename'),
            'width' => '80px',
            'type'  => 'text',
            'index' => 'filename',
        ));
        
        $this->addColumn('comment', array(
            'header'=> Mage::helper('brocustomoption')->__('Additional Comments'),
            'width' => '80px',
            'type'  => 'text',
            'index' => 'comment',
        ));
        
        $this->addColumn('email', array(
            'header'=> Mage::helper('brocustomoption')->__('Customer E-Mail'),
            'width' => '80px',
            'type'  => 'text',
            'index' => 'email',
        ));
        
        
        $this->addColumn('updated_at', array(
            'header'=> Mage::helper('brocustomoption')->__('Updated at'),
            'width' => '80px',
            'type'  => 'text',
            'index' => 'updated_at',
        ));
        
        $this->addColumn('download', array(
            'header'    => Mage::helper('backup')->__('Download'),
            'format'    => '<a target="_blank" href="' . Mage::getBaseUrl('media').'$filename'
                . '">Download</a>',
            'index'     => 'type',
            'sortable'  => false,
            'filter'    => false
        ));
        
        
        
        return parent::_prepareColumns();
    }
    
     /**
     * Prepare mass action controls
     *
     * @return Mage_Adminhtml_Block_Backup_Grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('ids');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'=> Mage::helper('adminhtml')->__('Delete'),
             'url'  => $this->getUrl('*/*/massDelete'),
             'confirm' => Mage::helper('backup')->__('Are you sure you want to delete the selected file(s)?')
        ));

        return $this;
    }

    public function getRowUrl($row)
    {

        return false;
    }

}
