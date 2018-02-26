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
 * Class Mrmage_CronProfileRunner_Helper_Dataflow
 * @author MrMage team <support@mrmage.com>
 */
class Mrmage_CronProfileRunner_Helper_Dataflow extends Mage_Core_Helper_Abstract
{
    /**
     * Dataflow messages
     * @var null
     */
    protected $_messages = null;
    /**
     * Run profile from shell or cron
     * @param $profileId - dataflow/profile id
     * @param bool $echo - echo from shell
     * @return mixed
     * @throws Exception
     */
    public function run($profileId)
    {
        /**
         * Clean import system cache each global run.
         */
        Mage::app()->getCache()->clean(
            Zend_Cache::CLEANING_MODE_MATCHING_TAG,
            array('mrmage_import_tags')
        );

        Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

        $profile = Mage::getModel('dataflow/profile');

        $user = Mage::getModel('admin/user');
        $user->setUserId(0);

        Mage::getSingleton('admin/session')->setUser($user);

        $profile->load($profileId);

        if (!$profile->getId()) {
            Mage::throwException('Invalid profile id. Profile does not exists');
        }

        $profile->run();

        $messages = '';

        $batchModel = Mage::getSingleton('dataflow/batch');

        if ($exceptions = $profile->getExceptions()) {
            $rows = array();
            foreach ($exceptions as $exception) {
                $messages .= $exception->getMessage() . "\n";

                $rows[] = array(
                    'profile_id' => $profile->getId(),
                    'message'    => $exception->getMessage(),
                    'batch_id'   => $batchModel->getId(),
                    'run_time'   => Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s'),
                    'level'      => $exception->getLevel()
                );
            }

            if (!empty($rows)) {
                $this->_saveDataInLog($rows);
            }
        }

        if (empty($messages)) {
            $this->_messages = null;
        } else {
            $this->_messages = "\n" . $messages;
        }

        return $batchModel->getId();
    }

    /**
     * Get import messages.
     */
    public function getMessages()
    {
        return $this->_messages;
    }

    /**
     * Logging exceptions data in custom log
     * @param $rows
     */
    protected function _saveDataInLog($rows)
    {
        $table = Mage::getSingleton('core/resource')->getTableName('mrmage_cronprofilerunner/log');

        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        $write->insertMultiple($table, $rows);
    }
}