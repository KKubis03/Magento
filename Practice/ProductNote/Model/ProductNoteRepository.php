<?php

namespace ProductNote\Model;

use ProductNote\Api\ProductNoteRepositoryInterface;
use ProductNote\Model\ResourceModel\ProductNote as Resource;
use Magento\Catalog\Api\ProductRepositoryInterface;

/**
 * Repository implementation for managing product notes.
 */
class ProductNoteRepository implements ProductNoteRepositoryInterface
{
    /**
     * @var Resource
     */
    private $resource;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @param Resource $resource
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        Resource $resource,
        ProductRepositoryInterface $productRepository
    ) {
        $this->resource = $resource;
        $this->productRepository = $productRepository;
    }

    /**
     * Ensure that the product with given SKU exists.
     *
     * @param string $sku
     */
    private function validateProductExists(string $sku): bool
    {
        if ($this->productRepository->get($sku)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Retrieve product note by SKU.
     *
     * @param string $sku
     * @return string
     */
    public function getBySku(string $sku): string
    {
        $note = $this->resource->getNoteBySku($sku);
        return $note;
    }

    /**
     * Create a new note for a product by SKU.
     *
     * @param string $sku
     * @param string $note
     * @return bool
     */
    public function create(string $sku, string $note): bool
    {
        return $this->resource->saveNote($sku, $note);
    }

    /**
     * Update an existing note for a product by SKU.
     *
     * @param string $sku
     * @param string $note
     * @return bool
     */
    public function update(string $sku, string $note): bool
    {
        return $this->resource->saveNote($sku, $note);
    }

    /**
     * Delete a product note by SKU.
     *
     * @param string $sku
     * @return bool
     */
    public function delete(string $sku): bool
    {
        return $this->resource->deleteNote($sku);
    }
}
