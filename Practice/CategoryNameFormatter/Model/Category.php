<?php

declare(strict_types=1);

namespace CategoryNameFormatter\Model;

use Magento\Catalog\Model\Category as MagentoCategory;
use Magento\Framework\Phrase;

/**
 * Class Category
 *
 * Overrides Magento\Catalog\Model\Category::getName()
 * to prepend a custom label to the category name.
 *
 */
class Category extends MagentoCategory
{
    /**
     * Get formatted category name.
     *
     * Adds a custom prefix Category: before the original category name.
     *
     * @return Phrase
     */
    public function getName() : Phrase
    {
        $original = parent::getName();
        return __('Category: %1', $original);
    }
}
