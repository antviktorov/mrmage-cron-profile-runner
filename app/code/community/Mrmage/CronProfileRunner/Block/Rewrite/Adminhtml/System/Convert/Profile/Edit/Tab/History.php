<?php

/**
 * Class Mrmage_CronProfileRunner_Block_Rewrite_Adminhtml_System_Convert_Profile_Edit_Tab_History
 */
class Mrmage_CronProfileRunner_Block_Rewrite_Adminhtml_System_Convert_Profile_Edit_Tab_History extends
    Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('history_grid');
        $this->setDefaultSort('run_time', 'desc');
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('mrmage_cronprofilerunner/log_collection')
            ->addFieldToFilter('profile_id', Mage::registry('current_convert_profile')->getId());
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('run_time', array(
            'header'    => Mage::helper('adminhtml')->__('Performed At'),
            'type'      => 'datetime',
            'index'     => 'run_time',
            'width'     => '150px',
        ));

        $this->addColumn('batch_id', array(
            'header'    => Mage::helper('adminhtml')->__('Batch Id'),
            'index'     => 'batch_id',
            'width'     => '50px',
        ));

        $this->addColumn('message', array(
            'header'    => Mage::helper('adminhtml')->__('Message'),
            'index'     => 'message',
        ));

        $this->addColumn('level', array(
            'header'    => Mage::helper('adminhtml')->__('Error level'),
            'index'     => 'level',
        ));

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/history', array('_current' => true));
    }
}