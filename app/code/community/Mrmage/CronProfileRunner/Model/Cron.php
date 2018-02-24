<?php
/**
 * MrMage
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject MrMage
 * that is available through the world-wide-web at this URL:
 * http://mrmage.com/LICENSE-1.0.html
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
 * @license    http://mrmage.com/LICENSE-1.0.html
 */
/**
 * Class Mrmage_CronProfileRunner_Model_Cron
 * @author MrMage team <support@mrmage.com>
 */
class Mrmage_CronProfileRunner_Model_Cron
{
    /**
     * Run profiles by cron
     * @throws Exception
     */
    public function runProfiles()
    {
        $profiles = Mage::getModel('mrmage_cronprofilerunner/profile')->getCollection()
            ->addFieldToFilter('status', Mrmage_CronProfileRunner_Model_Profile::STATUS_PROFILE_PENDING);

        foreach ($profiles as $profile) {
            try {
                if ($profile->getFile()) {
                    Mage::app()->getRequest()->setParam('files', $profile->getFile());
                } else {
                    Mage::app()->getRequest()->setParam('files', null);
                }

                $profile->setStatus(Mrmage_CronProfileRunner_Model_Profile::STATUS_PROFILE_RUNNING);
                $profile->save();
                Mage::helper('mrmage_cronprofilerunner/dataflow')->run($profile->getProfileId());
                $profile->setStatus(Mrmage_CronProfileRunner_Model_Profile::STATUS_PROFILE_STOPPED);
            } catch (Exception $e) {
                Mage::log($e->getMessage(), null, 'mrmage_cronprofilerunner.log');
                Mage::log($e->getTraceAsString(), null, 'mrmage_cronprofilerunner.log');
                $profile->setStatus(Mrmage_CronProfileRunner_Model_Profile::STATUS_PROFILE_ERROR);
            }

            $profile->save();
        }
    }
}
