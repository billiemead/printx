<?php


/* @var $installer Magekart_CustomOptions_Model_Mysql4_Setup */
$installer = $this;

$installer->startSetup();

if (!$installer->getConnection()->tableColumnExists($installer->getTable('catalog/product_option_type_value'), 'customoptions_qty')) {
    $installer->getConnection()->addColumn(
        $installer->getTable('catalog/product_option_type_value'),
        'customoptions_qty',
        "varchar(10) NOT NULL default ''"
    );
}    

$installer->endSetup();
