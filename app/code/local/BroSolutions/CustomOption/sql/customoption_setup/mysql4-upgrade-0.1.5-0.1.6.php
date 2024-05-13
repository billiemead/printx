<?php


/* @var $installer Magekart_CustomOptions_Model_Mysql4_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("ALTER TABLE {$installer->getTable('catalog_product_option')} ADD `weight_per_one` decimal(11,6) null default 0");

$installer->endSetup();
