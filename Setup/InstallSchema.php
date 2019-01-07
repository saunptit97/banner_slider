<?php

namespace Roger\BannerSlider\Setup;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Filesystem;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Mageplaza\BannerSlider\Model\Config\Source\Template;
use Psr\Log\LoggerInterface;

/**
 * Class InstallSchema
 * @package Mageplaza\BannerSlider\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @var Filesystem
     */
    protected $fileSystem;

    /**
     * @var Template
     */
    protected $template;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * InstallSchema constructor.
     *
     * @param Template $template
     * @param Filesystem $filesystem
     * @param LoggerInterface $logger
     */
    public function __construct(
        Template $template,
        Filesystem $filesystem,
        LoggerInterface $logger
    )
    {
        $this->logger     = $logger;
        $this->template   = $template;
        $this->fileSystem = $filesystem;
    }

    /**
     * install tables
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     *
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('roger_bannerslider_banner')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('roger_bannerslider_banner'))
                ->addColumn('banner_id', Table::TYPE_INTEGER, null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true
                    ], 'Banner ID')
                ->addColumn('name', Table::TYPE_TEXT, 255, ['nullable => false'], 'Banner Name')
                ->addColumn('status', Table::TYPE_SMALLINT, null, ['nullable' => false, 'default' => '1'], 'Banner Status')
                ->addColumn('type', Table::TYPE_SMALLINT, null, ['nullable' => false, 'default' => '0'], 'Banner Type')
                ->addColumn('content', Table::TYPE_TEXT, '64k', [], 'Custom html, css')
                ->addColumn('image', Table::TYPE_TEXT, 255, [], 'Banner Image')
                ->addColumn('url_banner', Table::TYPE_TEXT, 255, [], 'Banner Url')
                ->addColumn('title', Table::TYPE_TEXT, 255, [], 'Title')
                ->addColumn('newtab', Table::TYPE_SMALLINT, null, ['nullable' => false, 'default' => '1'], 'Open new tab')
                ->addColumn('created_at', Table::TYPE_TIMESTAMP, null, [], 'Banner Created At')
                ->addColumn('updated_at', Table::TYPE_TIMESTAMP, null, [], 'Banner Updated At')
                ->setComment('Banner Table');
            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(
                $installer->getTable('roger_bannerslider_banner'),
                $setup->getIdxName(
                    $installer->getTable('roger_bannerslider_banner'),
                    ['name', 'image', 'url_banner'],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['name', 'image', 'url_banner'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        }
        if (!$installer->tableExists('roger_bannerslider_slider')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('roger_bannerslider_slider'))
                ->addColumn('slider_id', Table::TYPE_INTEGER, null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true
                    ], 'Slider ID')
                ->addColumn('name', Table::TYPE_TEXT, 255, ['nullable => false'], 'Slider Name')
                ->addColumn('status', Table::TYPE_SMALLINT, null, ['nullable' => false, 'default' => '1'], 'Slider Status')
                ->addColumn('location', Table::TYPE_TEXT, 1000, [], 'Location')
                ->addColumn('store_ids', Table::TYPE_TEXT, 255, [])
                ->addColumn('customer_group_ids', Table::TYPE_TEXT, 255, [])
                ->addColumn('priority', Table::TYPE_INTEGER, null, ['unsigned' => true, 'nullable' => false, 'default' => '0'], 'Priority')
                ->addColumn('effect', Table::TYPE_TEXT, 255, [], 'Animation effect')
                ->addColumn('width', Table::TYPE_INTEGER, null,  ['nullable' => false, 'default' => '0'], 'Width')
                ->addColumn('height', Table::TYPE_INTEGER, null,  ['nullable' => false, 'default' => '0'], 'Height')
                ->addColumn('design', Table::TYPE_SMALLINT, null, ['nullable' => false, 'default' => '0'], 'Manually design')
                ->addColumn('loop', Table::TYPE_SMALLINT, null, [], 'Loop slider')
                ->addColumn('lazyLoad', Table::TYPE_SMALLINT, null, [], 'Lazyload image')
                ->addColumn('autoplay', Table::TYPE_SMALLINT, null, [], 'Autoplay')
                ->addColumn('autoplayTimeout', Table::TYPE_TEXT, 255, ['default' => '5000'], 'autoplay Timeout')
                ->addColumn('nav', Table::TYPE_SMALLINT, null, [], 'Navigation')
                ->addColumn('dots', Table::TYPE_SMALLINT, null, [], 'Dots')
                ->addColumn('is_responsive', Table::TYPE_SMALLINT, null, [], 'Responsive')
                ->addColumn('responsive_items', Table::TYPE_TEXT, 255, [], 'Max Items Slider')
                ->addColumn('from_date', Table::TYPE_DATE, null, ['nullable' => true, 'default' => null], 'From')
                ->addColumn('to_date', Table::TYPE_DATE, null, ['nullable' => true, 'default' => null], 'To')
                ->addColumn('created_at', Table::TYPE_TIMESTAMP, null, [], 'Slider Created At')
                ->addColumn('updated_at', Table::TYPE_TIMESTAMP, null, [], 'Slider Updated At')
                ->setComment('Slider Table');

            $installer->getConnection()->createTable($table);
        }
        if (!$installer->tableExists('roger_bannerslider_banner_slider')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('roger_bannerslider_banner_slider'))
                ->addColumn('slider_id', Table::TYPE_INTEGER, null, ['unsigned' => true, 'nullable' => false, 'primary' => true,], 'Slider ID')
                ->addColumn('banner_id', Table::TYPE_INTEGER, null, ['unsigned' => true, 'nullable' => false, 'primary' => true,], 'Banner ID')
                ->addColumn('position', Table::TYPE_INTEGER, null, ['nullable' => false, 'default' => '0'], 'Position')
                ->addIndex($installer->getIdxName('roger_bannerslider_banner_slider', ['slider_id']), ['slider_id'])
                ->addIndex($installer->getIdxName('roger_bannerslider_banner_slider', ['banner_id']), ['banner_id'])
                ->addForeignKey(
                    $installer->getFkName(
                        'roger_bannerslider_banner_slider',
                        'slider_id',
                        'roger_bannerslider_slider',
                        'slider_id'
                    ),
                    'slider_id',
                    $installer->getTable('roger_bannerslider_slider'),
                    'slider_id',
                    Table::ACTION_CASCADE,
                    Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $installer->getFkName(
                        'roger_bannerslider_banner_slider',
                        'banner_id',
                        'roger_bannerslider_banner',
                        'banner_id'
                    ),
                    'banner_id',
                    $installer->getTable('roger_bannerslider_banner'),
                    'banner_id',
                    Table::ACTION_CASCADE,
                    Table::ACTION_CASCADE
                )
                ->addIndex(
                    $installer->getIdxName(
                        'roger_bannerslider_banner_slider',
                        [
                            'slider_id',
                            'banner_id'
                        ],
                        AdapterInterface::INDEX_TYPE_UNIQUE
                    ),
                    [
                        'slider_id',
                        'banner_id'
                    ],
                    [
                        'type' => AdapterInterface::INDEX_TYPE_UNIQUE
                    ]
                )
                ->setComment('Slider To Banner Link Table');
            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();
    }
}