<?php

namespace ML\DeveloperTest\Block;

use Magento\Framework\View\Element\Template;
use ML\DeveloperTest\Model\ResourceModel\Country\Collection as CountryCollection;
use ML\DeveloperTest\Model\ResourceModel\Country\CollectionFactory;

class CountryList extends Template
{

    /**
     * @var \ML\DeveloperTest\Model\ResourceModel\Country\CollectionFactory
     */
    protected $_countryColFactory;

    /**
     * CountryList constructor.
     * @param Template\Context $context
     * @param CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        array $data = []
    )
    {
        $this->_countryColFactory = $collectionFactory;
        parent::__construct(
            $context,
            $data
        );
    }

}
