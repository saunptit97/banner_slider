<?php
namespace Roger\BannerSlider\Model\ResourceModel\Slider;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'slider_id';
    protected $_eventPrefix = 'roger_bannerslider_slider_collection';
    protected $_eventObject = 'slider_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Roger\BannerSlider\Model\Slider', 'Roger\BannerSlider\Model\ResourceModel\Slider');
    }

}
