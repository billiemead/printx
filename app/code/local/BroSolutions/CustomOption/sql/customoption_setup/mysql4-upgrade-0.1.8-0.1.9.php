<?php


/* @var $installer Magekart_CustomOptions_Model_Mysql4_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("CREATE TABLE IF NOT EXISTS `printx_paperstock` (
`id` int(11) NOT NULL AUTO_INCREMENT,
  `paper_id` varchar(255)  NOT NULL ,
  `paper_w` int(11) DEFAULT NULL,
  `paper_h` datetime DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8");


$installer->endSetup();
