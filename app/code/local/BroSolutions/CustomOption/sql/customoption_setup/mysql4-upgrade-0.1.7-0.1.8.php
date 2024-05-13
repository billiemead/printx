<?php


/* @var $installer Magekart_CustomOptions_Model_Mysql4_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("ALTER TABLE {$installer->getTable('catalog_product_option')} ADD `internal_note` text ");

$installer->endSetup();
