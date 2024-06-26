<?php


/* @var $installer Magekart_CustomOptions_Model_Mysql4_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("
-- DROP TABLE IF EXISTS {$installer->getTable('customoptions/group')};
CREATE TABLE IF NOT EXISTS {$installer->getTable('customoptions/group')} (
  `group_id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `is_active` tinyint(1) NOT NULL,
  `store_id` smallint(5) unsigned default NULL,
  `hash_options` longtext NOT NULL,
   PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- DROP TABLE IF EXISTS {$installer->getTable('customoptions/relation')};
CREATE TABLE IF NOT EXISTS {$installer->getTable('customoptions/relation')} (
  `id` int(10) unsigned NOT NULL auto_increment,
  `group_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `option_id` int(10) unsigned NOT NULL,
   PRIMARY KEY (`id`),
   UNIQUE KEY `UNQ_MAGEKART_CUSTOM_RELATION` (`group_id`,`option_id`,`product_id`),
   CONSTRAINT `FK_MAGEKART_CUSTOM_OPTIONS_INDEX_PRODUCT_ENTITY` FOREIGN KEY (`product_id`) REFERENCES `{$installer->getTable('catalog/product')}` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
   CONSTRAINT `FK_MAGEKART_CUSTOM_OPTIONS_INDEX_GROUP_RELATION` FOREIGN KEY (`group_id`) REFERENCES `{$installer->getTable('customoptions/group')}` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

if (!$installer->getConnection()->tableColumnExists($installer->getTable('catalog/product_option'), 'customoptions_status')) {
    $installer->getConnection()->addColumn(
        $installer->getTable('catalog/product_option'),
        'customoptions_status',
        'tinyint(1) NOT NULL default 0'
    );
}    

$installer->endSetup();
