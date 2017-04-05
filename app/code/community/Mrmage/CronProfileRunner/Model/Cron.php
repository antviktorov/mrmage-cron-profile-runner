<?php

/**
 * Class Mrmage_CronProfileRunner_Model_Cron
 */
class Mrmage_CronProfileRunner_Model_Cron
{
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
                Mage::log($e->getMessage(), null, 'mrmage_cronprofilerunner.log' );
                Mage::log($e->getTraceAsString(), null, 'mrmage_cronprofilerunner.log');
                $profile->setStatus(Mrmage_CronProfileRunner_Model_Profile::STATUS_PROFILE_ERROR);
            }
            $profile->save();
        }
    }
}
