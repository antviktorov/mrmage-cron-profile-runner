<?php

/**
 * Class Mrmage_CronProfileRunner_Adminhtml_RunprofileController
 */
class Mrmage_CronProfileRunner_Adminhtml_RunprofileController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Set pending status to profile
     */
    public function runAction()
    {
        try {
            if ($id = (int) $this->getRequest()->getParam('id')) {
                $cronProfile = Mage::getModel('mrmage_cronprofilerunner/profile')->load($id, 'profile_id');
                if (!$cronProfile->getId()) {
                    $profile = Mage::getModel('dataflow/profile')->load($id);
                    if (!$profile->getId()) {
                        throw new Exception(Mage::helper('mrmage_cronprofilerunner')->__('Provided profile is wrong.'));
                    }
                    $cronProfile->setProfileId($profile->getId());
                } else if ($cronProfile->isRunning()) {
                    throw new Exception(
                        Mage::helper('mrmage_cronprofilerunner')->__(
                            'Profile is running now in cron. Can\'t pending it while running.'
                        )
                    );
                }

                $cronProfile->setStatus(Mrmage_CronProfileRunner_Model_Profile::STATUS_PROFILE_PENDING);
                $cronProfile->save();
             } else {
                throw new Exception(Mage::helper('adminhtml')->__('Profile id isn\'t provided.'));
            }
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        $this->_redirect('*/system_convert_gui');
    }
}