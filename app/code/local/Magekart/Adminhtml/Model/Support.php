<?php


class Magekart_Adminhtml_Model_Support extends Varien_Object
{
    const XML_PATH_SUPPORT_EMAIL = 'magekart/support/email';
    const XML_PATH_SUPPORT_NAME = 'magekart/support/name';
    const XML_PATH_SUPPORT_EMAIL_TEMPLATE = 'magekart/support/template';

    public function send()
    {
        $translate = Mage::getSingleton('core/translate');
        /* @var $translate Mage_Core_Model_Translate */
        $translate->setTranslateInline(false);

        $errors = array();

        $this->_emailModel = Mage::getModel('core/email_template');
        $subject = $this->getSubject();
        $message = $this->getMessage();
        $reason  = $this->getReason();
        $version = Mage::getVersion();
        $url     = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
        $sender  = array(
            'name' => strip_tags($this->getName()),
            'email' => strip_tags($this->getEmail())
        );

        $this->_emailModel->setDesignConfig(array('area'=>'admin'))
            ->sendTransactional(
                Mage::getStoreConfig(self::XML_PATH_SUPPORT_EMAIL_TEMPLATE),
                $sender,
                base64_decode(Mage::getStoreConfig(self::XML_PATH_SUPPORT_EMAIL)),
                Mage::getStoreConfig(self::XML_PATH_SUPPORT_NAME),
                array(
                    'reason'        => $reason,
                    'subject'		=> $subject,
                    'message'		=> $message,
                    'version'       => $version,
                    'url'           => $url,
                )
        );
        $translate->setTranslateInline(true);

        return $this;
    }
}