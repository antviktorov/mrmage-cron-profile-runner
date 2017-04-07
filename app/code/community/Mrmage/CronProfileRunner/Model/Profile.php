<?php

/**
 * Class Mrmage_CronProfileRunner_Model_Profile
 * @author MrMage team <support@mrmage.com>
 */
class Mrmage_CronProfileRunner_Model_Profile extends Mage_Core_Model_Abstract
{
    const STATUS_PROFILE_STOPPED = 0;
    const STATUS_PROFILE_PENDING = 1;
    const STATUS_PROFILE_RUNNING = 2;
    const STATUS_PROFILE_ERROR   = 3;

    public function _construct()
    {
        $this->_init('mrmage_cronprofilerunner/profile');
    }

    public static function getStatuses()
    {
        return array(
            self::STATUS_PROFILE_STOPPED => Mage::helper('mrmage_cronprofilerunner')->__('Stopped'),
            self::STATUS_PROFILE_PENDING => Mage::helper('mrmage_cronprofilerunner')->__('Pending'),
            self::STATUS_PROFILE_RUNNING => Mage::helper('mrmage_cronprofilerunner')->__('Running'),
            self::STATUS_PROFILE_ERROR => Mage::helper('mrmage_cronprofilerunner')->__('Error'),
        );
    }

    public function isRunning()
    {
        if ($this->getStatus() == self::STATUS_PROFILE_RUNNING) {
            return true;
        }

        return false;
    }
}