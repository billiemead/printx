<?php

class Magekart_CustomOptions_Model_Mysql4_Product_Option_Value extends Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Option_Value
{
    
    public function duplicate(Mage_Catalog_Model_Product_Option_Value $object, $oldOptionId, $newOptionId) {
        $select = $this->_getReadAdapter()->select()
            ->from($this->getMainTable())
            ->where('option_id=?', $oldOptionId);
        $valueData = $this->_getReadAdapter()->fetchAll($select);

        $valueCond = array();

        foreach ($valueData as $data) {
            $optionTypeId = $data[$this->getIdFieldName()];
            unset($data[$this->getIdFieldName()]);
            $data['option_id'] = $newOptionId;

            $this->_getWriteAdapter()->insert($this->getMainTable(), $data);
            $valueCond[$optionTypeId] = $this->_getWriteAdapter()->lastInsertId();
        }

        unset($valueData);

        foreach ($valueCond as $oldTypeId => $newTypeId) {
            // price
            $table = $this->getTable('catalog/product_option_type_price');
            $tierTable = $this->getTable('customoptions/option_type_tier_price');
            $select = $this->_getReadAdapter()->select()
                ->from($table)
                ->where('option_type_id=?', $oldTypeId);
            $priceData = $this->_getReadAdapter()->fetchAll($select);
            
            foreach ($priceData as $data) {
                $oldOptionTypePriceId = $data['option_type_price_id'];
                unset($data['option_type_price_id']);
                $data['option_type_id'] = $newTypeId;

                $this->_getWriteAdapter()->insert($table, $data);
                $newOptionTypePriceId = $this->_getWriteAdapter()->lastInsertId();
                
                // tier price
                $sql = 'REPLACE INTO `' . $tierTable . '` '
                    . 'SELECT NULL, ' . $newOptionTypePriceId . ', `qty`, `price`, `price_type`'
                    . 'FROM `' . $tierTable . '` WHERE `option_type_price_id`=' . $oldOptionTypePriceId;
                $this->_getWriteAdapter()->query($sql);
            }
            
            // title
            $table = $this->getTable('catalog/product_option_type_title');
            $sql = 'REPLACE INTO `' . $table . '` '
                . 'SELECT NULL, ' . $newTypeId . ', `store_id`, `title`'
                . 'FROM `' . $table . '` WHERE `option_type_id`=' . $oldTypeId;
            $this->_getWriteAdapter()->query($sql);
            
            // images price
            $table = $this->getTable('customoptions/option_type_image');
            $sql = 'REPLACE INTO `' . $table . '` '
                . 'SELECT NULL, ' . $newTypeId . ', `image_file`, `sort_order`, `source`'
                . 'FROM `' . $table . '` WHERE `option_type_id`=' . $oldTypeId;
            $this->_getWriteAdapter()->query($sql);
            
        }

        return $object;
    }
    
}
