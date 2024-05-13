<?php

class BroSolutions_CustomOption_DepartmentController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
    
    public function newAction()
    {
        $this->editAction();
    }
    
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id',null);
        $model = Mage::getModel('brocustomoption/department');
        if($id){
            $model->load($id);
        }
        Mage::register('printx_current_department', $model);
        $this->loadLayout();
        $this->renderLayout();
    }
    
    
    public function saveAction()
    {
       $id = $this->getRequest()->getParam('id',null);
       $model = Mage::getModel('brocustomoption/department');
       if($id){
            $model->load($id);
        }
        $data = $this->getRequest()->getPost();
        unset($data['id']);
        $model->addData($data);
        if($model->isObjectNew()){
            $model->setCreatedAt(now());
        }else{
            $model->setUpdatedAt(now());
        }
        $model->save();
        $this->_getSession()->addSuccess('The Department has been successfully saved');
        
        $this->_redirect('*/*/index');
    }
    
    
    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('id',null);
       $model = Mage::getModel('brocustomoption/department');
       if($id){
            $model->load($id);
        }
        $model->delete();
        $this->_getSession()->addSuccess('The Department was successfully deleted');
        
        $this->_redirect('*/*/index');
    }
}
