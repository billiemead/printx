<?php


class Magekart_CustomOptions_Model_Relation extends Mage_Core_Model_Abstract {

    protected function _construct() {
        parent::_construct();
        $this->_init('customoptions/relation');
    }

    public function changeOptionsStatus(Varien_Object $group) {
        $optionIds = $this->getResource()->getOptionIds($group->getId());
        if ($optionIds) {
            foreach ($optionIds as $id) {
                $this->getResource()->setOptionsStatus($id, $group->getIsActive());
            }
        }
    }

    public function changeHasOptions(array $groups) {
        if ($groups) {
            $productOptionModel = Mage::getModel('catalog/product_option');
            foreach ($groups as $groupId => $group) {
                $productIds = $this->getResource()->getProductIds($groupId);
                if ($productIds) {
                    foreach ($productIds as $productId) {
                        $productOptionModel->updateProductFlags($productId, $group->getAbsolutePrice(), $group->getAbsoluteWeight());
                    }
                }
            }
        }
    }

}
