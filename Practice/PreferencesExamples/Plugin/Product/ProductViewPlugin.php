<?php

declare(strict_types=1);

namespace PreferencesExamples\Plugin\Product;

use Magento\Catalog\Block\Product\View;
use Magento\Catalog\Model\Product;

class ProductViewPlugin
{
    /**
     * AfterGetProduct – plugin type "after"
     *
     * @param View $subject
     * @param Product $result
     * @return Product
     */
    public function afterGetProduct(
        View $subject,
        $result
    ): Product {
        $result->setName($result->getName() . ' (CUSTOM)');
        return $result;
    }
}
