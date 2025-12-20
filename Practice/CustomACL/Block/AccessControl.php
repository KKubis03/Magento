<?php

declare(strict_types=1);

namespace CustomACL\Block;

use Magento\Framework\Escaper;
use Magento\Framework\View\Element\Template;

class AccessControl extends Template
{
    private const TITLE = 'This is page with access control list (ACL)';
    private const ACL_CODE = 'CustomACL::example';
    /**
     * Constructor
     *
     * @param Template\Context $context
     * @param Escaper $escaper
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        protected readonly Escaper $escaper,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Returns the page title, safely escaped for HTML output.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->escaper->escapeHtml(self::TITLE);
    }

    /**
     * Function to get ACL code
     *
     * @return string
     */
    public function getAclCode(): string
    {
        return $this->escaper->escapeHtml(self::ACL_CODE);
    }
}
