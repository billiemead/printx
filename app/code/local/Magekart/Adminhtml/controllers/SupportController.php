<?php


class Magekart_Adminhtml_SupportController extends  Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $data = $this->getRequest()->getPost();
        $support = Mage::getModel('magekart/support');
        $support
            ->setName($data['name'])
            ->setEmail($data['email'])
            ->setSubject($data['subject'])
            ->setReason(isset($data['other_reason'])?$data['other_reason']:$data['reason'])
            ->setMessage($data['message']);
        try {
            $support->send();
        } catch (Exception $e) {
            $result['message'] = $e->getMessage();
            $this->_ajaxResponse($result);
            return;
        }
        $result['message'] = $this->__('Message Sent to PrintX');
        $this->_ajaxResponse($result);
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('system/config/magekart/support');
    }

    protected function _ajaxResponse($result = array())
    {
        $this->getResponse()->setBody(Zend_Json::encode($result));
        return;
    }

}