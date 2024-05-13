<?php


/* @var $installer Magekart_CustomOptions_Model_Mysql4_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("CREATE TABLE IF NOT EXISTS `printx_department` (
`id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255)  NOT NULL ,
  `position` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT null,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8");


$installer->endSetup();
