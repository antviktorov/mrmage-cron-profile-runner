<?php

/**
 * Class Mrmage_CronProfileRunner_Model_Resource_Log_Collection
 */
class Mrmage_CronProfileRunner_Model_Resource_Log_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Init model
     */
    protected function _construct()
    {
        $this->_init('mrmage_cronprofilerunner/log');
    }
}