<?php


class Magekart_CustomOptions_Model_Group_Store extends Mage_Core_Model_Abstract {

    protected function _construct() {
        parent::_construct();
        $this->_init('customoptions/group_store');
    }
    
    public function loadByGroupAndStore($groupId, $storeId) {
	$this->getResource()->loadByGroupAndStore($this, $groupId, $storeId);
        return $this;
    }
    

}
