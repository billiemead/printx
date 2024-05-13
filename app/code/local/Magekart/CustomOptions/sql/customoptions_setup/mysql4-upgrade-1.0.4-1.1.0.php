<?php


/* @var $installer Magekart_CustomOptions_Model_Mysql4_Setup */
$installer = $this;

$installer->startSetup();

if (!$installer->getConnection()->tableColumnExists($installer->getTable('catalog/product_option'), 'image_path')) {
    $installer->getConnection()->addColumn(
        $installer->getTable('catalog/product_option'),
        'image_path',
        "varchar (255) default ''"
    );
}    

//if (!$installer->getConnection()->tableColumnExists($installer->getTable('catalog/product_option_type_value'), 'image_path')) {
//    $installer->getConnection()->addColumn(
//        $installer->getTable('catalog/product_option_type_value'),
//        'image_path',
//        "varchar (255) default ''"
//    );
//}

$installer->endSetup();
