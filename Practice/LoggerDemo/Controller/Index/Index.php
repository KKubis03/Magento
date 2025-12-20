<?php

declare(strict_types=1);

namespace LoggerDemo\Controller\Index;

use LoggerDemo\Logger\Logger;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

/**
 * Index controller for logger
 */
class Index extends Action
{
    /**
     * Constructor
     *
     * @param Context $context
     * @param Logger $logger
     * @param CustomerSession $customerSession
     */
    public function __construct(
        Context $context,
        private readonly Logger $logger,
        private readonly CustomerSession $customerSession,
    ) {
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return void
     */
    public function execute(): void
    {
        if ($this->customerSession->isLoggedIn()) {
            $customer = $this->customerSession->getCustomer();
            $data = $customer?->getData() ?? [];
            $this->logger->info('Logged in customer data: ' . json_encode($data));
        } else {
            $this->logger->info('No customer logged in.');
        }

        $this->getResponse()->setBody('Log saved! Check file var/log/demo.log');
    }
}
