<?php

namespace ML\DeveloperTest\Model\ResourceModel\Country;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package ML\DeveloperTest\Model\ResourceModel\Country
 * @author Kashif <kash@dreamsites.co.uk>
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'test_id';

    /**
     * Define resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init('ML\DeveloperTest\Model\Country', 'ML\DeveloperTest\Model\ResourceModel\Country');
    }
}
