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
namespace Smile\RetailerPromotion\Model\Status\Source;

/**
 * Status class
 *
 * @category Smile
 * @package  Smile\RetailerPromotion
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
class Status implements \Magento\Framework\Data\OptionSourceInterface
{
    /**#@+
     * Promotion's Statuses
     */
    const STATUS_LOCAL = 1;
    const STATUS_CENTRAL = 2;
    /**#@-*/

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }

    /**
     * Prepare promotion's statuses.
     *
     * @return array
     */
    protected function getAvailableStatuses()
    {
        return [self::STATUS_LOCAL => __('Local'), self::STATUS_CENTRAL => __('Central')];
    }
}
