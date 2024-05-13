<?php

class BroSolutions_CustomOption_UploadcenterController extends Mage_Adminhtml_Controller_Action
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
        $model = Mage::getModel('brocustomoption/upload');
        if($id){
            $model->load($id);
        }
        Mage::register('printx_current_upload', $model);
        $this->loadLayout();
        $this->renderLayout();
    }
    
    
    public function saveAction()
    {
       $id = $this->getRequest()->getParam('id',null);
       $model = Mage::getModel('brocustomoption/upload');
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
        $this->_getSession()->addSuccess('The File has been successfully saved');
        
        $this->_redirect('*/*/index');
    }
    
    
    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('id',null);
       $model = Mage::getModel('brocustomoption/upload');
       if($id){
            $model->load($id);
        }
        $model->delete();
        $this->_getSession()->addSuccess('The File has been successfully deleted');
        
        $this->_redirect('*/*/index');
    }
    
    
    public function massDeleteAction()
    {
        $ids = $this->getRequest()->getParam('ids');
        $session    = Mage::getSingleton('adminhtml/session');

        if(!is_array($ids)) {
             $session->addError(Mage::helper('adminhtml')->__('Please select review(s).'));
        } else {
            try {
                foreach ($ids as $id) {
                    $model = Mage::getModel('brocustomoption/upload')->load($id);
                    $model->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) have been deleted.', count($ids))
                );
            } catch (Mage_Core_Exception $e) {
                $session->addError($e->getMessage());
            } catch (Exception $e){
                $session->addException($e, Mage::helper('adminhtml')->__('An error occurred while deleting record(s).'.$e->getMessage()));
            }
        }

        $this->_redirect('*/*/' . $this->getRequest()->getParam('ret', 'index'));
    }
}
