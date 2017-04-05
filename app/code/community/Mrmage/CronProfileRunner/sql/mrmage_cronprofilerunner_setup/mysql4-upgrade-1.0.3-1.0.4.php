<?php
$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()
    ->addForeignKey(
        $installer->getFkName(
            $installer->getTable('mrmage_cronprofilerunner/log'),
            'profile_id',
            $installer->getTable('dataflow/profile'),
            'profile_id'
        ),
        $installer->getTable('mrmage_cronprofilerunner/log'),
        'profile_id',
        $installer->getTable('dataflow/profile'),
        'profile_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    );
$installer->endSetup();