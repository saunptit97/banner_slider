<?php
namespace Roger\BannerSlider\Model;
class Slider extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'roger_bannerslider_slider';

    protected $_cacheTag = 'roger_bannerslider_slider';

    protected $_eventPrefix = 'roger_bannerslider_slider';

    protected function _construct()
    {
        $this->_init('Roger\BannerSlider\Model\ResourceModel\Slider');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}