<?php

declare(strict_types=1);

namespace OrderMessageQueue\Model;

use Magento\Framework\MessageQueue\PublisherInterface;

class OrderExportPublisher
{
    /**
     * Class constructor
     *
     * @param PublisherInterface $publisher
     */
    public function __construct(private readonly PublisherInterface $publisher)
    {
    }

    /**
     * Method to publish order ID as message
     *
     * @param string $orderId
     * @return void
     */
    public function publish(string $orderId): void
    {
        $this->publisher->publish('order.export', $orderId);
    }
}
