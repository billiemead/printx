<?php


/* @var $installer Magekart_CustomOptions_Model_Mysql4_Setup */
$installer = $this;
$installer->startSetup();

$installer->run("-- DROP TABLE IF EXISTS {$installer->getTable('customoptions/option_default')};
CREATE TABLE IF NOT EXISTS `{$installer->getTable('customoptions/option_default')}` (
  `option_default_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `option_id` int(10) unsigned NOT NULL DEFAULT '0',
  `store_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `default_text` text NOT NULL,
  PRIMARY KEY (`option_default_id`),
  UNIQUE KEY `option_id+store_id` (`option_id`,`store_id`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `FK_MAGEKART_CUSTOM_OPTIONS_DEFAULT_OPTION` FOREIGN KEY (`option_id`) REFERENCES `{$installer->getTable('catalog/product_option')}` (`option_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_MAGEKART_CUSTOM_OPTIONS_DEFAULT_STORE` FOREIGN KEY (`store_id`) REFERENCES `{$installer->getTable('core/store')}` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

ALTER TABLE `{$installer->getTable('customoptions/option_description')}` CHANGE `description` `description` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';
DELETE FROM `{$installer->getTable('customoptions/option_description')}` WHERE `description` = '';");
  
$installer->endSetup();