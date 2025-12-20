<?php

namespace \ProductPageBestsellers\ViewModel;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * ViewModel class to get best-selling products in the current product's categories.
 */
class Bestsellers implements ArgumentInterface
{
    /**
     * Default limit of bestsellers to retrieve.
     *
     * @var int
     */
    private int $limit = 3;

    /**
     * Bestsellers constructor.
     *
     * @param CollectionFactory $productCollectionFactory Factory to create product collections
     * @param Registry $registry Magento registry to get current product
     */
    public function __construct(
        protected CollectionFactory $productCollectionFactory,
        protected Registry $registry
    ) {
    }

    /**
     * Retrieve top-selling products in the same categories as the current product,
     *
     * Excluding the current product itself.
     *
     * @param int|null $limit Number of products to retrieve. Defaults to $this->limit if null.
     * @return Collection|array
     */
    public function getTopSellingProducts(int $limit = null)
    {
        $limit = $limit ?? $this->limit;

        /** @var Product $currentProduct */
        $currentProduct = $this->registry->registry('current_product');

        if (!$currentProduct || !$currentProduct->getId()) {
            return [];
        }

        $categoryIds = $currentProduct->getCategoryIds();

        if (empty($categoryIds)) {
            return [];
        }

        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect(['name', 'price', 'small_image'])
            ->addCategoriesFilter(['in' => $categoryIds])
            ->addAttributeToFilter('entity_id', ['neq' => $currentProduct->getId()])
            ->setPageSize($limit)
            ->addAttributeToSort('ordered_qty', 'desc');

        return $collection;
    }
}
