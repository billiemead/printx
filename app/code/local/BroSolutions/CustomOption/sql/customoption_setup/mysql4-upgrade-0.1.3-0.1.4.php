<?php


/* @var $installer Magekart_CustomOptions_Model_Mysql4_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("ALTER TABLE `printx_upload` add item_id int(11) not null");

$installer->endSetup();

