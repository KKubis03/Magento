<?php

declare(strict_types=1);

namespace ProductNamePrefix\Plugin;

use Magento\Catalog\Model\Product;

class ProductBeforePlugin
{
    /**
     * Adds prefix before setName method
     *
     * @param Product $subject
     * @param string $name
     * @return array
     */
    public function beforeSetName(Product $subject, string $name): array
    {
        return ['modified before' . $name];
    }
}
