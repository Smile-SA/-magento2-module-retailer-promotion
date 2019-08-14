<?php
/**
 * DISCLAIMER
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category  Smile
 * @package   Smile\RetailerPromotion
 * @author    Fanny DECLERCK <fadec@smile.fr>
 * @copyright 2019 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Smile\RetailerPromotion\Model\ResourceModel\Promotion;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Promotion Collection class
 *
 * @category Smile
 * @package  Smile\RetailerPromotion
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
class Collection extends AbstractCollection
{
    /**
     * Define resource model
     * @SuppressWarnings(PHPMD.CamelCaseMethodName) Method is inherited.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Smile\RetailerPromotion\Model\Promotion::class,
            \Smile\RetailerPromotion\Model\ResourceModel\Promotion::class
        );
    }
}
