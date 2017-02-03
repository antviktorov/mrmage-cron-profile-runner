<?php
/**
 * Class Mrmage_CronProfileRunner_Helper_Dataflow
 */
class Mrmage_CronProfileRunner_Helper_Dataflow extends Mage_Core_Helper_Abstract
{
    public function run($profileId)
    {
        ini_set('memory_limit', '2048M');
        Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

        $profile = Mage::getModel('dataflow/profile');

        $user = Mage::getModel('admin/user');
        $user->setUserId(0);

        Mage::getSingleton('admin/session')->setUser($user);

        $profile->load($profileId);

        if (!$profile->getId()) {
            throw new Exception('Invalid profile id. Profile does not exists');
        }

        Mage::register('current_convert_profile', $profile);

        $profile->run();

        $batchModel = Mage::getSingleton('dataflow/batch');
        return $batchModel->getId();
    }
}