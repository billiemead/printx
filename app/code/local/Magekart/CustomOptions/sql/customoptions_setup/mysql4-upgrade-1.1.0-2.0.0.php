<?php


/* @var $installer Magekart_CustomOptions_Model_Mysql4_Setup */
$installer = $this;

$installer->startSetup();

if (!$installer->getConnection()->tableColumnExists($installer->getTable('catalog/product_option_type_value'), 'default')) {
    $installer->getConnection()->addColumn(
            $installer->getTable('catalog/product_option_type_value'),
            'default',
            "tinyint(1) NOT NULL DEFAULT '0'"
    );
}    

if (!$installer->getConnection()->tableColumnExists($installer->getTable('catalog/product_option'), 'customer_groups')) {
    $installer->getConnection()->addColumn(
            $installer->getTable('catalog/product_option'),
            'customer_groups',
            "varchar (255) default ''"
    );
}    

$installer->endSetup();