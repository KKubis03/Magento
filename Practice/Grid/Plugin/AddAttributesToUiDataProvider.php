<?php

declare(strict_types=1);

namespace \Grid\Plugin;

use \Grid\Ui\DataProvider\Category\ListingDataProvider as CategoryDataProvider;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Eav\Api\Data\AttributeInterface;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

/**
 * Plugin to modify category grid data provider by joining EAV attribute
 * and filtering categories starting with 'B'.
 */
class AddAttributesToUiDataProvider
{
    /**
     * Constructor
     *
     * @param AttributeRepositoryInterface $attributeRepository
     * @param ProductMetadataInterface $productMetadata
     */
    public function __construct(
        private readonly AttributeRepositoryInterface $attributeRepository,
        private readonly ProductMetadataInterface $productMetadata
    ) {
    }

    /**
     * Modify the category listing SearchResult after it is retrieved.
     *
     * @param CategoryDataProvider $subject
     * @param SearchResult $result
     * @return SearchResult
     * @throws NoSuchEntityException
     * @used-by Magento
     */
    public function afterGetSearchResult(CategoryDataProvider $subject, SearchResult $result): SearchResult
    {
        if ($result->isLoaded()) {
            return $result;
        }

        $column = $this->getEntityColumn();
        $attribute = $this->attributeRepository->get('catalog_category', 'name');

        $this->joinCategoryName($result, $attribute, $column);
        $this->applyNameFilter($result);

        return $result;
    }

    /**
     * Determines the correct entity column depending on edition.
     */
    private function getEntityColumn(): string
    {
        return $this->productMetadata->getEdition() === 'Enterprise' ? 'row_id' : 'entity_id';
    }
    /**
     * Join category name table to the search result.
     *
     * @param SearchResult $result
     * @param AttributeInterface $attribute
     * @param string $column
     * @return void
     */
    private function joinCategoryName(SearchResult $result, AttributeInterface $attribute, string $column): void
    {
        $backendTable = $attribute->getBackendTable();
        $attributeId = (int) $attribute->getAttributeId();

        $result->getSelect()->joinLeft(
            ['category_name_join' => $backendTable],
            sprintf(
                'category_name_join.%1$s = main_table.%1$s AND category_name_join.attribute_id = %2$d',
                $column,
                $attributeId
            ),
            ['name' => 'category_name_join.value']
        );
    }

    /**
     * Apply a LIKE filter on category name with bind parameter for safety.
     *
     * @param SearchResult $result
     * @return void
     */
    private function applyNameFilter(SearchResult $result): void
    {
        $result->getSelect()->where(
            'category_name_join.value LIKE "B%"',
        );
    }
}
