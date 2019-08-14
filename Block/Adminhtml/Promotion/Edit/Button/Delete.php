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

namespace Smile\RetailerPromotion\Block\Adminhtml\Promotion\Edit\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Smile\RetailerPromotion\Block\Adminhtml\Promotion\Edit\AbstractButton;

/**
 * Delete class
 *
 * @category Smile
 * @package  Smile\RetailerPromotion
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
class Delete extends AbstractButton implements ButtonProviderInterface
{
    /**
     * get the button data
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getButtonData()
    {
        $data = [];
        if ($this->getPromotionId()) {
            $message = htmlentities(__('Are you sure you want to delete this Promotion ?'));

            $data = [
                'label'      => __('Delete Promotion'),
                'class'      => 'delete',
                'on_click'   => "deleteConfirm('{$message}', '{$this->getDeleteUrl()}')",
                'sort_order' => 20,
            ];
        }

        return $data;
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', ['id' => $this->getPromotionId()]);
    }
}
