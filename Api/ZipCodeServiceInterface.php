<?php


namespace MageDev\BrazilZipCode\Api;

use MageDev\BrazilZipCode\Api\Data\ZipCodeInterface;

/**
 * Interface ZipCodeServiceInterface
 * @package MageDev\BrazilZipCode\Api
 */
interface ZipCodeServiceInterface
{
    /**
     * Get the address data
     * @param ZipCodeInterface $zipObject
     * @return ZipCodeInterface
     */
    public function getAddressData(ZipCodeInterface $zipObject);


    /**
     * Validate object data
     * @param ZipCodeInterface $zipObject
     * @return boolean
     */
    public function validate(ZipCodeInterface $zipObject);
}