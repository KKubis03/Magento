<?php

declare(strict_types=1);

namespace \LastViewedProduct\Block;

use Exception;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductRepository;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\View\Element\Template;

/**
 * Block class to retrieve and display the last viewed product for the current customer.
 */
class LastViewedProduct extends Template
{
    /**
     * Cache tag constant
     */
    public const CACHE_TAG = '_LAST_VIEWED_PRODUCT';

    /**
     * @var string
     */
    protected string $_cacheTag = self::CACHE_TAG;
    /**
     * LastViewedProduct Constructor
     *
     * @param Template\Context $context
     * @param CustomerSession $customerSession
     * @param ProductRepository $productRepository
     * @param array $data
     */
    public function __construct(
        protected Template\Context  $context,
        protected CustomerSession   $customerSession,
        protected ProductRepository $productRepository,
        array                       $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Function to find a product from repository with ID from session
     *
     * @return ProductInterface|mixed|null
     */
    public function getLastViewedProduct(): mixed
    {
        $productId = (int)$this->customerSession->getData('lastProduct');

        if ($productId) {
            try {
                return $this->productRepository->getById($productId);
            } catch (Exception) {
                return null;
            }
        }

        return null;
    }
    /**
     * Cache lifetime in seconds (e.g. 1 hour)
     *
     * @return int|null
     */
    public function getCacheLifetime(): ?int
    {
        return 3600;
    }

    /**
     * Unique cache key parts
     *
     * @return array
     */
    public function getCacheKeyInfo(): array
    {
        $productId = (int)$this->customerSession->getData('lastProduct');

        return [
            self::CACHE_TAG,
            'customer_id' => $this->customerSession->getCustomerId() ?? 'guest',
            'product_id' => $productId
        ];
    }

    /**
     * Cache tags used for automatic invalidation
     *
     * @return array
     */
    public function getCacheTags(): array
    {
        $productId = (int)$this->customerSession->getData('lastProduct');

        return [
            self::CACHE_TAG,
            $productId ? Product::CACHE_TAG . '_' . $productId : ''
        ];
    }
}
