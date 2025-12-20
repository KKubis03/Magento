<?php

declare(strict_types=1);

namespace PreferencesExamples\Model\ResourceModel\Product;

class Collection extends \Magento\Catalog\Model\ResourceModel\Product\Collection
{
    /**
     * Filter only active products
     *
     * @return $this|Collection
     */
    protected function _initSelect(): Collection|static
    {
        parent::_initSelect();
        $this->addAttributeToFilter('status', 1);
        return $this;
    }
}
