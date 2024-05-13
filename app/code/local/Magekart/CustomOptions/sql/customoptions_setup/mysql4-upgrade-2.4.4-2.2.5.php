<?php


/* @var $installer Magekart_CustomOptions_Model_Mysql4_Setup */
$installer = $this;
$installer->startSetup();
$installer->run("UPDATE IGNORE `{$this->getTable('core_config_data')}` SET `path` = REPLACE(`path`,'magekart_sales/','customoptions/') WHERE `path` LIKE 'magekart_sales/customoptions/%'");
$installer->endSetup();