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

namespace Smile\RetailerPromotion\Model\ResourceModel;

use Magento\Framework\DB\Select;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\EntityManager\EntityManager;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Stdlib\DateTime;
use Smile\RetailerPromotion\Api\Data\PromotionInterface;
use Smile\RetailerPromotion\Model\PromotionMediaUpload;

/**
 * Promotion Resource Model
 *
 * @category Smile
 * @package  Smile\RetailerPromotion
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
class Promotion extends AbstractDb
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var MetadataPool
     */
    protected $metadataPool;

    /**
     * @var DateTime
     */
    protected $dateTime;

    /**
     * @var PromotionMediaUpload
     */
    protected $mediaUpload;

    /**
     * Promotion constructor.
     *
     * @param Context              $context        Application Context
     * @param EntityManager        $entityManager  Entity Manager
     * @param MetadataPool         $metadataPool   Metadata Pool
     * @param DateTime             $dateTime       Datetime
     * @param PromotionMediaUpload $mediaUpload    Media upload
     * @param string               $connectionName Connection name
     */
    public function __construct(
        Context $context,
        EntityManager $entityManager,
        MetadataPool $metadataPool,
        DateTime $dateTime,
        PromotionMediaUpload $mediaUpload,
        $connectionName = null
    ) {
        $this->entityManager = $entityManager;
        $this->metadataPool  = $metadataPool;
        $this->dateTime      = $dateTime;
        $this->mediaUpload   = $mediaUpload;

        parent::__construct($context, $connectionName);
    }

    /**
     * {@inheritDoc}
     */
    public function getConnection()
    {
        return $this->metadataPool->getMetadata(PromotionInterface::class)->getEntityConnection();
    }

    /**
     * Load a promotion by a given field's value.
     *
     * @param \Magento\Framework\Model\AbstractModel $object The promotion
     * @param mixed                                  $value  The value
     * @param null                                   $field  The field, if any
     *
     * @return $this
     * @throws \Exception
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function load(AbstractModel $object, $value, $field = null)
    {
        $promotionId = $this->getPromotionId($object, $value, $field);
        if ($promotionId) {
            $this->entityManager->load($object, $promotionId);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function save(AbstractModel $object)
    {
        foreach ([PromotionInterface::CREATED_AT, PromotionInterface::END_AT] as $field) {
            $value = !$object->getData($field) ? null : $this->dateTime->formatDate($object->getData($field));
            $object->setData($field, $value);
        }

        $this->entityManager->save($object);
        $this->mediaUpload->removeMediaFromTmp($object);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function delete(AbstractModel $object)
    {
        $this->entityManager->delete($object);
        $this->mediaUpload->removeMedia($object);

        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @SuppressWarnings(PHPMD.CamelCaseMethodName) Method is inherited.
     */
    protected function _construct()
    {
        $this->_init(
            PromotionInterface::TABLE_NAME,
            PromotionInterface::PROMOTION_ID
        );
    }

    /**
     * Retrieve promotion Id by field value
     *
     * @param \Magento\Framework\Model\AbstractModel $object The promotion
     * @param mixed                                  $value  The value
     * @param null                                   $field  The field
     *
     * @return int|false
     * @throws \Exception
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function getPromotionId(AbstractModel $object, $value, $field = null)
    {
        $entityMetadata = $this->metadataPool->getMetadata(PromotionInterface::class);
        if ($field === null) {
            $field = PromotionInterface::PROMOTION_ID;
        }

        $entityId = $value;

        if ($field != $entityMetadata->getIdentifierField()) {
            $select = $this->_getLoadSelect($field, $value, $object);
            $select->reset(Select::COLUMNS)
                ->columns($this->getMainTable() . '.' . $entityMetadata->getIdentifierField())
                ->limit(1);

            $result = $this->getConnection()->fetchCol($select);
            $entityId = count($result) ? $result[0] : false;
        }

        return $entityId;
    }
}
