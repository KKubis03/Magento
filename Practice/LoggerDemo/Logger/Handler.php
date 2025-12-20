<?php

declare(strict_types=1);

namespace LoggerDemo\Logger;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

class Handler extends Base
{
    /**
     * Name of the output logs
     *
     * @var string
     */
    protected $fileName = '/var/log/demo.log';
    /**
     * Type of logger
     *
     * @var Logger
     */
    protected $loggerType = Logger::DEBUG;
}
