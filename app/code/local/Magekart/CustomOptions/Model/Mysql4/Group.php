<?php


class Magekart_CustomOptions_Model_Mysql4_Group extends Mage_Core_Model_Mysql4_Abstract {

    protected function _construct() {
        $this->_init('customoptions/group', 'group_id');
    }

    protected function _beforeSave(Mage_Core_Model_Abstract $object) {
//        if (!$object->getId()) {
//            $object->setStoreId($this->getStoreId());
//        }
        if (!$this->isUniqueGroup($object)) {
            Mage::throwException(Mage::helper('customoptions')->__("Options Title '%s' already exist", $object->getTitle()));
        }
        return parent::_beforeSave($object);
    }

    public function getOnlyHashOptions($groupId) {
        $select = $this->_getReadAdapter()->select()
                        ->from($this->getMainTable(), 'hash_options')
                        ->where($this->getIdFieldName() . ' = ?', $groupId);

        return $this->_getReadAdapter()->fetchOne($select);
    }

    public function isUniqueGroup(Mage_Core_Model_Abstract $object) {
        $title = trim($object->getTitle());
        if (!empty($title)) {
            $select = $this->_getReadAdapter()->select()
                            ->from($this->getMainTable(), $this->getIdFieldName())
                            ->where('title = ?', $title);
                            //->where('store_id = ?', $object->getStoreId());

            if ($object->getId()) {
                $select->where($this->getIdFieldName() . ' <> ?', $object->getId());
            }
            if ($this->_getReadAdapter()->fetchRow($select)) {
                return false;
            }
        }
        return true;
    }

    protected function _afterLoad(Mage_Core_Model_Abstract $object) {
        $productIds = '';
        if ($object->getId()) {
            $product = Mage::getResourceSingleton('customoptions/relation')->getProductIds($object->getId());
            if ($product) {
                $productIds = implode(',', $product);
            }
            $object->setInProducts($productIds);
        }
        
        //print_r($object->getData()); exit;
        
        return parent::_afterLoad($object);
    }

    protected function _beforeDelete(Mage_Core_Model_Abstract $object) {
        Mage::getSingleton('catalog/product_option')->removeProductOptions($object->getId());
        Mage::getResourceSingleton('customoptions/relation')->deleteGroup($object->getId());

        return parent::_beforeDelete($object);
    }

}