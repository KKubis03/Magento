<?php

declare(strict_types=1);

namespace ProductNote\Plugin;

use \ProductNote\Model\ResourceModel\ProductNote;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;

/**
 * Plugin to add a custom manufacturer note to product data after loading a product.
 */
class AddNoteToProduct
{
    /**
     * @param ProductNote $noteResource
     */
    public function __construct(protected ProductNote $noteResource)
    {
    }

    /**
     * Add manufacturer note as a custom attribute to the product after it is retrieved.
     *
     * @param ProductRepositoryInterface $subject
     * @param ProductInterface $product
     * @return ProductInterface
     */
    public function afterGet(
        ProductRepositoryInterface $subject,
        ProductInterface $product
    ): ProductInterface {
        $note = $this->noteResource->getNoteBySku($product->getSku());
        if ($note !== null) {
            $product->setCustomAttribute('manufacturer_note', $note);
        }
        return $product;
    }
}
