<?php

declare(strict_types=1);

namespace PreferencesExamples\Helper;

use Magento\Framework\Pricing\Helper\Data as CorePriceHelper;

class Price extends CorePriceHelper
{
    /**
     * Override currency method
     *
     * @param $amount
     * @param $includeContainer
     * @param $precision
     * @return string
     */
    public function currency($amount, $includeContainer = true, $precision = 2): string
    {
        $formatted = parent::currency($amount, $includeContainer, $precision);
        return $formatted . ' PLN (custom)';
    }
}
