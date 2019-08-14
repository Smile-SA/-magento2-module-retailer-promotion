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

use Smile\RetailerPromotion\Api\Data\PromotionInterfaceFactory;
use Smile\RetailerPromotion\Api\Data\PromotionInterface;
use Smile\RetailerPromotion\Controller\Adminhtml\AbstractPromotion;

/**
 * Retailer Promotion Adminhtml Save controller.
 *
 * @category Smile
 * @package  Smile\RetailerPromotion
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
class Save extends AbstractPromotion
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $data         = $this->getRequest()->getPostValue();
        $redirectBack = $this->getRequest()->getParam('back', false);

        if ($data) {
            $identifier = $this->getRequest()->getParam('promotion_id');
            $retailerIds = $this->getRequest()->getParam('retailer_id', false);

            $media = false;
            if (!empty($data[PromotionInterface::MEDIA_PATH])) {
                $media = $data[PromotionInterface::MEDIA_PATH][0]['name'];
            }

            /** @var PromotionInterface $model*/
            $model = $this->promotionFactory->create();

            if ($identifier) {
                $model = $this->promotionRepository->get($identifier);
                $retailerIds = [$model->getRetailerId()];
                if (!$model->getId()) {
                    $this->messageManager->addErrorMessage(__('This promotion no longer exists.'));

                    return $resultRedirect->setPath('*/*/');
                }
            }

            foreach ($retailerIds as $retailerId) {
                $model->setData($data);
                $model->setRetailerId($retailerId);

                if ($media) {
                    $model->setMediaPath($retailerId. '_' .$media);
                }

                try {
                    $this->promotionRepository->save($model);
                    $model = $this->promotionFactory->create();
                    $this->messageManager->addSuccessMessage(__('You saved the promotion %1.', $model->getTitle()));
                    $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);

                    if ($redirectBack) {
                        return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                    }
                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage($e->getMessage());
                    $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData($data);

                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                }
            }

            return $resultRedirect->setPath('*/*/');
        }

        return $resultRedirect->setPath('*/*/');
    }
}
