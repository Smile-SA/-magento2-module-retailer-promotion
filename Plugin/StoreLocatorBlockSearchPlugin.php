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

class StoreLocatorBlockSearchPlugin
{
    private $promotionRepository;
    /**
     * Constructor.
     * @param array                                                          $data                      Additional data.
     */
    public function __construct(
        \Smile\StoreLocator\Helper\Data $storeLocatorHelper,
        PromotionRepositoryInterface $promotionRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        $data = []
    ) {
        $this->promotionRepository = $promotionRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }


    /**
     * Add promotion in markers.
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter).
     *
     * @param \Smile\Storelocator\Block\Search $block  The block search
     * @param array                            $result List of markers
     *
     * @return array
     */
    public function afterGetMarkers(\Smile\StoreLocator\Block\Search $block, $result)
    {
        if (!empty($result)) {
            foreach ($result as $key => $marker) {
                $promoList = $this->getPromoListByRetailerId($marker['id']);

                $imageUrlPromotion = $block->getImageUrl().'/retailerpromotion/';

                foreach ($promoList as $promo) {
                    $image = $promo->getMediaPath() ? $imageUrlPromotion.$promo->getMediaPath() : false;
                    $result[$key]['promotion'][] =
                        [
                            'media' => $image,
                            'title' => $promo->getTitle(),
                            'description' => $promo->getDescription(),
                        ];
                }
            }
        }

        return $result;
    }

    public function getPromoListByRetailerId($retailerId)
    {
        $now = new \DateTime();
        $currDateFormat = $now->format('Y-m-d H:i:s');

        $this->searchCriteriaBuilder
            ->addFilter(PromotionInterface::RETAILER_ID, $retailerId)
            ->addFilter(PromotionInterface::STATUS, 2)
            ->addFilter(PromotionInterface::IS_ACTIVE, true)
            ->addFilter(PromotionInterface::CREATED_AT, $currDateFormat, 'lteq')
            ->addFilter(PromotionInterface::END_AT, $currDateFormat, 'gteq');

        $searchCriteria = $this->searchCriteriaBuilder->create();
        $searchResult = $this->promotionRepository->getList($searchCriteria);

        $items = $searchResult->getItems();

        return $items;
    }
}