<?php

namespace MageDev\BrazilZipCode\Setup;

use MageDev\BrazilZipCode\Api\Data\ZipCodeInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema
 * @package MageDev\BrazilZipCode\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    const ZIPCODE_TABLE = 'magedev_brazil_zipcode';

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $setup->getConnection()->createTable(
            $this->createTable($setup)
        );

        $setup->endSetup();
    }

    private function createTable(SchemaSetupInterface $setup)
    {
        $table = $setup->getTable(self::ZIPCODE_TABLE);
        return $table = $setup->getConnection()
            ->newTable(self::ZIPCODE_TABLE)
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Entity ID'
            )
            ->addColumn(
                ZipCodeInterface::FIELD_ZIPCODE,
                Table::TYPE_TEXT,
                8,
                ['nullable' => false],
                'ZipCode'
            )
            ->addColumn(
                ZipCodeInterface::FIELD_STREET,
                Table::TYPE_TEXT,
                100,
                ['nullable' => true],
                'Street'
            )
            ->addColumn(
                ZipCodeInterface::FIELD_CITY,
                Table::TYPE_TEXT,
                100,
                ['nullable' => false],
                'City'
            )
            ->addColumn(
                ZipCodeInterface::FIELD_NEIGHBORHOOD,
                Table::TYPE_TEXT,
                100,
                ['nullable' => true],
                'Neighborhood'
            )
            ->addColumn(
                ZipCodeInterface::FIELD_REGION,
                Table::TYPE_TEXT,
                2,
                ['nullable' => false],
                'Region'
            )
            ->addColumn(
                ZipCodeInterface::FIELD_REGION_ID,
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false],
                'Region Id'
            )
            ->addColumn(
                ZipCodeInterface::FIELD_INFO,
                Table::TYPE_TEXT,
                150,
                ['nullable' => true],
                'Additional Information'
            )
            ->addColumn(
                ZipCodeInterface::FIELD_CODE,
                Table::TYPE_TEXT,
                20,
                ['nullable' => true],
                'IBGE Code'
            )
            ->addColumn(
                ZipCodeInterface::FIELD_DATASOURCE,
                Table::TYPE_TEXT,
                20,
                ['nullable' => false],
                'Data Source Information'
            )
            ->addColumn(
                ZipCodeInterface::FIELD_IS_VALID,
                Table::TYPE_BOOLEAN,
                null,
                ['nullable' => false],
                'Zip Code Validation Status'
            )
            ->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP .
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT]
            )
            ->addColumn(
                'updated_at',
                TAble::TYPE_TIMESTAMP,
                null,
                ['nullable' => true, 'default' => Table::TIMESTAMP_INIT_UPDATE]
            )
            ->addIndex(
                $setup->getIdxName(self::ZIPCODE_TABLE, [ZipCodeInterface::FIELD_ZIPCODE]),
                [ZipCodeInterface::FIELD_ZIPCODE]
            );
    }
}
