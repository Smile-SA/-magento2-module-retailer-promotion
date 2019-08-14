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

namespace Smile\RetailerPromotion\Api\Data;

/**
 * Data Api for Promotions
 *
 * @api
 */
interface PromotionInterface
{
    /**
     * The table name
     */
    const TABLE_NAME  = 'smile_retailer_promotion';

    /**
     * The promotion Id field
     */
    const PROMOTION_ID  = 'promotion_id';

    /**
     * The promotion title field
     */
    const TITLE       = 'title';

    /**
     * The promotion description field
     */
    const DESCRIPTION = 'description';

    /**
     * The promotion status field
     */
    const STATUS      = 'status';

    /**
     * The promotion is_active field
     */
    const IS_ACTIVE   = 'is_active';

    /**
     * The promotion media_path field
     */
    const MEDIA_PATH  = 'media_path';

    /**
     * The promotion pdf field
     */
    const PDF         = 'pdf';

    /**
     * The promotion link field
     */
    const LINK        = 'link';

    /**
     * The promotion retailer_id field
     */
    const RETAILER_ID = 'retailer_id';

    /**
     * The promotion created_at field
     */
    const CREATED_AT  = 'created_at';

    /**
     * The promotion end_at field
     */
    const END_AT      = 'end_at';

    /**
     * Get ID.
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get tile.
     *
     * @return string|null
     */
    public function getTitle();

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription();

    /**
     * Get status.
     *
     * @return int|null
     */
    public function getStatus();

    /**
     * Get is_active.
     *
     * @return bool|null
     */
    public function getIsActive();

    /**
     * Get media path.
     *
     * @return string|null
     */
    public function getMediaPath();

    /**
     * Get pdf.
     *
     * @return string|null
     */
    public function getPdf();

    /**
     * Get link.
     *
     * @return string|null
     */
    public function getLink();

    /**
     * Get retailer id.
     *
     * @return int|null
     */
    public function getRetailerId();

    /**
     * Get created at.
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Get end at.
     *
     * @return string|null
     */
    public function getEndAt();

    /**
     * Set ID.
     *
     * @param int $promotionId Promotion ID.
     *
     * @return \Smile\RetailerPromotion\Api\Data\PromotionInterface
     */
    public function SetId($promotionId);

    /**
     * Set title.
     *
     * @param string $title Title.
     *
     * @return \Smile\RetailerPromotion\Api\Data\PromotionInterface
     */
    public function SetTitle($title);

    /**
     * Set description.
     *
     * @param string $description Description.
     *
     * @return \Smile\RetailerPromotion\Api\Data\PromotionInterface
     */
    public function SetDescription($description);

    /**
     * Set status.
     *
     * @param int $status Status.
     *
     * @return \Smile\RetailerPromotion\Api\Data\PromotionInterface
     */
    public function SetStatus($status);

    /**
     * Set media path.
     *
     * @param string $path Media file path;
     *
     * @return \Smile\RetailerPromotion\Api\Data\PromotionInterface
     */
    public function SetMediaPath($path);

    /**
     * Set pdf.
     *
     * @param string $pdf Pdf.
     *
     * @return \Smile\RetailerPromotion\Api\Data\PromotionInterface
     */
    public function SetPdf($pdf);

    /**
     * Set link.
     *
     * @param string $link Link.
     *
     * @return \Smile\RetailerPromotion\Api\Data\PromotionInterface
     */
    public function SetLink($link);

    /**
     * Set retailer id.
     *
     * @param int $retailerId Retailer Id.
     *
     * @return \Smile\RetailerPromotion\Api\Data\PromotionInterface
     */
    public function SetRetailerId($retailerId);

    /**
     * Set created at.
     *
     * @param string $createdAt Created at.
     *
     * @return \Smile\RetailerPromotion\Api\Data\PromotionInterface
     */
    public function SetCreatedAt($createdAt);

    /**
     * Set end at.
     *
     * @param string $endAt End at.
     *
     * @return \Smile\RetailerPromotion\Api\Data\PromotionInterface
     */
    public function SetEndAt($endAt);
}
