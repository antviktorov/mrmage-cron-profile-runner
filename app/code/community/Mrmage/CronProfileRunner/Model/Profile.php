<?php
/**
 * MrMage
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject MrMage
 * that is available through the world-wide-web at this URL:
 * https://mrmage.com/eula/
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to support@mrmage.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the extension to newer
 * versions in the future. If you wish to customize the extension for your
 * needs please refer to http://mrmage.com/ for more information.
 *
 * @copyright  Copyright (c) 2016-2018 MrMage company
 * @license    https://mrmage.com/eula/
 */
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