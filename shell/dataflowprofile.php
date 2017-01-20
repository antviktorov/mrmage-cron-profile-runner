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
            echo $this->_runProfile($this->getArg('profile')) . "\n";
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