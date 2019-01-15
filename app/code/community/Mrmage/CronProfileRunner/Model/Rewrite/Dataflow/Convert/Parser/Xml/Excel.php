<?php
/**
 * MrMage
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject MrMage
 * that is available through the world-wide-web at this URL:
 * https://mrmage.com/eula/
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
 * @license    https://mrmage.com/eula/
 */
/**
 * Class Mrmage_CronProfileRunner_Model_Rewrite_Dataflow_Convert_Parser_Xml_Excel
 * @author MrMage team <support@mrmage.com>
 */
class Mrmage_CronProfileRunner_Model_Rewrite_Dataflow_Convert_Parser_Xml_Excel extends
    Mage_Dataflow_Model_Convert_Parser_Xml_Excel
{
    /**
     * Override default XML parse method to allow import from shell or cron
     * @return $this
     */
    public function parse()
    {
        $controllerName = Mage::app()->getRequest()->getControllerName();

        /**
         * Run default import from admin
         */
        if ($controllerName == 'system_convert_profile' || $controllerName == 'system_convert_gui') {
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