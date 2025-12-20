<?php

declare(strict_types=1);

namespace ProductNote\Setup\Patch\Schema;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\Patch\SchemaPatchInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Zend_Db_Exception;

/**
 * Schema patch to create the _product_note table.
 */
class CreateProductNoteTable implements SchemaPatchInterface
{
    /**
     * @var SchemaSetupInterface
     */
    private $schemaSetup;

    /**
     * Constructor.
     *
     * @param SchemaSetupInterface $schemaSetup
     */
    public function __construct(SchemaSetupInterface $schemaSetup)
    {
        $this->schemaSetup = $schemaSetup;
    }

    /**
     * Apply schema patch to create _product_note table.
     *
     * @return void
     * @throws Zend_Db_Exception
     */
    public function apply()
    {
        $setup = $this->schemaSetup;
        $setup->startSetup();

        if (!$setup->tableExists('_product_note')) {
            $table = $setup->getConnection()->newTable(
                $setup->getTable('_product_note')
            )->addColumn(
                'sku',
                Table::TYPE_TEXT,
                64,
                ['nullable' => false, 'primary' => true],
                'Product SKU'
            )->addColumn(
                'note',
                Table::TYPE_TEXT,
                null,
                ['nullable' => true],
                'Product Note'
            );
            $setup->getConnection()->createTable($table);
        }

        $setup->endSetup();
    }

    /**
     * Get patch dependencies.
     *
     * @return array
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * Get patch aliases.
     *
     * @return array
     */
    public function getAliases()
    {
        return [];
    }
}
