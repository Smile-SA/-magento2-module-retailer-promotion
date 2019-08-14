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

namespace Smile\RetailerPromotion\Block\Adminhtml\Promotion\Edit;

use Magento\Backend\Block\Widget\Context;
use Smile\RetailerPromotion\Api\PromotionRepositoryInterface;

/**
 * AbstractButton class
 *
 * @category Smile
 * @package  Smile\RetailerPromotion
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
abstract class AbstractButton
{
    /**
     * @var Context
     */
    protected $context;

    /**s
     * @var PromotionRepositoryInterface
     */
    protected $objectRepository;

    /**
     * AbstractButton constructor.
     *
     * @param Context                      $context          Context.
     * @param PromotionRepositoryInterface $objectRepository Promotion Repository.
     */
    public function __construct(
        Context $context,
        PromotionRepositoryInterface $objectRepository
    ) {
        $this->context    = $context;
        $this->objectRepository = $objectRepository;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route  Route.
     * @param   array  $params Params.
     *
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }

    /**
     * Return promotion Id.
     *
     * @return int|null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getPromotionId()
    {
        $id = $this->context->getRequest()->getParam('id', false);

        if ($id) {
            return $this->objectRepository->get(
                $this->context->getRequest()->getParam('id')
            )->getId();
        }

        return null;
    }

    /**
     * get the button data
     *
     * @return array
     */
    abstract public function getButtonData();
}
