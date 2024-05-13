<?php

class BroSolutions_CustomOption_UploadController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
    
    
    public function itemsAction()
    {
        $orderId = $this->getRequest()->getParam('order_id');
        $order = Mage::getModel('sales/order')->load($orderId,'increment_id');
        $result = array('error'=>false);
        if(!$order->getId()){
            $result['error'] = 'The Order ID is Incorrect';
        }
        $result['items'] = '<label class="required" for="">Select Ordered Product: </label>';
        foreach($order->getAllVisibleItems() as $item){
            $result['items'] .= '<div> <input type="radio" name="item_id" class="item-id validate-one-required-by-name" value="'.$item->getId().'" />'.$item->getName().'</div>';
        }
        
        $this->getResponse()->setBody(json_encode($result));
    }
    
    
    public function uploadAction()
    {
        $helper = Mage::helper('brocustomoption/upload');
        //Check order details
        $orderId = $this->getRequest()->getParam('order_id');
        if(!$orderId){
            $error = 'The Order ID is Incorrect';
        }
        $order = Mage::getModel('sales/order')->load($orderId,'increment_id');
        if(!$order->getId()){
            $error = 'The Order ID is Incorrect';
        }else{
            $helper->setOption('order_id',$order->getIncrementId());
        }
        foreach($order->getAllItems() as $item){
            if($item->getId() == $_POST['item_id'])
                $selectedItem = $item;
        }
        
        if(!isset($selectedItem)){
            $error = 'Selected product is not available anymore';
        }
        
        if(Mage::getStoreConfig('printx_upload/customoptions/limited')){
            $allowed = explode(',',Mage::getStoreConfig('printx_upload/customoptions/order_status'));
            if(!in_array($order->getStatus(), $allowed)){
                $error = 'The order status does not allow to upload files';
            }
        }
        
        if($order->getCustomerEmail() != $this->getRequest()->getParam('email')){
            $error = 'The Email Address is Incorrect';
        }
        
        if(isset($error)){
            $helper->setError($error);
        }
        
        
        
        $helper->initialize();
        // as files are sent with few request - we will clear item only with next form request
        if(Mage::getSingleton( 'checkout/session' )->getFormActionId() != $_POST['action_id']){
            $collection = Mage::getModel('brocustomoption/upload')
                        ->getCollection()
                        ->addFieldToFilter('item_id',$_POST['item_id']);
                foreach($collection as $item){
                    $item->delete();
                }
            Mage::getSingleton( 'checkout/session' )->setFormActionId($_POST['action_id']);
        }
        if(!Mage::getSingleton('checkout/session')->getCurrentUploadedFileName()){
                foreach($helper->response['files'] as $file){
                    $model = Mage::getModel('brocustomoption/upload')
                            ->setData('filename',preg_replace('/\\'.DS.'$/','',Mage::getStoreConfig('printx_upload/customoptions/path')).DS.$file->name)
                            ->setData('original_filename',$file->origin_file_name)
                            ->setData('order_id',$order->getIncrementId())
                            ->setData('comment',htmlspecialchars($_POST['comment']))
                            ->setData('item_id',htmlspecialchars($_POST['item_id']))
                            ->setData('email',$order->getCustomerEmail())
                            ->setData('created_at',now())
                            ->setData('updated_at',now())
                            ->setPath(preg_replace('/\\'.DS.'$/','',Mage::getStoreConfig('printx_upload/customoptions/path')).DS)
                            ->setType(Mage::getStoreConfig('printx_upload/customoptions/type'))
                            ->save();
                    $orderItem = Mage::getModel('sales/order_item')->load($_POST['item_id']);
                    $orderItem->setUploadStatus('File(s) Uploaded');
                    $orderItem->save();
                }
        }
    }
    
    
    public function tempUploadAction()
    {
        
        Mage::register('helper_upload_dir',Mage::getBaseDir('media').DS.'catalog'.DS.'tmp'.DS);
        Mage::register('helper_upload_url',Mage::getBaseUrl('media').'catalog/tmp/');
        $helper = Mage::helper('brocustomoption/upload');
        if(isset($_POST['upload_option_ext']) && !empty($_POST['upload_option_ext'])){
            $data = explode(',', $_POST['upload_option_ext']);
            foreach($data as $key=>$val){
                $data[$key] = preg_quote($val);
            }
            $helper->setOption('accept_file_types','/\.('.implode('|',$data).')$/i');
        }
        
        if(isset($_POST['image_size_x']) && !empty($_POST['image_size_x'])){
            $helper->setOption('max_width',$_POST['image_size_x']);
        }
        
        if(isset($_POST['image_size_y']) && !empty($_POST['image_size_y'])){
            $helper->setOption('max_height',$_POST['image_size_y']);
        }
        $helper->setOption('script_url',Mage::getUrl('printx/upload/tempUpload'));    
        
        $helper->initialize();
        $quote = Mage::getSingleton('checkout/session');
        $uploadData = $quote->getData('upload_option_data'); 
        
        if(!$uploadData){
            $uploadData = array();
        }
        if(!isset($uploadData[$_POST['product']])){
            $uploadData[$_POST['product']] = array();
        }
        if(!Mage::getSingleton('checkout/session')->getCurrentUploadedFileName()){
            foreach($helper->response['files'] as $file){
                $uploadData[$_POST['product']][] = $file->name;
            }
            $quote->setData('upload_option_data',$uploadData);
        }
    }
}

