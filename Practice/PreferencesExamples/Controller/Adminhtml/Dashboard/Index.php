<?php

declare(strict_types=1);

namespace PreferencesExamples\Controller\Adminhtml\Dashboard;

use Magento\Backend\Model\View\Result\Page;

class Index extends Magento\Backend\Controller\Adminhtml\Dashboard\Index
{
    /**
     * Custom dashboard notice
     *
     * @return Page
     */
    public function execute(): Page
    {
        $this->messageManager->addNoticeMessage(__('Dashboard overridden by preference!'));
        return parent::execute();
    }
}
