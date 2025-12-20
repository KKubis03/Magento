<?php

declare(strict_types=1);

namespace ProductSlider\Block\Widget;

use \ProductSlider\Model\ProductProvider\CategoryProductProviderFactory;
use Magento\Catalog\Helper\Image;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Pricing\Helper\Data as PriceHelper;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class Slider extends Template implements BlockInterface
{
    /** @var string */
    protected $_template = 'widget/slider.phtml';

    /**
     * Slider constructor
     *
     * @param Template\Context $context
     * @param CategoryProductProviderFactory $categoryProductProviderFactory
     * @param Image $imageHelper
     * @param PriceHelper $priceHelper
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        private readonly CategoryProductProviderFactory $categoryProductProviderFactory,
        private readonly Image $imageHelper,
        private readonly PriceHelper $priceHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Function to get block title
     *
     * @return string|null
     */
    public function getTitle(): ?string
    {
        $title = (string)($this->getData('title') ?? '');
        return $title !== '' ? $title : null;
    }

    /**
     * Returns collection of products based on category and limit
     *
     * @return Collection
     * @throws NoSuchEntityException
     */
    public function getProducts(): Collection
    {
        $categoryId = (int)($this->getData('category_id') ?? 0);
        $limit = (int)($this->getData('product_count') ?? 5);
        if ($limit <= 0) {
            $limit = 5;
        }

        $provider = $this->categoryProductProviderFactory->create(['categoryId' => $categoryId]);

        return $provider->getProducts($limit);
    }

    /**
     * Generates image url
     *
     * @param Product $product
     * @return string
     */
    public function getImageUrl(Product $product): string
    {
        return $this->imageHelper->init($product, 'product_small_image')->getUrl();
    }

    /**
     * Formatting price
     *
     * @param float $price
     * @return string
     */
    public function formatPrice(float $price): string
    {
        return $this->priceHelper->currency($price, true, false);
    }
}
