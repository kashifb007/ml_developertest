<?php

namespace ML\DeveloperTest\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class Country
 * @package ML\DeveloperTest\Model
 * @author Kashif <kash@dreamsites.co.uk>
 */
class Country extends AbstractModel
{
    /**
     * Initialize resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init('ML\DeveloperTest\Model\ResourceModel\Country');
        parent::_construct();
    }

    /**
     * @return mixed
     */
    public function getTestId()
    {
        return $this->getData('test_id');
    }

    /**
     * @return mixed
     */
    public function getIso3Code()
    {
        return $this->getData('iso3_code');
    }

    /**
     * @param $iso3_code
     * @return Country
     */
    public function setIso3Code($iso3_code)
    {
        $this->setData('updated_at', date("Y-m-d H:i:s"));
        return $this->setData('iso3_code', $iso3_code);
    }

    /**
     * @return mixed
     */
    public function getIsAllowed()
    {
        return $this->getData('is_allowed');
    }

    /**
     * @param $is_allowed
     * @return Country
     */
    public function setIsAllowed($is_allowed)
    {
        $this->setData('updated_at', date("Y-m-d H:i:s"));
        return $this->setData('is_allowed', $is_allowed);
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->getData('created_at');
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->getData('updated_at');
    }

}
