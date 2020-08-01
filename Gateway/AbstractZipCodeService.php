<?php


namespace MageDev\BrazilZipCode\Gateway;

use MageDev\BrazilZipCode\Api\Data\SourceType;
use MageDev\BrazilZipCode\Api\Data\ZipCodeInterface;
use MageDev\BrazilZipCode\Api\ZipCodeServiceInterface;

/**
 * Class AbstractZipCodeService
 * @package MageDev\BrazilZipCode\Gateway
 */
abstract class AbstractZipCodeService extends AbstractRequest implements ZipCodeServiceInterface
{

    /**
     * Get address data
     * @param ZipCodeInterface $zipObject
     * @return ZipCodeInterface
     */
    public function getAddressData(ZipCodeInterface $zipObject)
    {
        // TODO: Override and implement your api call
        $zipObject->setDataSource(SourceType::SERVICE);
        $zipObject->setIsValid($this->validate($zipObject));
        return $zipObject;
    }

    /**
     * Validate zipcode data
     * @param ZipCodeInterface $zipObject
     * @return bool
     */
    public function validate(ZipCodeInterface $zipObject)
    {
        // TODO: Override and implement your validations over the object
        return false;
    }
}