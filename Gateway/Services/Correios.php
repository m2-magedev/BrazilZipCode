<?php

namespace MageDev\BrazilZipCode\Gateway\Services;

use MageDev\BrazilZipCode\Api\Data\ZipCodeInterface;
use MageDev\BrazilZipCode\Gateway\AbstractZipCodeService;

/**
 * Class Correios
 * @package MageDev\BrazilZipCode\Gateway\Services
 */
class Correios extends AbstractZipCodeService
{
    const BASE_URL = 'http://cep.republicavirtual.com.br/web_cep.php?cep=ZIPCODE&formato=jsonp';

    /** @inheritdoc */
    public function getAddressData(ZipCodeInterface $zipObject)
    {
        $zipObject = parent::getAddressData($zipObject);
        $uri = str_replace('ZIPCODE', $zipObject->getZipCode(), self::BASE_URL);

        try {
            $response = $this->get($uri, true);
        } catch (\Exception $e) {
            return $zipObject;
        }

        if ($response && $response->getStatusCode() == 200) {
            $responseBody = json_decode($response->getBody(), true);
            $zipObject->setStreet($responseBody['logradouro'] ?? null);
            $zipObject->setRegion($responseBody['uf'] ?? null);
            $zipObject->setRegionId($this->config->getRegionId($responseBody['uf'], 'BR') ?? null);
            $zipObject->setNeighborhood($responseBody['bairro'] ?? null);
            $zipObject->setCity($responseBody['cidade'] ?? null);
            $zipObject->setIsValid($this->validate($zipObject));
            return $zipObject;
        }
        return $zipObject;
    }

    /** @inheritdoc */
    public function validate(ZipCodeInterface $zipObject)
    {
        $generalZipCode = $this->config->isGeneralZipCodeEnabled();
        if ((!$generalZipCode && !$zipObject->getStreet())
            || !$zipObject->getCity()
            || !$zipObject->getRegion()) {
            return false;
        }
        return true;
    }
}
