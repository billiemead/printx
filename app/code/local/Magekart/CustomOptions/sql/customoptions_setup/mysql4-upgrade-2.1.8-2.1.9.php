<?php


/* @var $installer Magekart_CustomOptions_Model_Mysql4_Setup */
$installer = $this;
$installer->startSetup();
$installer->run("ALTER TABLE `{$installer->getTable('customoptions/relation')}` ADD INDEX (`option_id`)");
$installer->endSetup();