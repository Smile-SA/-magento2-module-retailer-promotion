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

namespace Smile\RetailerPromotion\Model;

use Smile\RetailerPromotion\Api\Data\PromotionInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Promotion Model
 *
 * @SuppressWarnings(PHPMD.CamelCasePropertyName) properties are inherited.
 *
 * @category Smile
 * @package  Smile\RetailerPromotion
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
class Promotion extends AbstractModel implements PromotionInterface, IdentityInterface
{
    /**
     * @var string
     */
    const CACHE_TAG = self::TABLE_NAME;

    /**
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Construct.
     */
    protected function _construct()
    {
        $this->_init(\Smile\RetailerPromotion\Model\ResourceModel\Promotion::class);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId(), self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        return $this->getData(self::PROMOTION_ID);
    }

    /**
     * {@inheritDoc}
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * {@inheritDoc}
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * {@inheritDoc}
     */
    public function getIsActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * {@inheritDoc}
     */
    public function getMediaPath()
    {
        return $this->getData(self::MEDIA_PATH);
    }

    /**
     * {@inheritDoc}
     */
    public function getPdf()
    {
        return $this->getData(self::PDF);
    }

    /**
     * {@inheritDoc}
     */
    public function getLink()
    {
        return $this->getData(self::LINK);
    }

    /**
     * {@inheritDoc}
     */
    public function getRetailerId()
    {
        return $this->getData(self::RETAILER_ID);
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * {@inheritDoc}
     */
    public function getEndAt()
    {
        return $this->getData(self::END_AT);
    }

    /**
     * {@inheritDoc}
     */
    public function setId($id)
    {
        return $this->setData(self::PROMOTION_ID, $id);
    }

    /**
     * {@inheritDoc}
     */
    public function SetTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * {@inheritDoc}
     */
    public function SetDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * {@inheritDoc}
     */
    public function SetStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * {@inheritDoc}
     */
    public function SetMediaPath($path)
    {
        return $this->setData(self::MEDIA_PATH, $path);
    }

    /**
     * {@inheritDoc}
     */
    public function SetPdf($path)
    {
        return $this->setData(self::PDF, $path);
    }

    /**
     * {@inheritDoc}
     */
    public function SetLink($path)
    {
        return $this->setData(self::LINK, $path);
    }

    /**
     * {@inheritDoc}
     */
    public function SetRetailerId($retailerId)
    {
        return $this->setData(self::RETAILER_ID, $retailerId);
    }

    /**
     * {@inheritDoc}
     */
    public function SetCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * {@inheritDoc}
     */
    public function SetEndAt($endAt)
    {
        return $this->setData(self::END_AT, $endAt);
    }
}
