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

namespace Smile\RetailerPromotion\Model;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface as CollectionProcessor;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Smile\RetailerPromotion\Api\Data\PromotionInterfaceFactory;
use Smile\RetailerPromotion\Api\Data\PromotionInterface;
use Smile\RetailerPromotion\Api\Data\PromotionSearchResultsInterface;
use Smile\RetailerPromotion\Api\Data\PromotionSearchResultsInterfaceFactory;
use Smile\RetailerPromotion\Api\PromotionRepositoryInterface;
use Smile\RetailerPromotion\Model\ResourceModel\Promotion as PromotionResourceModel;
use Smile\RetailerPromotion\Model\ResourceModel\Promotion\CollectionFactory as PromotionCollectionFactory;

/**
 * Promotion Repository
 *
 * @category Smile
 * @package  Smile\RetailerPromotion
 * @author   Fanny DECLERCK <fadec@smile.fr>
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class PromotionRepository implements PromotionRepositoryInterface
{
    /**
     * @var PromotionInterfaceFactory
     */
    protected $objectFactory;

    /**
     * @var PromotionResourceModel
     */
    protected $objectResource;

    /**
     * @var PromotionSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var CollectionProcessor
     */
    protected $collectionProcessor;

    /**
     * @var FilterBuilder
     */
    protected $filterBuilder;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var PromotionCollectionFactory
     */
    protected $promotionCollectionFactory;
    /**
     * Item constructor.
     *
     * @param PromotionInterfaceFactory              $objectFactory
     * @param PromotionResourceModel                 $objectResource
     * @param PromotionSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessor                    $collectionProcessor
     * @param FilterBuilder                          $filterBuilder
     * @param SearchCriteriaBuilder                  $searchCriteriaBuilder
     * @param PromotionCollectionFactory             $promotionCollectionFactory
     */
    public function __construct(
        PromotionInterfaceFactory $objectFactory,
        PromotionResourceModel $objectResource,
        PromotionSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessor $collectionProcessor,
        FilterBuilder $filterBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        PromotionCollectionFactory $promotionCollectionFactory
    ) {
        $this->objectFactory              = $objectFactory;
        $this->objectResource             = $objectResource;
        $this->searchResultsFactory       = $searchResultsFactory;
        $this->collectionProcessor        = $collectionProcessor;
        $this->filterBuilder              = $filterBuilder;
        $this->searchCriteriaBuilder      = $searchCriteriaBuilder;
        $this->promotionCollectionFactory = $promotionCollectionFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function get($promotionId)
    {
        /** @var \Magento\Framework\Model\AbstractModel $object */
        $object = $this->objectFactory->create();
        $this->objectResource->load($object, $promotionId);

        if (!$object->getId()) {
            throw NoSuchEntityException::singleField('objectId', $promotionId);
        }

        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public function getByRetailerId($retailerId)
    {
        $this->searchCriteriaBuilder
            ->addFilter(PromotionInterface::RETAILER_ID, $retailerId);

        $searchCriteria = $this->searchCriteriaBuilder->create();
        $searchResult = $this->getList($searchCriteria);

        $items = $searchResult->getItems();
        if (empty($items)) {
            throw NoSuchEntityException::singleField(PromotionInterface::TITLE, $retailerId);
        }

        return reset($items);
    }

    /**
     * {@inheritdoc}
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Smile\RetailerPromotion\Model\ResourceModel\Promotion\Collection $collection */
        $collection = $this->promotionCollectionFactory->create();

        $searchResults = $this->searchResultsFactory->create();
        if ($searchCriteria) {
            $searchResults->setSearchCriteria($searchCriteria);
            $this->collectionProcessor->process($searchCriteria, $collection);
        }

        $collection->load();
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function save(PromotionInterface $promotion)
    {
        try {
            $this->objectResource->save($promotion);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $promotion;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(PromotionInterface $promotion)
    {
        try {
            $this->objectResource->delete($promotion);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($promotionId)
    {
        $this->delete($this->get($promotionId));
    }
}
