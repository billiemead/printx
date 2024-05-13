<?php


/* @var $installer Magekart_CustomOptions_Model_Mysql4_Setup */
$installer = $this;
$installer->startSetup();


if ($installer->getConnection()->tableColumnExists($installer->getTable('customoptions/group'), 'store_id')) {
    $installer->run("ALTER TABLE `{$installer->getTable('customoptions/group')}` DROP `store_id`;");
}

$installer->run("-- DROP TABLE IF EXISTS `{$installer->getTable('customoptions/group_store')}`;
CREATE TABLE IF NOT EXISTS `{$installer->getTable('customoptions/group_store')}` (
  `group_store_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL,
  `store_id` smallint(5) unsigned NOT NULL,  
  `hash_options` longtext NOT NULL,
  PRIMARY KEY (`group_store_id`),
  UNIQUE KEY `UNQ_CUSTOM_OPTIONS_GROUP_STORE` (`group_id`,`store_id`),
  CONSTRAINT `FK_MAGEKART_CUSTOM_OPTIONS_GROUP_STORE` FOREIGN KEY (`group_id`) REFERENCES `{$installer->getTable('customoptions/group')}` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
  
$installer->endSetup();