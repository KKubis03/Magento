<?php

declare(strict_types=1);

namespace ProductSlider\Model\ProductProvider;

use \ProductSlider\Model\ProductProviderInterface;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Model\Product\Attribute\Source\Status;

class CategoryProductProvider implements ProductProviderInterface
{
    /**
     * Product provider constructor
     *
     * @param CollectionFactory $collectionFactory
     * @param StoreManagerInterface $storeManager
     * @param Visibility $productVisibility
     * @param Status $productStatus
     * @param int $categoryId
     */
    public function __construct(
        private readonly CollectionFactory $collectionFactory,
        private readonly StoreManagerInterface $storeManager,
        private readonly Visibility $productVisibility,
        private readonly Status $productStatus,
        private readonly int $categoryId = 0
    ) {
    }

    /**
     * Function to get products basen on category
     *
     * @param int $limit
     * @return Collection
     * @throws NoSuchEntityException
     */
    public function getProducts(int $limit): Collection
    {
        $store = $this->storeManager->getStore();
        $collection = $this->collectionFactory->create();
        $collection->addAttributeToSelect(['name', 'price', 'small_image'])
            ->addStoreFilter($store->getId())
            ->addCategoriesFilter(['in' => $this->categoryId])
            ->setVisibility($this->productVisibility->getVisibleInCatalogIds())
            ->addAttributeToFilter('status', ['in' => $this->productStatus->getVisibleStatusIds()])
            ->setPageSize($limit)
            ->setCurPage(1);

        return $collection;
    }
}
