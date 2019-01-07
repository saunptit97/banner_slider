<?php
namespace Roger\BannerSlider\Model;
class Banner extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'roger_bannerslider_banner';

    protected $_cacheTag = 'roger_bannerslider_banner';

    protected $_eventPrefix = 'roger_bannerslider_banner';

    protected function _construct()
    {
        $this->_init('Roger\BannerSlider\Model\ResourceModel\Banner');
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