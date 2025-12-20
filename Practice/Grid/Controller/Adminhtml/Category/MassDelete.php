<?php

namespace Grid\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Api\Data\CategoryInterface;
use Magento\Catalog\Model\ResourceModel\Category\Collection;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Ui\Component\MassAction\Filter;

/**
 * Controller to handle mass deletion of product categories in custom admin panel.
 */
class MassDelete extends Action implements HttpPostActionInterface
{
    /**
     * Authorization resource for this action.
     */
    public const ADMIN_RESOURCE = 'Magento_Catalog::categories';

    /**
     * Backend URL path used to redirect back to the Grid index page
     * after completing the mass delete operation.
     */
    private const REDIRECT_PATH = '_grid/index/index';

    /**
     * Constructor
     *
     * @param Context $context Backend context
     * @param Filter $filter Filter for mass action
     * @param CollectionFactory $collectionFactory Factory for category collections
     * @param CategoryRepositoryInterface $categoryRepository Repository to handle category entities
     */
    public function __construct(
        Context $context,
        protected readonly Filter $filter,
        protected readonly CollectionFactory $collectionFactory,
        protected readonly CategoryRepositoryInterface $categoryRepository
    ) {
        parent::__construct($context);
    }

    /**
     * Executes mass delete for selected categories.
     *
     * Validates POST request, retrieves selected categories via mass action filter,
     * deletes each category using CategoryRepositoryInterface, and displays
     * a success message.
     *
     * @return Redirect
     * @throws LocalizedException
     */
    public function execute(): Redirect
    {
        /** @var Http $request */
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return $this->forwardNoRoute();
        }

        $collection = $this->filter->getCollection($this->collectionFactory->create());

        /** @var Collection $collection */
        $deletedCount = $this->deleteCategories($collection);
        $this->addDeleteResultMessage($deletedCount);

        return $this->createRedirectResult();
    }

    /**
     * Forward to Magento's "no route" page.
     */
    private function forwardNoRoute(): Redirect
    {
        return $this->resultFactory
            ->create(ResultFactory::TYPE_FORWARD)
            ->forward('noroute');
    }

    /**
     * Delete all categories in the collection and return count of deleted records.
     *
     * @param Collection $collection
     * @return int
     * @throws InputException
     * @throws NoSuchEntityException
     * @throws StateException
     */
    private function deleteCategories(Collection $collection): int
    {
        $deletedCount = 0;

        /** @var CategoryInterface $category */
        foreach ($collection->getItems() as $category) {
            $this->categoryRepository->delete($category);
            $deletedCount++;
        }

        return $deletedCount;
    }

    /**
     * Add a success or notice message depending on deleted count.
     *
     * @param int $deletedCount
     * @return void
     */
    private function addDeleteResultMessage(int $deletedCount): void
    {
        if ($deletedCount > 0) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been deleted.', $deletedCount)
            );
        } else {
            $this->messageManager->addNoticeMessage(__('No categories were deleted.'));
        }
    }

    /**
     * Create redirect result back to grid.
     */
    private function createRedirectResult(): Redirect
    {
        return $this->resultFactory
            ->create(ResultFactory::TYPE_REDIRECT)
            ->setPath(self::REDIRECT_PATH);
    }
}
