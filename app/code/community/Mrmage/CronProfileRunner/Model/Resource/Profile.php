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
 * Class Mrmage_CronProfileRunner_Model_Resource_Profile
 * @author MrMage team <support@mrmage.com>
 */
class Mrmage_CronProfileRunner_Model_Resource_Profile extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Init model
     */
    public function _construct()
    {
        $this->_init('mrmage_cronprofilerunner/profile', 'id');
    }
}
