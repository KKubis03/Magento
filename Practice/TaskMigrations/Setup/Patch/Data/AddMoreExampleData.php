<?php

namespace TaskMigrations\Setup\Patch\Data;

use DateTime;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddMoreExampleData implements DataPatchInterface
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
     * Function to insert data to updated _example table
     *
     * @return $this|AddMoreExampleData
     */
    public function apply(): AddMoreExampleData|static
    {
        $this->moduleDataSetup->startSetup();

        $data = [];
        $date = new DateTime();
        for ($i = 1; $i <= 5; $i++) {
            $data[] = [
                'name' => 'Example name ' . $i,
                'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
                'description' => $i . 'Description' . ($i + 1)
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
