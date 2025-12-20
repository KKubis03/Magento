<?php

namespace \Grid\Ui\Component\Category\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Actions extends Column
{
    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $_urlBuilder
     * @param string $_viewUrl
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        protected UrlInterface $_urlBuilder,
        protected $_viewUrl = '',
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare data source for category actions column.
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        $columnName = (string) $this->getData('name');
        if ($columnName === '' || !isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as $index => $item) {
            if (!isset($item['entity_id'])) {
                continue;
            }

            $dataSource['data']['items'][$index][$columnName]['edit'] = $this->prepareEditLink($item['entity_id']);
        }

        return $dataSource;
    }

    /**
     * Prepare the edit link for a category.
     *
     * @param int $categoryId
     * @return array
     */
    private function prepareEditLink(int $categoryId): array
    {
        return [
            'href' => $this->_urlBuilder->getUrl('catalog/category/edit', ['id' => $categoryId]),
            'label' => __('Edit'),
            'hidden' => false,
        ];
    }
}
