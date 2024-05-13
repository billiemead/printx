<?php


/* @var $installer Magekart_CustomOptions_Model_Mysql4_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("ALTER TABLE {$installer->getTable('sales_flat_order_item')} ADD `upload_status` varchar(255) null default null");

$installer->endSetup();
