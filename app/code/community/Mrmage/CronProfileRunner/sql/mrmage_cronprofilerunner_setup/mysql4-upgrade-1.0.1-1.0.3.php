<?php
$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('mrmage_cronprofilerunner/log'))
    ->addColumn(
        'id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Id'
    )
    ->addColumn(
        'profile_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'unsigned'  => true,
        ), 'Profile id'
    )
    ->addColumn(
        'batch_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'unsigned'  => true,
        ), 'Batch Id'
    )
    ->addColumn(
        'message', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => false,
        'unsigned'  => true,
        ), 'Message'
    )
    ->addColumn(
        'run_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable'  => false,
        ), 'Performed At'
    )
    ->addColumn(
        'level', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
        'nullable'  => false,
        'length'    => 30,
        ), 'Level'
    );
$installer->getConnection()->createTable($table);

$installer->endSetup();
