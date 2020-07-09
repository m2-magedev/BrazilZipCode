<?php


namespace MageDev\BrazilZipCode\Gateway\Services;


use MageDev\BrazilZipCode\Api\Data\ZipCodeInterface;
use MageDev\BrazilZipCode\Api\Data\ZipCodeInterfaceFactory;
use MageDev\BrazilZipCode\Api\ZipCodeServiceApiInterface;
use MageDev\BrazilZipCode\Model\SearchProcessor;
use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Class ZipCodeServiceApi
 * @package MageDev\BrazilZipCode\Gateway\Services
 * @api
 */
class ZipCodeServiceApi implements ZipCodeServiceApiInterface
{
    /**
     * @var ZipCodeInterfaceFactory
     */
    private $zipCodeFactory;
    /**
     * @var SearchProcessor
     */
    private $processor;

    /**
     * ZipCodeServiceApi constructor.
     * @param ZipCodeInterfaceFactory $zipCodeFactory
     * @param SearchProcessor $processor
     */
    public function __construct(
        ZipCodeInterfaceFactory $zipCodeFactory,
        SearchProcessor $processor
    ) {
        $this->zipCodeFactory = $zipCodeFactory;
        $this->processor = $processor;
    }

    /**
     * Search
     * @param string $zipCode
     * @return ZipCodeInterface
     * @throws CouldNotSaveException
     */
    public function search($zipCode)
    {
        $zipObject = $this->zipCodeFactory->create();
        $zipObject->setZipCode($zipCode);
        $zipObject = $this->processor->process($zipObject);
        return $zipObject;
    }
}