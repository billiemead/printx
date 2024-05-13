<?php

class BroSolutions_CustomOption_Model_Observer extends Varien_Object
{
    public function hookIntoCatalogProductNewAction($observer)
    {
        $product = $observer->getEvent()->getProduct();
        if($product->getTypeID() != 'printed')
            return $this;
        $product->setPrice('0.00');
        $product->setWeight('0.00');
        $product->lockAttribute('price');
        $product->lockAttribute('weight');
        return $this;    	
    }
    
    public function hookIntoCatalogProductEditAction($observer)
    {
        $product = $observer->getEvent()->getProduct();
        if($product->getTypeID() != 'printed')
            return $this;        
        $product->setPrice('0.00');
        $product->setWeight('0.00');
        $product->lockAttribute('price');
        $product->lockAttribute('weight');
        return $this;    	
    }      
    
    
    /**
     * Move files to upload center
     * @param type $event
     */
    public function salesOrderPlaceAfter($observer)
    {
        $order = $observer->getEvent()->getOrder();
        $quote = $order->getQuote();
        $tmpDir = Mage::getBaseDir('media').DS.'catalog'.DS.'tmp'.DS;
        $path = Mage::getBaseDir('media').DS.preg_replace('/\\'.DS.'$/','',Mage::getStoreConfig('printx_upload/customoptions/path')).DS;
        
        
        foreach($order->getAllItems() as $orderItem){
            $numfiles = 0;
            $uploadData = Mage::getSingleton('checkout/session')->getData('upload_option_data'); 
            if(!$uploadData)
                $uploadData = array();
            
            foreach($quote->getAllItems() as $item){
                if($item->getId() != $orderItem->getQuoteItemId())
                    continue;
                
            $product = $item->getProduct();
            $optionIds = $item->getOptionByCode('option_ids');
            if ($optionIds) {
                    foreach (explode(',', $optionIds->getValue()) as $optionId) {
                        $option = $product->getOptionById($optionId);
                        if ($option && $option->getType() == 'file_upload') {
                            $quoteOption = $item->getOptionByCode('option_'.$optionId);
                            $value = $option->getValueById($quoteOption->getValue());
                            $data = @unserialize($value->getData('serialised_values'));
                            if(isset($data['numfiles'])){
                                $numfiles = $data['numfiles'];
                            }
                        }
                    }
                }
            }
            $uploadedFiles = 0;
            //Save 
            foreach($uploadData as $productId => $files){
                if($productId != $item->getProductId())
                    continue;
                
                $uploadedFiles = count($files);
                foreach($files as $file){
                    if(!file_exists($tmpDir.$file))
                            continue;
                    $fileName = $this->getUniqueFilename($path, $order->getIncrementId().'.'.pathinfo($file,PATHINFO_EXTENSION));
                    if(rename($tmpDir.$file, $path.$fileName)){
                        $model = Mage::getModel('brocustomoption/upload')
                                ->setData('filename',$fileName)
                                ->setData('original_filename',$file)
                                ->setData('order_id',$order->getIncrementId())
                                ->setData('item_id',$orderItem->getId())
                                ->setData('email',$order->getCustomerEmail())
                                ->setData('created_at',now())
                                ->setData('updated_at',now())
                                ->setPath($path)
                                ->setType(Mage::getStoreConfig('printx_upload/customoptions/type'))
                                ->save();
                        $uploaded = true;
                   }
                }
            }
            
            if($uploadedFiles>=$numfiles){
                $status = 'File(s) Uploaded';
            } elseif($numfiles == 0){
                $status = 'No Files Needed';
            } else {
                $status = 'Need Files';
            }
            $orderItem->setUploadStatus($status);
            $orderItem->save();
        }
        
        Mage::getSingleton('checkout/session')->setData('upload_option_data',null);
    }
    
    protected function getUniqueFilename($path, $filename){
        if ($pos = strrpos($filename, '.')) {
               $name = substr($filename, 0, $pos);
               $ext = substr($filename, $pos);
        } else {
               $name = $filename;
        }

        $newpath = $path.'/'.$filename;
        $newname = $filename;
        $counter = 0;
        while (file_exists($newpath)) {
               $newname = $name .'_'. $counter . $ext;
               $newpath = $path.'/'.$newname;
               $counter++;
         }

        return $newname;
    }
    
    
    public function uploadFTP()
    {
        $messages = true;
        $ftpstatus = 2;
        $server =   Mage::getStoreConfig('printx_upload/customoptions/ftp_server');
        $port =     Mage::getStoreConfig('printx_upload/customoptions/ftp_port');
        $username = trim(Mage::getStoreConfig('printx_upload/customoptions/ftp_login')) ? trim(Mage::getStoreConfig('printx_upload/customoptions/ftp_login')) : 'anonymous';
        $password = trim(Mage::getStoreConfig('printx_upload/customoptions/ftp_password'));
        $path =     trim(Mage::getStoreConfig('printx_upload/customoptions/ftp_path'));
        $usessl =   0;

        if (!empty($server) && !empty($port) && !empty($username)) {
            if ($usessl) {
                if (function_exists('ftp_ssl_connect')) {
                    $conn = @ftp_ssl_connect($server, (int) $port, 15);
                } else {
                    if ($messages)
                        Mage::throwException(Mage::helper('dmc_erpintegration')->__('No FTP-SSL functions found.'));
                }
            } else {
                if (function_exists('ftp_connect')) {
                    $conn = @ftp_connect($server, (int) $port, 15);
                } else {
                    if ($messages)
                        Mage::throwException(Mage::helper('dmc_erpintegration')->__('No FTP functions found.'));
                }
            }
            if ($conn) {
                if (@ftp_login($conn, $username, $password)) {
                    $files = Mage::getModel('brocustomoption/upload')
                        ->getCollection()
                        ->addFieldToFilter('type','ftp')
                        ->addFieldToFilter('uploaded','0');
                    foreach ($files as $file) {
                        $fpath = $path;
                        $remotePath = rtrim($fpath, '/') .'/'. $file['filename'];

                        if(!is_file($file->getPath().$file>getFilename()))
                                continue;
                        
                        $temp = fopen($file->getPath().$file>getFilename(),'r');

                        if (@ftp_fput($conn, $remotePath, $temp, FTP_BINARY)) {
                            $ftpstatus = 1;
                        }
                        if ($ftpstatus == 1 && $messages){
                            Mage::getSingleton('adminhtml/session')->addSuccess('Uploaded successfully to FTP server.');
                            unlink($file->getPath().$file>getFilename());
                            $file->setUploaded(1)->save();
                        } else if ($ftpstatus == 2)
                            Mage::throwException(Mage::helper('brocustomoption')->__("Could not upload to '" . $remotePath . " to FTP server."));
                        fclose($temp);
                    }
                } else {
                    if ($messages)
                        Mage::throwException(Mage::helper('brocustomoption')->__('Wrong login for FTP-Server.'));
                    return false;
                }
                ftp_quit($conn);
            } else {
                Mage::throwException(Mage::helper('brocustomoption')->__('Could not connect to FTP-Server.'));
                return false;
            }
        }
        return true;
    }
    
    
    
}
