<?php
/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category  Smile
 * @package   Smile\RetailerPromotion
 * @author    Fanny DECLERCK <fadec@smile.fr>
 * @copyright 2019 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Smile\RetailerPromotion\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Smile\RetailerPromotion\Api\Data\PromotionInterface;

/**
 * Promotion schema install class.
 *
 * @category Smile
 * @package  Smile\RetailerPromotion
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $this->createPromotionTable($setup);

        $setup->endSetup();
    }

    /**
     * Create the promotion table.
     *
     * @param \Magento\Framework\Setup\SchemaSetupInterface $setup The Setup
     *
     * @throws \Zend_Db_Exception
     */
    private function createPromotionTable(SchemaSetupInterface $setup)
    {
        $table = $setup->getConnection()
            ->newTable($setup->getTable(PromotionInterface::TABLE_NAME))
            ->addColumn(
                PromotionInterface::PROMOTION_ID,
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Entity ID'
            )
            ->addColumn(
                PromotionInterface::TITLE,
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'TITLE'
            )
            ->addColumn(
                PromotionInterface::DESCRIPTION,
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                [],
                'Description'
            )
            ->addColumn(
                PromotionInterface::STATUS,
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Status'
            )
            ->addColumn(
                PromotionInterface::IS_ACTIVE,
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'IS_ACTIVE'
            )
            ->addColumn(
                PromotionInterface::MEDIA_PATH,
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Media file path'
            )
            ->addColumn(
                PromotionInterface::PDF,
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'PDF'
            )
            ->addColumn(
                PromotionInterface::LINK,
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'LINK'
            )
            ->addColumn(
                PromotionInterface::RETAILER_ID,
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Retailer ID'
            )
            ->addColumn(
                PromotionInterface::CREATED_AT,
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                [],
                'Creation Time'
            )
            ->addColumn(
                PromotionInterface::END_AT,
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                [],
                'End at'
            )
            ->addForeignKey(
                $setup->getFkName(
                    PromotionInterface::TABLE_NAME,
                    PromotionInterface::RETAILER_ID,
                    'smile_seller_entity',
                    'entity_id'),
                PromotionInterface::RETAILER_ID,
                $setup->getTable('smile_seller_entity'),
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            );

        $setup->getConnection()->createTable($table);
    }
}
