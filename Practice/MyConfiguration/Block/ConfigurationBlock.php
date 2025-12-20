<?php

declare(strict_types=1);

namespace MyConfiguration\Block;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\ScopeInterface;

class ConfigurationBlock extends Template
{
    private const XML_PATH_CUSTOM_FIELD = 'custom_section/custom_group/custom_field';

    /**
     * ConfigurationBlock Constructor
     *
     * @param Context $context
     * @param ScopeConfigInterface $scopeConfig
     * @param array $data
     */
    public function __construct(
        Context $context,
        protected ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Function to get value from custom field configuration
     *
     * @return mixed
     */
    public function getCustomField(): mixed
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_CUSTOM_FIELD,
            ScopeInterface::SCOPE_STORE
        );
    }
}
