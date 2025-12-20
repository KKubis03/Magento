<?php

namespace LoggerDemo\Logger;

use Magento\Customer\Model\Session as CustomerSession;
use Monolog\Logger as MonologLogger;

/**
 * Logged in customer data logger
 */
class Logger extends MonologLogger
{
    /**
     * Constructor
     *
     * @param string $name Name of the logger
     * @param CustomerSession $customerSession Customer session
     * @param array $handlers Handlers
     */
    public function __construct(
        string $name,
        protected CustomerSession $customerSession,
        array $handlers = []
    ) {
        parent::__construct($name, $handlers);
    }

    /**
     * Function to get customer data from session and write data to file
     *
     * @return void
     */
    public function logCustomerData(): void
    {
        if ($this->customerSession->isLoggedIn()) {
            $customer = $this->customerSession->getCustomer();
            $data = $customer->getData();
            $this->info('Logged in customer data: ' . json_encode($data));
        } else {
            $this->info('No customer logged in.');
        }
    }
}
