<?php


/* @var $installer Magekart_CustomOptions_Model_Mysql4_Setup */
$installer = $this;
$installer->startSetup();
$installer->run("ALTER TABLE `{$installer->getTable('catalog/product_option_type_value')}` CHANGE `dependent_ids` `dependent_ids` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''");
$installer->endSetup();