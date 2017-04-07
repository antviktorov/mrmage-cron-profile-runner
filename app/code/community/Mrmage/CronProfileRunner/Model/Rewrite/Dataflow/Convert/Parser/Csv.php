<?php

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
         * Run import while shell or cron executions
         */
        if (Mage::app()->getRequest()->isAjax()) {
            return parent::parse();
        }

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