<?php

declare(strict_types=1);

namespace \GridExtension\Controller\Adminhtml\Product;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Ui\Component\MassAction\Filter;

/**
 * Class MassCustom
 *
 * Controller for handling custom mass actions on product grid in admin panel.
 */
class MassCustom extends Action
{
    /**
     * MassCustom constructor.
     *
     * @param Action\Context $context Context object for backend actions
     * @param Filter $filter UI filter component used for mass actions
     */
    public function __construct(
        Action\Context $context,
        protected Filter $filter
    ) {
        parent::__construct($context);
    }

    /**
     * Execute custom mass action:
     * - Get selected product IDs from request
     * - Show success message with count
     * - Redirect back to product grid
     *
     * @return ResponseInterface|ResultInterface
     */
    public function execute(): ResultInterface|ResponseInterface
    {
        $ids = $this->getRequest()->getParam('selected', []);
        $count = count($ids);

        $this->messageManager->addSuccessMessage(__(
            "%1 products selected to custom mass action.",
            $count
        ));

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)
            ->setPath('catalog/product/index');
    }

    /**
     * Check ACL permissions for current admin user.
     *
     * @return bool
     */
    protected function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed('_GridExtension::mass_custom');
    }
}
