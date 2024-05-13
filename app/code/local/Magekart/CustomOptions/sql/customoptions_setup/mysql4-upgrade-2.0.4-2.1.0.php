<?php


/* @var $installer Magekart_CustomOptions_Model_Mysql4_Setup */
$installer = $this;

$installer->startSetup();

if (!$installer->getConnection()->tableColumnExists($installer->getTable('catalog/product_option'), 'qnty_input')) {
    $installer->getConnection()->addColumn(
        $installer->getTable('catalog/product_option'),
        'qnty_input',
        "tinyint(1) NOT NULL DEFAULT '0'"
    );
}    

$installer->endSetup();