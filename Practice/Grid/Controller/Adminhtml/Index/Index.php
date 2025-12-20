<?php

declare(strict_types=1);

namespace Grid\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Session;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Controller for rendering the Admin Grid page.
 *
 * Shows a one-time welcome message and prepares the result page.
 */

class Index extends Action implements HttpGetActionInterface
{
    /**
     * Index constructor
     *
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param Session $backendSession
     */
    public function __construct(
        Context $context,
        private readonly PageFactory $pageFactory,
        private readonly Session $backendSession
    ) {
        parent::__construct($context);
    }

    /**
     * Execute the controller action.
     *
     * Prepares and returns the admin grid result page.
     *
     * @return Page
     */
    public function execute(): Page
    {
        $this->showWelcomeMessageIfNeeded();
        return $this->createResultPage();
    }

    /**
     * Creates and configures the result page for the Admin Grid.
     *
     * Sets the active menu and the page title.
     *
     * @return Page Configured result page
     */
    private function createResultPage(): Page
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->pageFactory->create();
        $resultPage->setActiveMenu('Magento_Catalog::catalog_products');
        $resultPage->getConfig()->getTitle()->prepend(__('Admin Grid'));

        return $resultPage;
    }

    /**
     * Displays a one-time welcome message in the admin session.
     *
     * Adds a success message if it has not been shown yet
     * and sets a session flag to prevent repetition.
     *
     * @return void
     */
    private function showWelcomeMessageIfNeeded(): void
    {
        if (!($this->backendSession->getData('welcome_message_shown') ?? false)) {
            $this->messageManager->addSuccessMessage(__('Welcome to Admin Grid!'));
            $this->backendSession->setData('welcome_message_shown', true);
        }
    }
}
