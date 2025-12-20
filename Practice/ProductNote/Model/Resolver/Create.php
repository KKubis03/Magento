<?php

declare(strict_types=1);

namespace ProductNote\Model\Resolver;

use \ProductNote\Api\ProductNoteRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class Create implements ResolverInterface
{
    /**
     * Create resolver constructor
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
     * @return array
     * @throws LocalizedException
     */
    public function resolve(
        $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        if (empty($args['sku']) || empty($args['note'])) {
            throw new LocalizedException(__('SKU and Note are required'));
        }

        $this->repository->create($args['sku'], $args['note']);

        return [
            'sku'  => $args['sku'],
            'note' => $args['note']
        ];
    }
}
