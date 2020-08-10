<?php

namespace MageDev\BrazilZipCode\Api;


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
     * @return \MageDev\BrazilZipCode\Api\Data\ZipCodeInterface
     */
    public function search($zipCode);
}