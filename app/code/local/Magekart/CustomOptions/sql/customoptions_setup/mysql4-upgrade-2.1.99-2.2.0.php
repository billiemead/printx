<?php


/* @var $installer Magekart_CustomOptions_Model_Mysql4_Setup */
$installer = $this;
$installer->startSetup();
$installer->run("ALTER TABLE `{$installer->getTable('catalog/product_option')}` CHANGE `in_group_id` `in_group_id` INT UNSIGNED NOT NULL DEFAULT '0'");
$installer->run("ALTER TABLE `{$installer->getTable('catalog/product_option_type_value')}` CHANGE `in_group_id` `in_group_id` INT UNSIGNED NOT NULL DEFAULT '0'");

if (!$installer->getConnection()->tableColumnExists($installer->getTable('catalog/product_option'), 'is_dependent')) {
    $installer->getConnection()->addColumn(
        $installer->getTable('catalog/product_option'),
        'is_dependent',
        "tinyint(1) NOT NULL DEFAULT '0'"
    );
}

if (!$installer->getConnection()->tableColumnExists($installer->getTable('catalog/product_option_type_value'), 'dependent_ids')) {
    $installer->getConnection()->addColumn(
        $installer->getTable('catalog/product_option_type_value'),
        'dependent_ids',
        "varchar(255) NOT NULL DEFAULT ''"
    );
}

$installer->run("UPDATE `{$installer->getTable('catalog/product_option')}` AS cpo, `{$installer->getTable('customoptions/relation')}` AS cor 
    SET cpo.`in_group_id`=(cor.`group_id` * 65535) + cpo.`in_group_id`
    WHERE cpo.`option_id`=cor.`option_id` AND cpo.`in_group_id`>0 AND cpo.`in_group_id` < 65536 AND cor.`group_id`>0 AND cor.`group_id` IS NOT NULL");

$installer->run("UPDATE `{$installer->getTable('catalog/product_option_type_value')}` AS cpotv, `{$installer->getTable('customoptions/relation')}` AS cor 
    SET cpotv.`in_group_id`=(cor.`group_id` * 65535) + cpotv.`in_group_id`
    WHERE cpotv.`option_id`=cor.`option_id` AND cpotv.`in_group_id`>0 AND cpotv.`in_group_id` < 65536 AND cor.`group_id`>0 AND cor.`group_id` IS NOT NULL");

//$installer->run("ALTER TABLE `{$installer->getTable('catalog/product_option_type_value')}` CHANGE `dependent_ids` `dependent_ids` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''");

$installer->endSetup();