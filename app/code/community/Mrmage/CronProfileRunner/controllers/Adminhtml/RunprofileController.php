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
 * Class Mrmage_CronProfileRunner_Adminhtml_RunprofileController
 * @author MrMage team <support@mrmage.com>
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
                        Mage::throwException(Mage::helper('mrmage_cronprofilerunner')->__('Provided profile is wrong.'));
                    }

                    $cronProfile->setProfileId($profile->getId());
                } else if ($cronProfile->isRunning()) {
                    Mage::throwException(
                        Mage::helper('mrmage_cronprofilerunner')->__(
                            'Profile is running now in cron. Can\'t pending it while running.'
                        )
                    );
                }

                $cronProfile->setStatus(Mrmage_CronProfileRunner_Model_Profile::STATUS_PROFILE_PENDING);
                $cronProfile->save();
            } else {
                Mage::throwException(Mage::helper('adminhtml')->__('Profile id isn\'t provided.'));
            }
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        $this->_redirect('*/system_convert_gui');
    }

    /**
     * Check if controller is allowed
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('admin/system/convert/gui');
    }
}