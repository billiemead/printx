<?php


/* @var $installer Magekart_CustomOptions_Model_Mysql4_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("CREATE TABLE IF NOT EXISTS `printx_upload` (
`id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `original_filename` text NOT NULL,
  `filename` text NOT NULL,
  `comment` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,   
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8");





$installer->endSetup();