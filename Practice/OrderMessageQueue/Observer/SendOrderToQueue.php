<?php

declare(strict_types=1);

namespace OrderMessageQueue\Observer;

use OrderMessageQueue\Model\OrderExportPublisher;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

class SendOrderToQueue implements ObserverInterface
{
    /**
     * Observer constructor
     *
     * @param OrderExportPublisher $publisher
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly OrderExportPublisher $publisher,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * Observer interface execute method
     *
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer): void
    {
        $order = $observer->getEvent()->getOrder();
        $orderId = $order->getIncrementId();

        if ($orderId === null) {
            $this->logger->error('Cannot publish order.export: order ID is null');
            return;
        }

        $this->publisher->publish((string)$orderId);
    }
}
