<?php

declare(strict_types=1);

namespace PreferencesExamples\Block;

use Magento\Catalog\Block\Product\View;
use Magento\Catalog\Model\Product;

class CustomView extends View
{
    /**
     * Adding custom text to product price
     *
     * @param Product $product
     * @return string
     */
    public function getProductPrice(Product $product): string
    {
        return parent::getProduct()->getFinalPrice() . ' PLN (via preference)';
    }
}
