<?php

namespace TaskMigrations\Setup\Patch\Data;

use DateTime;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddExampleData implements DataPatchInterface
{
    /**
     * Constructor
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        private readonly ModuleDataSetupInterface $moduleDataSetup
    ) {
    }

    /**
     * Function inserts sample data to _example table
     *
     * @return $this|AddExampleData
     */
    public function apply(): AddExampleData|static
    {
        $this->moduleDataSetup->startSetup();

        $data = [];
        for ($i = 1; $i <= 5; $i++) {
            $data[] = [
                'name' => 'Example name ' . $i,
                'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
            ];
        }

        $this->moduleDataSetup->getConnection()->insertMultiple(
            $this->moduleDataSetup->getTable('example'),
            $data
        );

        $this->moduleDataSetup->endSetup();

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
