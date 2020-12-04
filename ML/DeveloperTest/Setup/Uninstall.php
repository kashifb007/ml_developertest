<?php

namespace ML\DeveloperTest\Setup;

use Magento\Framework\Setup\UninstallInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

/**
 * Class Uninstall
 * @package ML\DeveloperTest\Setup
 * @author Kashif <kash@dreamsites.co.uk>
 */
class Uninstall implements UninstallInterface
{
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $installer->getConnection()->dropTable($installer->getTable('developertest_countries'));

        $installer->endSetup();
    }
}
