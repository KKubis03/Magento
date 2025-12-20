<?php

declare(strict_types=1);

namespace PreferencesExamples\Controller\Index;

use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Cms\Controller\Index\Index
{
    public function execute($coreRoute = null)
    {
        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $result->setContents('Hello from frontend preference!');
        return $result;
    }
}
