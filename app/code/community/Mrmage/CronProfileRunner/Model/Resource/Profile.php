<?php
/**
 * Class Mrmage_CronProfileRunner_Model_Resource_Profile
 */
class Mrmage_CronProfileRunner_Model_Resource_Profile extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * Init model
     */
    public function _construct()
    {
        $this->_init('mrmage_cronprofilerunner/profile', 'id');
    }
}
