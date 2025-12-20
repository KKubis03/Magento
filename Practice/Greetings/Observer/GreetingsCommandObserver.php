<?php

declare(strict_types=1);

namespace \Greetings\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

/**
 * Observer that logs the "name" passed via the custom console command event.
 */
class GreetingsCommandObserver implements ObserverInterface
{
    /**
     * Constructor
     *
     * @param LoggerInterface $logger
     */
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    /**
     * Executes the observer: logs the provided name from event.
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        $name = $observer->getData('name');

        $name ? $this->logName($name)
            : $this->logger->warning('GreetingsCommandObserver: name is empty or invalid.');
    }

    /**
     * Logs the name to system.log with timestamp.
     *
     * @param string $name
     * @return void
     */
    private function logName(string $name): void
    {
        $message = sprintf('[%s] Name: %s', date('Y-m-d H:i:s'), $name);
        $this->logger->info($message);
    }
}
