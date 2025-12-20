<?php

declare(strict_types=1);

namespace OrderMessageQueue\Model;

use Psr\Log\LoggerInterface;

class OrderExportConsumer
{
    /**
     * Consumer constructor
     *
     * @param LoggerInterface $logger
     */
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    /**
     * Logging orderId from queue
     *
     * @param string  $orderId
     * @return string
     */
    public function process(string $orderId): string
    {
        $this->logger->info("Received from message queue ID: " . $orderId);
        return "";
    }
}
