<?php
class Mrmage_CronProfileRunner_Model_Cron
{
    public function runProfiles()
    {
        $profiles = Mage::getModel('mrmage_cronprofilerunner/profile')->getCollection()
            ->addFieldToFilter('status', Mrmage_CronProfileRunner_Model_Profile::STATUS_PROFILE_PENDING);

        foreach ($profiles as $profile) {
            try {
                Mage::helper('mrmage_cronprofilerunner/dataflow')->run($profile->getProfileId());
                $profile->setStatus(Mrmage_CronProfileRunner_Model_Profile::STATUS_PROFILE_STOPPED);
            } catch (Exception $e) {
                Mage::log('mrmage_cronprofilerunner.log', $e->getMessage());
                Mage::log('mrmage_cronprofilerunner.log', $e->getTraceAsString());
                $profile->setStatus(Mrmage_CronProfileRunner_Model_Profile::STATUS_PROFILE_ERROR);
            }
            $profile->save();
        }
    }
}
