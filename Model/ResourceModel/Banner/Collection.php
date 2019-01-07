<?php
namespace Roger\BannerSlider\Model\ResourceModel\Banner;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'banner_id';
    protected $_eventPrefix = 'roger_bannerslider_banner_collection';
    protected $_eventObject = 'banner_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Roger\BannerSlider\Model\Banner', 'Roger\BannerSlider\Model\ResourceModel\Banner');
    }

}
