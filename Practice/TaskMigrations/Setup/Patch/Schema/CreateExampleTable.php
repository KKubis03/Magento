<?php

namespace \TaskMigrations\Setup\Patch\Schema;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\Patch\SchemaPatchInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Zend_Db_Exception;

class CreateExampleTable implements SchemaPatchInterface
{
    /**
     * Constructor
     *
     * @param SchemaSetupInterface $schemaSetup
     */
    public function __construct(private readonly SchemaSetupInterface $schemaSetup)
    {
    }

    /**
     * Function to apply changes in the database
     *
     * @return $this|CreateExampleTable
     * @throws Zend_Db_Exception
     */
    public function apply(): CreateExampleTable|static
    {
        $setup = $this->schemaSetup;
        $setup->startSetup();

        if (!$setup->tableExists('_example')) {
            $table = $setup->getConnection()->newTable(
                $setup->getTable('_example')
            )->addColumn(
                'example_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Example ID'
            )->addColumn(
                'name',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Name'
            )->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                'Created At'
            )->setComment('Example Table');
            $setup->getConnection()->createTable($table);
        }

        $setup->endSetup();
        return $this;
    }

    /**
     * Empty interface method
     *
     * @return array|string[]
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * Empty interface method
     *
     * @return array|string[]
     */
    public function getAliases(): array
    {
        return [];
    }
}
