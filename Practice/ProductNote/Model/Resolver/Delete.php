<?php

declare(strict_types=1);

namespace ProductNote\Model\Resolver;

use \ProductNote\Api\ProductNoteRepositoryInterface;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\Exception\LocalizedException;

class Delete implements ResolverInterface
{
    /**
     * Delete resolver constructor
     *
     * @param ProductNoteRepositoryInterface $repository
     */
    public function __construct(private ProductNoteRepositoryInterface $repository)
    {
    }

    /**
     * Resolver interface resolve method
     *
     * @param $field
     * @param $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return bool|Value|mixed
     * @throws LocalizedException
     */
    public function resolve(
        $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        if (empty($args['sku'])) {
            throw new LocalizedException(__('SKU is required'));
        }

        return $this->repository->delete($args['sku']);
    }
}
