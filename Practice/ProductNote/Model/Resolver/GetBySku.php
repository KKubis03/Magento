<?php

declare(strict_types=1);

namespace ProductNote\Model\Resolver;

use \ProductNote\Api\ProductNoteRepositoryInterface;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class GetBySku implements ResolverInterface
{
    /**
     * GetBySku resolver constructor
     *
     * @param ProductNoteRepositoryInterface $repository
     */
    public function __construct(private ProductNoteRepositoryInterface $repository)
    {
    }

    /**
     * Resolve method from Resolver interface
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
        if (!isset($args['sku'])) {
            throw new LocalizedException(__('SKU is required'));
        }

        $note = $this->repository->getBySku($args['sku']);

        return [
            'sku'  => $args['sku'],
            'note' => $note
        ];
    }
}
