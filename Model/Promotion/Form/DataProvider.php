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

namespace Smile\RetailerPromotion\Model\Promotion\Form;

use Smile\RetailerPromotion\Model\ResourceModel\Promotion\CollectionFactory;
use Smile\RetailerPromotion\Api\Data\PromotionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * DataProvider
 *
 * @category Smile
 * @package  Smile\RetailerPromotion
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Smile\RetailerPromotion\Model\ResourceModel\Promotion\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Constructor
     *
     * @param string                        $name              Name.
     * @param string                        $primaryFieldName  Primary field name.
     * @param string                        $requestFieldName  Request field name.
     * @param CollectionFactory             $collectionFactory Collection.
     * @param DataPersistorInterface        $dataPersistor     Data persistor.
     * @param StoreManagerInterface         $storeManager      Store manager.
     * @param array                         $meta              Meta.
     * @param array                         $data              Data.
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection    = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->storeManager  = $storeManager;

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Smile\RetailerPromotion\Model\Promotion $promotion */
        foreach ($items as $promotion) {
            $promotion->setData(PromotionInterface::MEDIA_PATH, $this->getMediaUrl($promotion));
            $this->loadedData[$promotion->getId()] = $promotion->getData();
        }

        $data = $this->dataPersistor->get('smile_retailer_promotion');
        if (!empty($data)) {
            $promotion = $this->collection->getNewEmptyItem();
            $promotion->setData($data);

            $this->loadedData[$promotion->getId()] = $promotion->getData();
            $this->dataPersistor->clear('smile_retailer_promotion');
        }

        return $this->loadedData;
    }

    /**
     * Get media Url.
     *
     * @param PromotionInterface $promotion Promotion.
     *
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function getMediaUrl(PromotionInterface $promotion)
    {
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA );

        return [
            0 => [
                'name' => $promotion->getMediaPath(),
                'url' => $mediaUrl.'retailerpromotion/'.$promotion->getMediaPath()
            ]
        ];
    }
}
