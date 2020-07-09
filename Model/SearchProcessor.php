<?php

namespace MageDev\BrazilZipCode\Model;

use MageDev\BrazilZipCode\Api\Data\SourceType;
use MageDev\BrazilZipCode\Api\Data\ZipCodeInterface;
use MageDev\BrazilZipCode\Api\ZipCodeRepositoryInterface;
use MageDev\BrazilZipCode\Api\ZipCodeServiceInterface;
use MageDev\BrazilZipCode\Gateway\Services\CacheService;
use MageDev\BrazilZipCode\Helper\Config as ConfigHelper;
use MageDev\BrazilZipCode\Model\Config\DataInterface;
use Magento\Framework\ObjectManagerInterface;

class SearchProcessor
{
    /** @var CacheService */
    private $cacheService;

    /** @var ObjectManagerInterface */
    private $objectManager;

    /** @var DataInterface */
    private $dataConfig;

    /** @var ZipCodeRepositoryInterface */
    protected $zipCodeRepository;

    /** @var ConfigHelper */
    protected $configHelper;

    /**
     * SearchProcessor constructor.
     * @param CacheService $cacheService
     * @param ObjectManagerInterface $objectManager
     * @param DataInterface $dataConfig
     * @param ZipCodeRepositoryInterface $zipCodeRepository
     * @param ConfigHelper $configHelper
     */
    public function __construct(
        CacheService $cacheService,
        ObjectManagerInterface $objectManager,
        DataInterface $dataConfig,
        ZipCodeRepositoryInterface $zipCodeRepository,
        ConfigHelper $configHelper
    ) {
        $this->cacheService = $cacheService;
        $this->objectManager = $objectManager;
        $this->dataConfig = $dataConfig;
        $this->zipCodeRepository = $zipCodeRepository;
        $this->configHelper = $configHelper;
    }

    /**
     * Process the zipcode search
     * @param ZipCodeInterface $zipObject
     * @return ZipCodeInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function process(ZipCodeInterface $zipObject)
    {
        $zipObject = $this->searchFromCache($zipObject);

        if (!$zipObject->getIsValid()) {
            $zipObject = $this->searchFromDatabase($zipObject);
        }

        if (!$zipObject->getIsValid()) {
            $zipObject = $this->searchFromServices($zipObject);
            if ($this->configHelper->isDbPersistenceEnabled() && $zipObject->getIsValid()) {
                $this->zipCodeRepository->save($zipObject);
            }
        }

        if ($this->configHelper->isCacheEnabled() && $zipObject->getDataSource() !== SourceType::CACHE && $zipObject->getIsValid()) {
            $this->cacheService->save($zipObject);
        }

        return $zipObject;
    }

    /**
     * Search from cache
     * @param ZipCodeInterface $zipObject
     * @return ZipCodeInterface
     */
    public function searchFromCache(ZipCodeInterface $zipObject)
    {
        if (!$this->configHelper->isCacheEnabled()) {
            return $zipObject;
        }
        return $this->cacheService->getAddressData($zipObject);
    }

    /**
     * Search from database
     * @param ZipCodeInterface $zipObject
     * @return ZipCodeInterface
     */
    public function searchFromDatabase(ZipCodeInterface $zipObject)
    {
        if (!$this->configHelper->isCacheEnabled()) {
            return $zipObject;
        }

        try {
            $object = $this->zipCodeRepository->getByZipCode($zipObject->getZipCode());
            if ($object && $object->getIsValid()) {
                return $object;
            }
            return $zipObject;
        } catch (\Exception $e) {
            return $zipObject;
        }
    }

    /**
     * Search from services
     * @param ZipCodeInterface $zipObject
     * @return ZipCodeInterface
     */
    public function searchFromServices(ZipCodeInterface $zipObject)
    {
        $services = $this->getServices();
        if (!$services) {
            return $zipObject;
        }

        foreach ($services as $service) {
            /** @var ZipCodeServiceInterface $instance */
            $instance = $this->objectManager->create($service['class']);
            if (!$instance) {
                continue;
            }
            $zipObject = $instance->getAddressData($zipObject);
            if ($zipObject->getIsValid()) {
                $zipObject->setDataSource($service['name']);
                break;
            }
        }

        return $zipObject;
    }

    /**
     * Get services tha implements ZipCodeServiceInterface
     * @return array
     */
    private function getServices()
    {
        $list = [];
        $services = $this->dataConfig->getAll();
        if (!$services) {
            return $list;
        }
        $sortOrder = json_decode($this->configHelper->getSortOrder(), true);
        if (is_array($sortOrder) && count($sortOrder) > 0) {
            $sorted = [];
            foreach ($sortOrder as $key => $item) {
                array_map(function ($serviceItem) use ($item, &$sorted) {
                    if ($serviceItem['name'] == $item['service_name']) {
                        array_push($sorted, $serviceItem);
                    }
                }, $services);
            }
            $services = $sorted;
        }

        foreach ($services as $service) {
            $class = $service['class'];
            if (in_array(ZipCodeServiceInterface::class, class_implements($class))) {
                $list[] = $service;
            }
        }
        return $list;
    }
}
