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

namespace Smile\RetailerPromotion\Cron;

use Smile\RetailerPromotion\Api\PromotionRepositoryInterface;
use Smile\RetailerPromotion\Api\Data\PromotionInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Stdlib\DateTime\DateTime;

/**
 * UpdateStatus cron for retailer promotion management.
 *
 * @category Smile
 * @package  Smile\RetailerPromotion
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
class UpdateStatus
{
    /**
     * @var PromotionRepositoryInterface
     */
    protected $promotionRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var DateTime
     */
    protected  $date;

    /**
     * UpdateStatus constructor.
     *
     * @param PromotionRepositoryInterface $promotionRepository   Repository.
     * @param SearchCriteriaBuilder        $searchCriteriaBuilder Search criteria.
     * @param DateTime                     $date                  Date.
     */
    public function __construct(
        PromotionRepositoryInterface $promotionRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        DateTime $date
    ) {
        $this->promotionRepository   = $promotionRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->date                  = $date;
    }

    /**
     * Execute task
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $date = $this->date->gmtDate();

        $this->searchCriteriaBuilder
            ->addFilter(PromotionInterface::END_AT, $date, 'lteq')
            ->addFilter(PromotionInterface::IS_ACTIVE, true);

        $searchCriteria = $this->searchCriteriaBuilder->create();
        $searchResult = $this->promotionRepository->getList($searchCriteria)->getItems();

        if(!empty($searchResult)) {
            foreach ($searchResult as $result) {
                $result->setIsActive(false);
                $this->promotionRepository->save($result);
            }
        }
    }
}
