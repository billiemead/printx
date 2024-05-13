<?php


/* @var $installer Magekart_CustomOptions_Model_Mysql4_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("
-- DROP TABLE IF EXISTS {$installer->getTable('customoptions/option_description')};
CREATE TABLE IF NOT EXISTS {$installer->getTable('customoptions/option_description')} (
  `option_description_id` int(10) unsigned NOT NULL auto_increment,
  `option_id` int(10) unsigned NOT NULL default '0',
  `store_id` smallint(5) unsigned NOT NULL default '0',
  `description` text,
  PRIMARY KEY  (`option_description_id`),
  KEY `MAGEKART_CUSTOM_OPTIONS_DESCRIPTION_OPTION` (`option_id`),
  KEY `MAGEKART_CUSTOM_OPTIONS_DESCRIPTION_STORE` (`store_id`),
  CONSTRAINT `FK_MAGEKART_CUSTOM_OPTIONS_DESCRIPTION_OPTION` FOREIGN KEY (`option_id`) REFERENCES `{$installer->getTable('catalog/product_option')}` (`option_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_MAGEKART_CUSTOM_OPTIONS_DESCRIPTION_STORE` FOREIGN KEY (`store_id`) REFERENCES `{$installer->getTable('core/store')}` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

$installer->endSetup();
