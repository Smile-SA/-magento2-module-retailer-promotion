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
namespace Smile\RetailerPromotion\Controller\Adminhtml\Promotion;

use Smile\RetailerPromotion\Controller\Adminhtml\AbstractPromotion;
use Magento\Framework\Controller\ResultFactory;

/**
 * MassDelete Controller for Promotion
 *
 * @category Smile
 * @package  Smile\RetailerPromotion
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
class MassDelete extends AbstractPromotion
{
    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $promotionIds = $this->getRequest()->getParam('selected');
        foreach ($promotionIds as $id) {
            $model = $this->promotionRepository->get($id);
            $this->promotionRepository->delete($model);
        }

        $this->messageManager->addSuccessMessage(
            __('A total of %1 record(s) have been deleted.', count($promotionIds))
        );

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
