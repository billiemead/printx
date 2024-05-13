<?php


/* @var $installer Magekart_CustomOptions_Model_Mysql4_Setup */
$installer = $this;
$installer->startSetup();

//$installer->run("ALTER TABLE `{$installer->getTable('customoptions/group')}` CHANGE `group_id` `group_id` SMALLINT UNSIGNED NOT NULL auto_increment;
//ALTER TABLE `{$installer->getTable('customoptions/relation')}` CHANGE `group_id` `group_id` SMALLINT UNSIGNED NOT NULL;");

if (!$installer->getConnection()->tableColumnExists($installer->getTable('catalog/product_option'), 'view_mode')) {
    $installer->getConnection()->addColumn(
        $installer->getTable('catalog/product_option'),
        'view_mode',
        "tinyint(1) NOT NULL DEFAULT '1'"
    );
}

if (!$installer->getConnection()->tableColumnExists($installer->getTable('catalog/product_option'), 'in_group_id')) {
    $installer->getConnection()->addColumn(
        $installer->getTable('catalog/product_option'),
        'in_group_id',
        "SMALLINT UNSIGNED NOT NULL DEFAULT '0'"
    );
}

if (!$installer->getConnection()->tableColumnExists($installer->getTable('catalog/product_option_type_value'), 'in_group_id')) {
    $installer->getConnection()->addColumn(
        $installer->getTable('catalog/product_option_type_value'),
        'in_group_id',
        "SMALLINT UNSIGNED NOT NULL DEFAULT '0'"
    );
}    


if ($installer->getConnection()->tableColumnExists($installer->getTable('catalog/product_option'), 'customoptions_status')) {
    $installer->getConnection()->dropColumn(
        $installer->getTable('catalog/product_option'),
        'customoptions_status'
    );
}    

$installer->endSetup();