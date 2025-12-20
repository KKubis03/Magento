<?php

declare(strict_types=1);

namespace \LogCleaner\Cron;

use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem\Driver\File as FileDriver;
use Psr\Log\LoggerInterface;

/**
 * Class ClearSystemLog
 *
 * Cron job to clear the system.log file once a week.
 */
class ClearSystemLog
{
    /**
     * Path to the system log file
     *
     * @var string
     */
    private string $logFile = BP . '/var/log/system.log';

    /**
     * ClearSystemLog constructor.
     *
     * @param FileDriver $fileDriver
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly FileDriver      $fileDriver,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * Executes the cron job.
     *
     * Clears the content of the system.log file if it exists.
     *
     * @return void
     * @throws FileSystemException
     */
    public function execute(): void
    {
        if ($this->fileDriver->isExists($this->logFile)) {
            $this->fileDriver->filePutContents($this->logFile, '');
            $this->logger->info('System.log file was cleared by ClearSystemLog cron job.');
        } else {
            $this->logger->warning('System.log file does not exist; nothing to clear.');
        }
    }
}
