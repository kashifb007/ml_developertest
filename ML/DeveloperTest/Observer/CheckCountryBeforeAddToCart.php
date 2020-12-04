<?php

namespace ML\DeveloperTest\Observer;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use ML\DeveloperTest\Model\CountryFactory;
use Symfony\Component\HttpFoundation\Response;
use Magento\Customer\Model\Session as CustomerSession;

/**
 * Class CheckCountryBeforeAddToCart
 * @package ML\DeveloperTest\Observer
 * @author Kashif <kash@dreamsites.co.uk>
 */
class CheckCountryBeforeAddToCart implements ObserverInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    private $_messageManager;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $_scopeConfig;

    /**
     * @var CountryFactory
     */
    private $_countryFactory;

    /**
     * API host URL
     * @var string
     */
    private $_baseUri = 'https://api.ip2country.info/';

    /**
     * @var CustomerSession
     */
    private $_customerSession;

    /**
     * CheckCountryBeforeAddToCart constructor.
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param CountryFactory $_countryFactory
     */
    public function __construct(\Magento\Framework\Message\ManagerInterface $messageManager,
                                \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
                                CountryFactory $countryFactory,
                                CustomerSession $customerSession)
    {
        $this->_messageManager = $messageManager;
        $this->_scopeConfig = $scopeConfig;
        $this->_countryFactory = $countryFactory;
        $this->_customerSession = $customerSession;
    }

    /**
     * @return \ML\DeveloperTest\Observer\Client
     */
    public function newClient(): Client
    {
        $this->_baseUri = $this->_scopeConfig->getValue('countryadmin/general/api_url', \Magento\Store\Model\ScopeInterface::SCOPE_STORE) ?? $this->_baseUri;

        $this->client = new Client([
            'base_uri' => $this->_baseUri,
            'verify' => false,
            'timeout' => 3,
            'connect_timeout' => 3,
        ]);

        return $this->client;
    }

    /**
     * @return CustomerSession
     */
    private function getCustomerSession()
    {
        return $this->_customerSession;
    }

    /**
     * @return mixed|string
     */
    public function getUserIP()
    {
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') > 0) {
                $addr = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
                return trim($addr[0]);
            } else {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        //check if module is enabled
        if ($this->_scopeConfig->getValue('countryadmin/general/country_enabled', \Magento\Store\Model\ScopeInterface::SCOPE_STORE) == 1) {

            //get warning message from config
            $warningMessage = $this->_scopeConfig->getValue('countryadmin/general/warning_message', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

            //if session shows cust can't order, just display message and abort
            if (null !== $this->getCustomerSession()->getCountry()) {
                $this->_messageManager->addWarning($warningMessage . $this->getCustomerSession()->getCountry());
                throw new \Exception($warningMessage);
            }

            $apiUrl = $this->_baseUri = $this->_scopeConfig->getValue('countryadmin/general/api_url', \Magento\Store\Model\ScopeInterface::SCOPE_STORE) ?? $this->_baseUri;
            $excludedCountries = $this->_scopeConfig->getValue('countryadmin/general/disabled_countries', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

            /** @var Client $http */
            $http = $this->newClient();

            //get your ip
            $myIp = $this->getUserIP();
            $isValid = true;

            try {
                //fetch json from api
                $res = $http->request('GET', $apiUrl . '/ip?' . $myIp, []);

                if ($res->getStatusCode() === 200) {
                    $arrayContent = json_decode($res->getBody()->getContents(), true);
                    if (isset($arrayContent)) {
                        $country = $arrayContent['countryCode3'] ?? null;
                        if (!empty($excludedCountries) && (!empty($country))) {
                            $exluded = explode(",", $excludedCountries);
                            if (in_array($country, $exluded)) {
                                $isValid = false;
                                $this->getCustomerSession()->setCountry($country);
                            }
                        }
                    }
                } else {
                    $this->_messageManager->addErrorMessage('Unable to access API');
                    throw new \Exception('Unable to access API');
                    return;
                }

                if ($isValid) {
                    //fetch countries custom table data
                    $countries = $this->_countryFactory->create();
                    $collection = $countries->getCollection();
                    $items = [];

                    foreach ($collection as $item) {
                        $items[$item->getIso3Code()] = $item->getIsAllowed();
                        if (isset($items[$country])) {
                            if ($items[$country] == 0) {
                                $isValid = false;
                                $this->getCustomerSession()->setCountry($country);
                                break;
                            }
                        }
                    }
                }

                if (!$isValid) {
                    $this->getCustomerSession()->setCountry($country);
                    $this->_messageManager->addWarning($warningMessage . $this->getCustomerSession()->getCountry());
                    throw new \Exception($warningMessage);
                } else {
                    $this->getCustomerSession()->unsetCantOrder();
                    $this->getCustomerSession()->unsetCountry();
                    return;
                }
            } catch (GuzzleException $e) {
                $this->_messageManager->addErrorMessage($e);
                throw new \Exception($e);
                return;
            }
        } else {
            return;
        }

    }
}
