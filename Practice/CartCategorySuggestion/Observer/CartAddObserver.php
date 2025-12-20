<?php

declare(strict_types=1);

namespace CartCategorySuggestion\Observer;

use Magento\Catalog\Model\CategoryRepository;
use Magento\Catalog\Model\Product;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface;

/**
 * Observer that listens to the product add-to-cart event.
 *
 * If the added product is on sale,
 * a success message is displayed to inform the customer about the promotion.
 */
class CartAddObserver implements ObserverInterface
{
    /**
     * Constructor
     *
     * @param CategoryRepository $categoryRepository
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        protected CategoryRepository $categoryRepository,
        protected ManagerInterface $messageManager
    ) {
    }

    /**
     * ObserverInterface execute method
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        $product = $observer->getEvent()?->getProduct();

        if (!$product instanceof Product) {
            return;
        }

        if ($this->isOnSale($product)) {
            $productName = $product->getName() ?: __('Unnamed product');

            $this->messageManager->addSuccessMessage(
                __(
                    'The promotional product "%1" has been added to your cart! Check out other deals.',
                    $productName
                )
            );
        }
    }

    /**
     * Check if product is on sale
     *
     * @param Product $product
     * @return bool
     */
    private function isOnSale(Product $product): bool
    {
        $price = $product->getPrice() ?? 0;
        $specialPrice = $product->getSpecialPrice() ?? 0;
        return $specialPrice > 0 && $specialPrice < $price;
    }
}
