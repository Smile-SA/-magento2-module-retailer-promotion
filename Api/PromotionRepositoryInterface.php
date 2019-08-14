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

namespace Smile\RetailerPromotion\Api;

/**
 * Promotion Repository Interface
 *
 * @api
 */
interface PromotionRepositoryInterface
{
    /**
     * Retrieve promotion by id
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     *
     * @param int $promotionId Promotion id.
     *
     * @return \Smile\RetailerPromotion\Api\Data\PromotionInterface
     */
    public function get($promotionId);

    /**
     * Retrieve promotion by retailer id
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     *
     * @param int $retailerId retailer id.
     *
     * @return \Smile\RetailerPromotion\Api\Data\PromotionInterface
     */
    public function getByRetailerId($retailerId);

    /**
     * Retrieve promotions matching the specified criteria.
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria The search criteria
     *
     * @return \Smile\RetailerPromotion\Api\Data\PromotionSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Save promotion.
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     *
     * @param \Smile\RetailerPromotion\Api\Data\PromotionInterface $promotion The promotion

     * @return \Smile\RetailerPromotion\Api\Data\PromotionInterface
     */
    public function save(Data\PromotionInterface $promotion);

    /**
     * Delete promotion.
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     *
     * @param \Smile\RetailerPromotion\Api\Data\PromotionInterface $promotion The $promotion
     *
     * @return bool true on success
     */
    public function delete(Data\PromotionInterface $promotion);

    /**
     * Delete promotion by ID.
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     *
     * @param int $promotionId The promotion Id
     *
     * @return bool true on success
     */
    public function deleteById($promotionId);
}
