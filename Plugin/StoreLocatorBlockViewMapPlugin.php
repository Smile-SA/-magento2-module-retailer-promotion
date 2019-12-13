<?php
/**
 * DISCLAIMER
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category  Smile
 * @package   Smile\RetailerPromotion
 * @author    Ihor KVASNYTSKYI <ihor.kvasnytskyi@smile-ukraine.com>
 * @copyright 2019 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */
namespace Smile\RetailerPromotion\Plugin;

use Smile\RetailerPromotion\Api\PromotionRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Smile\RetailerPromotion\Api\Data\PromotionInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;

class StoreLocatorBlockViewMapPlugin
{
    /**
     * @var PromotionRepositoryInterface
     */
    private $promotionRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var FilterBuilder
     */
    private $filterBuilder;
    /**
     * @var FilterGroupBuilder
     */
    private $filterGroupBuilder;

    /**
     * StoreLocatorBlockSearchPlugin constructor.
     * @param PromotionRepositoryInterface $promotionRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterBuilder $filterBuilder
     * @param FilterGroupBuilder $filterGroupBuilder
     */
    public function __construct(
        PromotionRepositoryInterface $promotionRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        FilterGroupBuilder $filterGroupBuilder

    ) {
        $this->promotionRepository = $promotionRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
    }

    /**
     * * Add promotion in markers.
     * @param \Smile\StoreLocator\Block\View\Map $block The block Map
     * @param $result                            $result List of markers
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function afterGetMarkerData(\Smile\StoreLocator\Block\View\Map $block, $result)
    {
        if (!empty($result)) {
                $l = $result[0]['id'];
                $promoList = $this->getPromoListByRetailerId($l);
                $imageUrlPromotion = $block->getImageUrl().'/retailerpromotion/';
                foreach ($promoList as $promo) {

                    $image = $promo->getMediaPath() ? $imageUrlPromotion.$promo->getMediaPath() : false;
                    $pdfFile = $promo->getPdf() ? $promo->getPdf() : false;
                    $promotionLink = $promo->getLink() ? $promo->getLink() : false;

                    $result[0]['promotion'][] =
                        [
                            'media' => $image,
                            'title' => $promo->getTitle(),
                            'description' => $promo->getDescription(),
                            'pdfFile' => $pdfFile,
                            'link' => $promotionLink
                        ];
                }
        }
        return $result;
    }

    /**
     * Get the list of promotions.
     * @param int $retailerId
     * @return PromotionInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
    */

    public function getPromoListByRetailerId($retailerId)
    {
        $now = new \DateTime();
        $currDateFormat = $now->format('Y-m-d');

        $retailerIdFilter = $this->filterBuilder
            ->setField(PromotionInterface::RETAILER_ID)
            ->setConditionType('in')
            ->setValue([0, $retailerId])
            ->create();
        $retailerStatus = $this->filterBuilder
            ->setField(PromotionInterface::STATUS)
            ->setConditionType('in')
            ->setValue([1, 2])
            ->create();
        $retailerActive = $this->filterBuilder
            ->setField(PromotionInterface::IS_ACTIVE)
            ->setValue(true)
            ->create();
        $retailerEndDate = $this->filterBuilder
            ->setField(PromotionInterface::END_AT)
            ->setConditionType('gteq')
            ->setValue($currDateFormat)
            ->create();
        $retailerCurrentDate = $this->filterBuilder
            ->setField(PromotionInterface::CREATED_AT)
            ->setConditionType('eq')
            ->setValue($currDateFormat)
            ->create();
        $retailerCurrentDateEnd = $this->filterBuilder
            ->setField(PromotionInterface::END_AT)
            ->setConditionType('eq')
            ->setValue($currDateFormat)
            ->create();
        $retailerStartDate = $this->filterBuilder
            ->setField(PromotionInterface::CREATED_AT)
            ->setConditionType('lteq')
            ->setValue($currDateFormat)
            ->create();
        $retailerEmptyEnd = $this->filterBuilder
            ->setField(PromotionInterface::END_AT)
            ->setConditionType('null')
            ->create();
        $retailerEmptyStart = $this->filterBuilder
            ->setField(PromotionInterface::CREATED_AT)
            ->setConditionType('null')
            ->create();
        $filterGroup = [
            $this->filterGroupBuilder
                ->addFilter($retailerIdFilter)
                ->create(),
            $this->filterGroupBuilder
                ->addFilter($retailerStatus)
                ->create(),
            $this->filterGroupBuilder
                ->addFilter($retailerActive)
                ->create(),
            $this->filterGroupBuilder
                ->addFilter($retailerStartDate)
                ->addFilter($retailerCurrentDate)
                ->addFilter($retailerEmptyStart)
                ->create(),
            $this->filterGroupBuilder
                ->addFilter($retailerEndDate)
                ->addFilter($retailerCurrentDateEnd)
                ->addFilter($retailerEmptyEnd)
                ->create()
        ];
        $searchCriteria = $this->searchCriteriaBuilder
            ->setFilterGroups($filterGroup)
            ->create();
        $searchResult = $this->promotionRepository->getList($searchCriteria);

        $items = $searchResult->getItems();

        return $items;
    }
}
