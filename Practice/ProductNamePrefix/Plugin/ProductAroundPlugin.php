<?php

declare(strict_types=1);

namespace ProductNamePrefix\Plugin;

use Magento\Catalog\Model\Product;

class ProductAroundPlugin
{
    /**
     * Adds prefix around setName method
     *
     * @param Product $subject
     * @param callable $proceed
     * @return string
     */
    public function aroundGetName(Product $subject, callable $proceed): string
    {
        $result = $proceed();
        return '[Around] ' . $result . ' [Around]';
    }
}
