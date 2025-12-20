<?php

declare(strict_types=1);

namespace ProductInfoGraphql\Model\Resolver;

use Exception;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

/**
 * Resolver class for graphql schema
 */
class ProductInfo implements ResolverInterface
{
    /**
     * Resolver constructor
     *
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(private readonly ProductRepositoryInterface $productRepository)
    {
    }

    /**
     * Resolver interface resolve method
     *
     * @param Field $field
     * @param $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array
     * @throws GraphQlNoSuchEntityException
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        ?array $value = null,
        ?array $args = null
    ) {
        if (!isset($args['sku'])) {
            throw new GraphQlNoSuchEntityException(__('SKU is required'));
        }

        try {
            $product = $this->productRepository->get($args['sku']);
        } catch (Exception $e) {
            throw new GraphQlNoSuchEntityException(
                __("Product with SKU %1 not found", $args['sku'])
            );
        }

        return [
            'name'   => $product->getName(),
            'price'  => (float)$product->getPrice(),
            'status' => (int)$product->getStatus()
        ];
    }
}
