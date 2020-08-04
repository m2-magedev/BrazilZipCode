<?php

namespace MageDev\BrazilZipCode\Helper;

use Magento\Framework\App\Config\ConfigResource\ConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\PageCache\Model\Cache\Type;
use Magento\Framework\App\Cache\Type\Config as TypeConfig;
use Magento\Directory\Model\RegionFactory;

class Config
{
    const BASE_CONFIG_PATH = 'brazil_zipcode/';
    const CACHE_STATUS = 'general/cache_status';
    const DB_STATUS = 'general/db_status';
    const GENERAL_ZIPCODE = 'general/accept_general_zipcode';
    const SERVICE_SORT_ORDER = 'general/service_sort_order';

    /** @var ScopeConfigInterface */
    protected $scopeConfig;

    /** @var ConfigInterface */
    private $configInterface;

    /** @var TypeListInterface */
    private $cacheTypeList;

    /**
     * @var RegionFactory
     */
    protected $regionFactory;

    /**
     * Config constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param ConfigInterface $configInterface
     * @param TypeListInterface $cacheTypeList
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ConfigInterface $configInterface,
        TypeListInterface $cacheTypeList,
        RegionFactory $regionFactory
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->configInterface = $configInterface;
        $this->cacheTypeList = $cacheTypeList;
        $this->regionFactory = $regionFactory;
    }

    /**
     * Get the cache config status
     * @return mixed
     */
    public function isCacheEnabled()
    {
        return $this->getConfig(self::CACHE_STATUS);
    }

    /**
     * Get the database persistence status
     * @return mixed
     */
    public function isDbPersistenceEnabled()
    {
        return $this->getConfig(self::DB_STATUS);
    }

    /**
     * Get general zipcode status
     * @return mixed
     */
    public function isGeneralZipCodeEnabled()
    {
        return $this->getConfig(self::GENERAL_ZIPCODE);
    }

    /**
     * Get the service sort order
     * @return mixed
     */
    public function getSortOrder()
    {
        return $this->getConfig(self::SERVICE_SORT_ORDER);
    }

    /**
     * Generic config getter
     * @param string $value
     * @return mixed
     */
    private function getConfig($value)
    {
        return $this->scopeConfig->getValue(self::BASE_CONFIG_PATH . $value);
    }

    /**
     * Update Service config
     * @param $data
     */
    public function updateSystemServicesConfig($data)
    {
        $configServices = json_decode($this->getSortOrder(), true);

        if (!is_array($configServices)) {
            $configServices = [];
        }

        if (!is_array($data)) {
            return;
        }

        $result = [];
        foreach ($configServices as $key => $service) {
            if (!$this->checkServiceAvailable($service['service_name'], $data)) {
                continue;
            }
            $result[$key] = $service;
        }

        $this->configInterface->saveConfig(self::BASE_CONFIG_PATH . self::SERVICE_SORT_ORDER, json_encode($result));
        $this->cacheTypeList->cleanType(TypeConfig::TYPE_IDENTIFIER);
        $this->cacheTypeList->cleanType(Type::TYPE_IDENTIFIER);
    }

    /**
     * Check if a config service is available on the service list
     * @param $name
     * @param $services
     * @return bool
     */
    private function checkServiceAvailable($name, $services)
    {
        foreach ($services as $service) {
            if ($name === $service['name']) {
                return true;
            }
        }
        return false;
    }

    /**
     * Return the region id by region code
     * @param $code
     * @param $countryId
     * @return false
     */
    public function getRegionId($code, $countryId)
    {
        if (!$code) {
            return false;
        }

        return $this->regionFactory->create()->loadByCode($code, $countryId)->getRegionId();
    }
}