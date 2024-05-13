<?php

class Magekart_Adminhtml_Block_System_Config_Edit extends Mage_Adminhtml_Block_System_Config_Edit
{
    public function __construct()
    {
        parent::__construct();
        $sectionCode = $this->getRequest()->getParam('section');
        $sections = Mage::getSingleton('adminhtml/config')->getSections();
        $session = Mage::getSingleton('admin/session');
        if (false !== strpos($sectionCode, 'magekart')){
            $groups = $this->_section->groups[0];
            foreach ($groups as $group => $object){
                if (!$session->isAllowed("system/config/$sectionCode/$group")){
                    $sections->$sectionCode->groups->$group = null;
                }
            }
        }
        $this->_section = $sections->$sectionCode;
        $this->setTitle((string)$this->_section->label);
    }
}