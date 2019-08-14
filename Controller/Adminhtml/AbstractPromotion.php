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

namespace Smile\RetailerPromotion\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Smile\RetailerPromotion\Api\PromotionRepositoryInterface;
use Smile\RetailerPromotion\Api\Data\PromotionInterfaceFactory;

/**
 * Abstract Controller for retailer promotion management.
 *
 * @category Smile
 * @package  Smile\RetailerPromotion
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
abstract class AbstractPromotion extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory|null
     */
    protected $resultPageFactory = null;

    /**
     * Core registry
     *
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * Promotion Repository
     *
     * @var PromotionRepositoryInterface
     */
    protected $promotionRepository;

    /**
     * Promotion Factory
     *
     * @var PromotionInterfaceFactory
     */
    protected $promotionFactory;

    /**
     * Abstract constructor.
     *
     * @param Context                      $context             Application context
     * @param PageFactory                  $resultPageFactory   Result Page factory
     * @param Registry                     $coreRegistry        Application registry
     * @param PromotionRepositoryInterface $promotionRepository Promotion Repository
     * @param PromotionInterfaceFactory    $promotionFactory    Promotion Factory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $coreRegistry,
        PromotionRepositoryInterface $promotionRepository,
        PromotionInterfaceFactory $promotionFactory
    ) {
        $this->resultPageFactory   = $resultPageFactory;
        $this->coreRegistry        = $coreRegistry;
        $this->promotionRepository = $promotionRepository;
        $this->promotionFactory    = $promotionFactory;

        parent::__construct($context);
    }

    /**
     * Create result page
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function createPage()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Smile_RetailerPromotion::retailer_promotions')
            ->addBreadcrumb(__('Sellers'), __('Retailers'), __('Promotions'));

        return $resultPage;
    }

    /**
     * Check if allowed to manage promotion
     *
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Smile_RetailerPromotion::retailer_promotions');
    }
}
