<?php

/**
 * Class Mrmage_CronProfileRunner_Model_Log
 * @author MrMage team <support@mrmage.com>
 */
class Mrmage_CronProfileRunner_Model_Log extends Mage_Core_Model_Abstract
{
    /**
     * Init model
     */
    public function _construct()
    {
        $this->_init('mrmage_cronprofilerunner/log');
    }
}