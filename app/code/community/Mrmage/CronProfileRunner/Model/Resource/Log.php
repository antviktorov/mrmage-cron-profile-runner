<?php

/**
 * Class Mrmage_CronProfileRunner_Model_Resource_Log
 */
class Mrmage_CronProfileRunner_Model_Resource_Log extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * Init model
     */
    public function _construct()
    {
        $this->_init('mrmage_cronprofilerunner/log', 'id');
    }
}
