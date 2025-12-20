<?php

declare(strict_types=1);

namespace ProductNamePrefix\Plugin;

use Magento\Catalog\Model\Product;

class ProductAfterPlugin
{
    /**
     * Adds prefix after setName method
     *
     * @param Product $subject
     * @param string $result
     * @return string
     */
    public function afterGetName(Product $subject, string $result): string
    {
        return $result . ' [Modified After]';
    }
}
