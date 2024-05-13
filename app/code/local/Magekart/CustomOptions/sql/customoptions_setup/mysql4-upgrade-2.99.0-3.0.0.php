<?php


/* @var $installer Magekart_CustomOptions_Model_Mysql4_Setup */
$installer = $this;
$installer->startSetup();

if (!$installer->getConnection()->tableColumnExists($installer->getTable('catalog/product_option'), 'div_class')) {
    $installer->getConnection()->addColumn(
        $installer->getTable('catalog/product_option'),
        'div_class',
        "varchar(64) NOT NULL default ''"
    );
}

if (!$installer->getConnection()->tableColumnExists($installer->getTable('catalog/product_option_type_value'), 'weight')) {
    $installer->getConnection()->addColumn(
        $installer->getTable('catalog/product_option_type_value'),
        'weight',
        "DECIMAL( 12, 4 ) NOT NULL DEFAULT '0'"
    );
}

if (!$installer->getConnection()->tableColumnExists($installer->getTable('catalog/product'), 'absolute_weight')) {
    $installer->getConnection()->addColumn(
        $installer->getTable('catalog/product'),
        'absolute_price',
        "TINYINT (1) NOT NULL DEFAULT 0"
    );
    
    $installer->getConnection()->addColumn(
        $installer->getTable('catalog/product'),
        'absolute_weight',
        "TINYINT (1) NOT NULL DEFAULT 0"
    );
}


if (!$installer->getConnection()->tableColumnExists($installer->getTable('customoptions/group'), 'absolute_weight')) {    
    $installer->getConnection()->addColumn(
        $installer->getTable('customoptions/group'),
        'absolute_price',
        "TINYINT (1) NOT NULL DEFAULT 0"
    );
    
    $installer->getConnection()->addColumn(
        $installer->getTable('customoptions/group'),
        'absolute_weight',
        "TINYINT (1) NOT NULL DEFAULT 0"
    );
}



$installer->endSetup();