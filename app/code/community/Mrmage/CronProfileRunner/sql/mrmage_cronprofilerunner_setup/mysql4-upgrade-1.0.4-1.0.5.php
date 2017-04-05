<?php
$installer = $this;
$installer->startSetup();

$installer->getConnection()
    ->addColumn(
        $installer->getTable('mrmage_cronprofilerunner/profile'),
        'file',
        'varchar(255) NOT NULL'
    );
$installer->endSetup();