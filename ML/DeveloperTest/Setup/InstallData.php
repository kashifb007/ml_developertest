<?php

namespace ML\DeveloperTest\Setup;

use ML\DeveloperTest\Model\CountryFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\App\ResourceConnection;

/**
 * Class InstallData
 * @package ML\DeveloperTest\Setup
 * @author Kashif <kash@dreamsites.co.uk>
 */
class InstallData implements InstallDataInterface
{

    /**
     * @var CountryFactory
     */
    protected $_countryFactory;

    /**
     * @var ResourceConnection
     */
    protected $_resourceConnection;

    /**
     * InstallData constructor.
     * @param CountryFactory $_countryFactory
     * @param ResourceConnection $_resourceConnection
     */
    public function __construct(CountryFactory $_countryFactory, ResourceConnection $_resourceConnection)
    {
        $this->_resourceConnection = $_resourceConnection;
        $this->_countryFactory = $_countryFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Exception
     */
    public function install(ModuleDataSetupInterface $setup,
                            ModuleContextInterface $context)
    {
        $connection = $this->_resourceConnection->getConnection();
        $table = $connection->getTableName('directory_country');

        $query = "SELECT iso3_code FROM " . $table;
        $data = $connection->fetchAll($query);

        foreach ($data as $item) {
            $countryData = [
                'iso3_code' => $item['iso3_code'],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];

            $country = $this->_countryFactory->create();
            $country->addData($countryData)->save();
        }
    }

}
