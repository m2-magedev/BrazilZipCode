<?php


namespace MageDev\BrazilZipCode\Api;


use MageDev\BrazilZipCode\Api\Data\ZipCodeInterface;

/**
 * Interface ZipCodeServiceApiInterface
 * @package MageDev\BrazilZipCode\Api
 * @api
 * @since 1.0.0
 */
interface ZipCodeServiceApiInterface
{
    /**
     * Search zipcode
     * @param string $zipCode
     * @return ZipCodeInterface
     */
    public function search($zipCode);
}