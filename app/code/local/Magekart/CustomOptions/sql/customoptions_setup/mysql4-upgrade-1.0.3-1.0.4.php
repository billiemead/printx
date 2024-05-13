<?php


/* @var $installer Magekart_CustomOptions_Model_Mysql4_Setup */
$installer = $this;

$installer->startSetup();

if (!$installer->getConnection()->tableColumnExists($installer->getTable('catalog/product_option'), 'customoptions_is_onetime')) {
    $installer->getConnection()->addColumn(
        $installer->getTable('catalog/product_option'),
        'customoptions_is_onetime',
        'TINYINT (1) NOT NULL DEFAULT 0'
    );
}    

$installer->endSetup();
