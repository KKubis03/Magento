<?php

namespace \TaskMigrations\Setup\Patch\Schema;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\Patch\SchemaPatchInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpdateExampleTable implements SchemaPatchInterface
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
     * Interface method to apply db changes
     *
     * @return $this|UpdateExampleTable
     */
    public function apply(): UpdateExampleTable|static
    {
        $setup = $this->schemaSetup;
        $setup->startSetup();

        $connection = $setup->getConnection();
        $tableName = $setup->getTable('example');

        if ($connection->isTableExists($tableName)) {
            if (!$connection->tableColumnExists($tableName, 'description')) {
                $connection->addColumn(
                    $tableName,
                    'description',
                    [
                        'type' => Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'Description'
                    ]
                );
            }

            $indexName = $setup->getIdxName($tableName, ['description']);
            $connection->addIndex(
                $tableName,
                $indexName,
                ['description']
            );

            $connection->changeColumn(
                $tableName,
                'name',
                'name',
                [
                    'type' => Table::TYPE_TEXT,
                    'length' => 500,
                    'nullable' => false,
                    'comment' => 'Name (updated)'
                ]
            );
        }

        $setup->endSetup();

        return $this;
    }

    /**
     * Empty interface method
     *
     * @return class-string[]
     */
    public static function getDependencies(): array
    {
        return [
            CreateExampleTable::class
        ];
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
