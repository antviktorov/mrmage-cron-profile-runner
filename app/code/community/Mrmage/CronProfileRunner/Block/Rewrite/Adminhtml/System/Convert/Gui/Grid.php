<?php
/**
 * Convert profiles grid
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Mrmage_CronProfileRunner_Block_Rewrite_Adminhtml_System_Convert_Gui_Grid
    extends Mage_Adminhtml_Block_System_Convert_Gui_Grid
{

    /**
     * set collection object
     *
     * @param Varien_Data_Collection $collection
     */
    public function setCollection($collection)
    {
        $this->_collection = Mage::getResourceModel('dataflow/profile_collection')
            ->addFieldToFilter('entity_type', array('notnull'=>''));
        $this->_collection->getSelect()->joinLeft(
            array('profile' => $this->_collection->getTable('mrmage_cronprofilerunner/profile')),
            'profile.profile_id=main_table.profile_id',
            array(
                'status' => 'status',
            )
        );
    }

    protected function _prepareColumns()
    {
        parent::_prepareColumns();

        $this->removeColumn('action');

        $this->addColumn(
            'action', array(
            'header'    => Mage::helper('adminhtml')->__('Action'),
            'width'     => '60px',
            'align'     => 'center',
            'sortable'  => false,
            'filter'    => false,
            'type'      => 'action',
            'actions'   => array(
                array(
                    'url'       => $this->getUrl('*/*/edit') . 'id/$profile_id',
                    'caption'   => Mage::helper('adminhtml')->__('Edit')
                ),
                array(
                    'url'       => $this->getUrl('*/runprofile/run') . 'id/$profile_id',
                    'caption'   => Mage::helper('adminhtml')->__('Run')
                ),
            )
            )
        );

        $this->addColumn(
            'status', array(
            'header'    => Mage::helper('index')->__('Running Status'),
            'sortable'  => false,
            'width'     => '120',
            'align'     => 'left',
            'index'     => 'status',
            'type'      => 'options',
            'options'   => Mrmage_CronProfileRunner_Model_Profile::getStatuses(),
            'frame_callback' => array($this, 'decorateStatus')
            )
        );

        return $this;
    }

    /**
     * Decorate status column values
     *
     * @param string $value
     * @param Mage_Index_Model_Process $row
     * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
     * @param bool $isExport
     *
     * @return string
     */
    public function decorateStatus($value, $row, $column, $isExport)
    {
        $class = '';
        $text = '';
        switch ($row->getStatus()) {
            case Mrmage_CronProfileRunner_Model_Profile::STATUS_PROFILE_PENDING:
                $class = 'grid-severity-minor';
                $text  = $this->helper('mrmage_cronprofilerunner')->__('Pending');
                break;
            case Mrmage_CronProfileRunner_Model_Profile::STATUS_PROFILE_RUNNING :
                $class = 'grid-severity-notice';
                $text  = $this->helper('mrmage_cronprofilerunner')->__('Running');
                break;
            case Mrmage_CronProfileRunner_Model_Profile::STATUS_PROFILE_ERROR :
                $class = 'grid-severity-critical';
                $text  = $this->helper('mrmage_cronprofilerunner')->__('Error');
                break;
            default :
                $class = 'grid-severity-notice';
                $text  = $this->helper('mrmage_cronprofilerunner')->__('Stopped');
        }

        return '<span class="'.$class.'"><span>'.$text.'</span></span>';
    }
}