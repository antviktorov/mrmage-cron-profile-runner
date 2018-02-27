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
 * Class Mrmage_CronProfileRunner_Model_Rewrite_Dataflow_Convert_Parser_Csv
 * @author MrMage team <support@mrmage.com>
 */
class Mrmage_CronProfileRunner_Model_Rewrite_Dataflow_Convert_Parser_Csv extends Mage_Dataflow_Model_Convert_Parser_Csv
{
    /**
     * Override default CSV parse method to allow import from shell or cron
     * @return $this
     */
    public function parse()
    {
        /**
         * Run default import from admin
         */
        if (Mage::app()->getRequest()->getControllerName() == 'system_convert_profile') {
            return parent::parse();
        }

        /**
         * Run import while shell or cron executions
         */
        parent::parse();

        /**
         * Exit from import if previous code has fatal errors
         */
        foreach ($this->getProfile()->getExceptions() as $exception) {
            if ($exception->getLevel() == Mage_Dataflow_Model_Convert_Exception::FATAL) {
                return $this;
            }
        }

        $adapterName   = $this->getVar('adapter', null);
        $adapterMethod = $this->getVar('method', 'saveRow');

        $adapter = Mage::getModel($adapterName);

        $adapter->setProfile($this->getProfile());
        $adapter->$adapterMethod();
    }
}