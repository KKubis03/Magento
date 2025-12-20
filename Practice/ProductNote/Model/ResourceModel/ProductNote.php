<?php

namespace ProductNote\Model\ResourceModel;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\App\ResourceConnection;

/**
 * Resource model for product notes.
 */
class ProductNote extends AbstractDb
{
    /**
     * @var AdapterInterface
     */
    protected $connection;

    /**
     * ProductNote constructor.
     *
     * @param ResourceConnection $resource
     */
    public function __construct(ResourceConnection $resource)
    {
        $this->connection = $resource->getConnection();
    }

    /**
     * Initialize resource model.
     *
     * Table: _product_note
     * Primary key: sku
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init('_product_note', 'sku');
    }

    /**
     * Retrieve note for a product by SKU.
     *
     * @param string $sku
     * @return string|null
     */
    public function getNoteBySku($sku): ?string
    {
        $select = $this->connection->select()
            ->from('_product_note', ['note'])
            ->where('sku = ?', $sku);
        return $this->connection->fetchOne($select);
    }

    /**
     * Save or update note for a product by SKU.
     *
     * @param string $sku
     * @param string $note
     * @return bool
     */
    public function saveNote(string $sku, string $note): bool
    {
        $this->connection->insertOnDuplicate(
            '_product_note',
            ['sku' => $sku, 'note' => $note]
        );
        return true;
    }

    /**
     * Delete note for a product by SKU.
     *
     * @param string $sku
     * @return bool
     */
    public function deleteNote(string $sku): bool
    {
        $this->connection->delete(
            '_product_note',
            ['sku = ?' => $sku]
        );
        return true;
    }
}
