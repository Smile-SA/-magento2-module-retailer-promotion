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
 * Retailer Promotion Creation Controller
 *
 * @category Smile
 * @package  Smile\RetailerPromotion
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
class Create extends AbstractPromotion
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $this->coreRegistry->register("current_promotion", $this->promotionFactory->create([]));

        $resultPage = $this->createPage();

        $resultPage->setActiveMenu('Smile_RetailerPromotion::retailer_promotion');
        $resultPage->getConfig()->getTitle()->prepend(__('New Retailer Promotion'));

        return $resultPage;
    }
}
