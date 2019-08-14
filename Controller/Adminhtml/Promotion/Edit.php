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

namespace Smile\RetailerPromotion\Controller\Adminhtml\Promotion;

use Magento\Framework\Exception\NoSuchEntityException;
use Smile\RetailerPromotion\Controller\Adminhtml\AbstractPromotion;

/**
 * Retailer Promotion Adminhtml Edit controller.
 *
 * @category Smile
 * @package  Smile\RetailerPromotion
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
class Edit extends AbstractPromotion
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $promotionId = (int) $this->getRequest()->getParam('id');
        $isExistingPromotion = (bool) $promotionId;

        if ($isExistingPromotion) {
            try {
                $promotion = $this->promotionRepository->get($promotionId);
                $this->coreRegistry->register('current_promotion', $promotion);

                $resultPage = $this->createPage();
                $resultPage->getConfig()->getTitle()->prepend(
                    __('Edit promotion %1 ', $promotion->getId())
                );
                $resultPage->addBreadcrumb(__('Promotion'), __('Promotion'));

                return $resultPage;
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while editing the promotion.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setPath('*/*/index');

                return $resultRedirect;
            }
        }

        $this->_forward('create');
    }
}
