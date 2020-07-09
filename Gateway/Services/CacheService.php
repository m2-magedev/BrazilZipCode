<?php

namespace MageDev\BrazilZipCode\Gateway\Services;

use MageDev\BrazilZipCode\Api\Data\SourceType;
use MageDev\BrazilZipCode\Api\Data\ZipCodeInterface;
use MageDev\BrazilZipCode\Api\ZipCodeServiceInterface;
use MageDev\BrazilZipCode\Model\Cache\Type\ApiSearchType;

/**
 * Class CacheService
 * @package MageDev\BrazilZipCode\Gateway\Services
 */
class CacheService implements ZipCodeServiceInterface
{
    /** @var ApiSearchType  */
    private $cacheType;

    /**
     * CacheService constructor.
     * @param ApiSearchType $cacheType
     */
    public function __construct(ApiSearchType $cacheType)
    {
        $this->cacheType = $cacheType;
    }

    /**
     * Get address data
     * @param ZipCodeInterface $zipObject
     * @return ZipCodeInterface
     */
    public function getAddressData(ZipCodeInterface $zipObject)
    {
        $cacheData = $this->getCacheData();

        if (!$cacheData) {
            return $zipObject;
        }

        if (isset($cacheData[$zipObject->getZipCode()])) {
            $item = $cacheData[$zipObject->getZipCode()];
            $zipObject->setData($item->getData());
            $zipObject->setDataSource(SourceType::CACHE);
            $zipObject->setIsValid(true);
        }
        return $zipObject;
    }

    /**
     * Get data from cache
     * @return mixed
     */
    public function getCacheData()
    {
        $cacheData = $this->cacheType->load(ApiSearchType::CACHE_TAG);
        return unserialize($cacheData);
    }

    /**
     * Save data to cache
     * @param ZipCodeInterface $zipObject
     */
    public function save(ZipCodeInterface $zipObject)
    {
        $cacheData = $this->getCacheData();
        $cacheData[$zipObject->getZipCode()] = $zipObject;
        $this->cacheType->save(serialize($cacheData), ApiSearchType::CACHE_TAG);
    }

    /**
     * Validate
     * @param ZipCodeInterface $zipObject
     * @return bool
     */
    public function validate(ZipCodeInterface $zipObject)
    {
        return true;
    }
}
