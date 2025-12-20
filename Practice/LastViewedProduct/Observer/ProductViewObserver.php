<?php

declare(strict_types=1);

namespace \LastViewedProduct\Observer;

use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Observer to save last viewed product ID into customer session
 */
class ProductViewObserver implements ObserverInterface
{
    /**
     * ProductViewObserver Constructor
     *
     * @param CustomerSession $customerSession
     */
    public function __construct(
        protected CustomerSession $customerSession,
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
        $productId = $observer->getEvent()?->getProduct()?->getId();
        $productId && $this->customerSession->setData('lastProduct', $productId);
    }
}
