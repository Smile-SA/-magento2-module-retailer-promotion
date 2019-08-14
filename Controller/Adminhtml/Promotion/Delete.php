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

/**
 * Delete Controller for Promotion
 *
 * @category Smile
 * @package  Smile\RetailerPromotion
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
class Delete extends AbstractPromotion
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $identifier = $this->getRequest()->getParam('id', false);
        $model = $this->promotionFactory->create();
        if ($identifier) {
            $model = $this->promotionRepository->get($identifier);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This promotion no longer exists.'));

                return $resultRedirect->setPath('*/*/index');
            }
        }

        try {
            $this->promotionRepository->delete($model);
            $this->messageManager->addSuccessMessage(__('You deleted the promotion %1.', $model->getId()));

            return $resultRedirect->setPath('*/*/index');
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());

            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
    }
}
