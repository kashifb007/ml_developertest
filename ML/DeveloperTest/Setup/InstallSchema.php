<?php

namespace ML\DeveloperTest\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;

/**
 * Class InstallSchema
 * @package ML\DeveloperTest\Setup
 * @author Kashif <kash@dreamsites.co.uk>
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {

        $installer = $setup;
        $installer->startSetup();
        /**
         * Create table 'developertest_countries'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('developertest_countries')
        )->addColumn(
            'test_id',
            Table::TYPE_INTEGER,
            null,
            [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ],
            'Primary ID'
        )->addColumn(
            'iso3_code',
            Table::TYPE_TEXT,
            3,
            ['nullable' => false],
            'country ID'
        )->addColumn(
            'is_allowed',
            Table::TYPE_BOOLEAN,
            1,
            ['nullable' => false, 'default' => true],
            'Allowed to order'
        )->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false],
            'Creation Time'
        )->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => true],
            'Modification Time'
        )->setComment(
            'Media Lounge Enabled Countries'
        );
        $installer->getConnection()->createTable($table);
        $installer->endSetup();
    }

}
