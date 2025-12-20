<?php

declare(strict_types=1);

namespace ProductSlider\Model;

use Magento\Catalog\Model\ResourceModel\Product\Collection;

interface ProductProviderInterface
{
    /**
     * Return collection of products based on category
     *
     * @param int $limit
     * @return Collection
     */
    public function getProducts(int $limit): Collection;
}
