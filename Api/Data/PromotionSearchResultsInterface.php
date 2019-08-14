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

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for promotion search results.
 *
 * @api
 */
interface PromotionSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get promotions list.
     *
     * @return \Smile\RetailerPromotion\Api\Data\PromotionInterface[]
     */
    public function getItems();

    /**
     * Set promotions list.
     *
     * @param \Smile\RetailerPromotion\Api\Data\PromotionInterface[] $items The items
     *
     * @return $this
     */
    public function setItems(array $items);
}
