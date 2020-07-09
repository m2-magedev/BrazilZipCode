<?php

namespace MageDev\BrazilZipCode\Model\Config;

use Magento\Framework\Config\ConverterInterface;
use Magento\Framework\DataObjectFactory;
use MageDev\BrazilZipCode\Helper\Config;

/**
 * Class Converter
 * @package MageDev\BrazilZipCode\Model\Config
 */
class Converter implements ConverterInterface
{

    /** @var DataObjectFactory  */
    protected $dataObject;

    /** @var Config  */
    private $configHelper;

    /**
     * Converter constructor.
     * @param DataObjectFactory $dataObject
     * @param Config $configHelper
     */
    public function __construct(DataObjectFactory $dataObject, Config $configHelper)
    {
        $this->dataObject = $dataObject;
        $this->configHelper = $configHelper;
    }

    /**
     * @inheritDoc
     */
    public function convert($source)
    {
        $services = $source->getElementsByTagName('service');

        $serviceListInfo['services'] = [];
        foreach ($services as $service) {
            $info = $this->getInfo($service);
            $serviceListInfo['services'][] = $info;
        }

        $this->configHelper->updateSystemServicesConfig($serviceListInfo['services']);
        return $serviceListInfo;
    }

    /**
     * Get Service node info
     * @param $service
     * @return array
     */
    private function getInfo($service)
    {
        $info = [];

        foreach ($service->childNodes as $serviceInfo) {
            if ($serviceInfo->nodeType != XML_ELEMENT_NODE) {
                continue;
            }
            $info[$serviceInfo->nodeName] = (string)$serviceInfo->nodeValue;
        }

        return $info;
    }
}
