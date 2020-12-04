<?php

namespace ML\DeveloperTest\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Country
 * @package ML\DeveloperTest\Model\ResourceModel
 * @author Kashif <kash@dreamsites.co.uk>
 */
class Country extends AbstractDb
{
    /**
     * Initialize resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init('developertest_countries', 'test_id');
    }

    /**
     * @param \ML\DeveloperTest\Model\Country $country
     * @return mixed
     */
    public function getTestId(\ML\DeveloperTest\Model\Country $country)
    {
        return $country->getTestId();
    }

    /**
     * @param \ML\DeveloperTest\Model\Country $country
     * @return mixed
     */
    public function getIso3Code(\ML\DeveloperTest\Model\Country $country)
    {
        return $country->getIso3Code();
    }

    /**
     * @param \ML\DeveloperTest\Model\Country $country
     * @return mixed
     */
    public function getCreatedAt(\ML\DeveloperTest\Model\Country $country)
    {
        return $country->getCreatedAt();
    }

    /**
     * @param \ML\DeveloperTest\Model\Country $country
     * @return mixed
     */
    public function getUpdatedAt(\ML\DeveloperTest\Model\Country $country)
    {
        return $country->getUpdatedAt();
    }
}
