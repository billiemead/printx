<?php


/* @var $installer Magekart_CustomOptions_Model_Mysql4_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("ALTER TABLE `printx_upload` ADD `path` text, "
        . " ADD `type` set('local','ftp'), "
        . " ADD `uploaded` int(1) null default 0 ");

$installer->run("ALTER TABLE {$installer->getTable('catalog_product_option')} ADD `use_custom_title` int(1) null default 0");

$installer->endSetup();
