<?php

namespace ProductNote\Api;

/**
 * Interface for managing product notes by SKU.
 *
 * Provides methods to get, create, update, and delete notes associated with products.
 */
interface ProductNoteRepositoryInterface
{
    /**
     * Retrieve product note by product SKU.
     *
     * @param string $sku
     * @return string
     */
    public function getBySku(string $sku): string;

    /**
     * Create a new note for a product by SKU.
     *
     * @param string $sku
     * @param string $note
     * @return bool
     */
    public function create(string $sku, string $note): bool;

    /**
     * Update the note for a product by SKU.
     *
     * @param string $sku
     * @param string $note
     * @return bool
     */
    public function update(string $sku, string $note): bool;

    /**
     * Delete the note for a product by SKU.
     *
     * @param string $sku
     * @return bool
     */
    public function delete(string $sku): bool;
}
