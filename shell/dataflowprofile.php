<?php
require_once 'abstract.php';

/**
 * Magento Compiler Shell Script
 *
 * @category    Mage
 * @package     Mage_Shell
 * @author      Anton Viktorov
 */
class Mage_Shell_Dataflowprofile extends Mage_Shell_Abstract
{
    public function run()
    {
        if ($this->getArg('profile')) {
            try {
                $id = (int) $this->getArg('profile');

                $profile = Mage::getModel('mrmage_cronprofilerunner/profile')->load($id, 'profile_id');
                if (!$profile->getId()) {
                    $profile->setProfileId($id);
                }

                $profile->setStatus(Mrmage_CronProfileRunner_Model_Profile::STATUS_PROFILE_RUNNING);
                $profile->save();

                echo "Batch model id " . $this->_runProfile($id) . " has executed\n";

                $profile->setStatus(Mrmage_CronProfileRunner_Model_Profile::STATUS_PROFILE_STOPPED);
                $profile->save();
            } catch (Exception $e) {
                echo "Error while executing" . $e->getMessage() . "\n";
                $profile->setStatus(Mrmage_CronProfileRunner_Model_Profile::STATUS_PROFILE_ERROR);
                $profile->save();
            }
        } else {
            echo 'Please specify profile parameter with value of profile id ex. "php dataflowprofile.php --profile id"' . "\n";
        }
    }

    /**
     * Run profile
     * @param $id - profile id
     * @return string
     */
    protected function _runProfile($id)
    {
        return Mage::helper('mrmage_cronprofilerunner/dataflow')->run($id);
    }
}

$shell = new Mage_Shell_Dataflowprofile();
$shell->run();