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
    /**
     * @var PromotionRepositoryInterface
     */
    private $promotionRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * StoreLocatorBlockSearchPlugin constructor.
     * @param PromotionRepositoryInterface $promotionRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param array $data
     */
    public function __construct(
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
     * @param \Smile\StoreLocator\Block\Search  $block  The block search
     * @param $result                           $result List of markers
     * @return  array
     * @throws \Magento\Framework\Exception\LocalizedException
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

    /**
     * Get the list of promotions.
     * @param int $retailerId
     * @return PromotionInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
    */
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
