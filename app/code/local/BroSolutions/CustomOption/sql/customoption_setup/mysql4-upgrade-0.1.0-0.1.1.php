<?php


/* @var $installer Magekart_CustomOptions_Model_Mysql4_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("ALTER TABLE {$installer->getTable('catalog_product_option_type_value')} ADD `serialised_values` text");
$installer->run("ALTER TABLE {$installer->getTable('catalog_product_option')} ADD `formula` int(11) null default null");

$installer->endSetup();
