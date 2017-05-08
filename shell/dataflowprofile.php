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
            Mage::app()->getLayout()->setDirectOutput(true);
            try {
                $id = (int) $this->getArg('profile');

                $profile = Mage::getModel('mrmage_cronprofilerunner/profile')->load($id, 'profile_id');
                if (!$profile->getId()) {
                    $profile->setProfileId($id);
                }

                $profile->setStatus(Mrmage_CronProfileRunner_Model_Profile::STATUS_PROFILE_RUNNING);
                $profile->save();

                $this->_showMessage("Batch model id " . $this->_runProfile($id) . " has executed");

                $profile->setStatus(Mrmage_CronProfileRunner_Model_Profile::STATUS_PROFILE_STOPPED);
                $profile->save();
            } catch (Exception $e) {
                $this->_showMessage("Error while executing" . $e->getMessage());

                $profile->setStatus(Mrmage_CronProfileRunner_Model_Profile::STATUS_PROFILE_ERROR);
                $profile->save();
            }
        } else {
            $this->_showMessage(
                'Please specify profile parameter with value of profile id ex. "php dataflowprofile.php --profile id"'
            );
        }
    }

    /**
     * Run profile
     * @param $id - profile id
     * @return string
     */
    protected function _runProfile($id)
    {
        $helper   = Mage::helper('mrmage_cronprofilerunner/dataflow');
        $batchId  = $helper->run($id);
        $messages = $helper->getMessages();
        if (!empty($messages)) {
            $this->_showMessage($messages);
        }

        return $batchId;
    }

    /**
     * @param $message
     */
    protected function _showMessage($message)
    {
        $echo = Mage::app()->getLayout()->createBlock('core/template')
            ->setTemplate('mrmagecronrunner/message.phtml')
            ->setMessage($message);
        $echo->toHtml();
    }
}

$shell = new Mage_Shell_Dataflowprofile();
$shell->run();