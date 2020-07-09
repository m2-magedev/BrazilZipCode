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
    const BASE_URL = 'http://endereco.ecorreios.com.br/app/enderecoCep.php?cep=';

    public function getAddressData(ZipCodeInterface $zipObject)
    {
        $zipObject = parent::getAddressData($zipObject);

        $uri = self::BASE_URL . $zipObject->getZipCode();

        try {
            $response = $this->get($uri, true);
        } catch (\Exception $e) {
            return $zipObject;
        }

        if ($response && $response->getStatusCode() == 200) {
            $responseBody = json_decode($response->getBody(), true);
            $zipObject->setStreet($responseBody['logradouro'] ?? null);
            $zipObject->setState($responseBody['uf'] ?? null);
            $zipObject->setNeighborhood($responseBody['bairro'] ?? null);
            $zipObject->setCity($responseBody['cidade'] ?? null);
            $zipObject->setIsValid($this->validate($zipObject));
            return $zipObject;
        }
        return $zipObject;
    }

    public function validate(ZipCodeInterface $zipObject)
    {
        if (!$zipObject->getState() || !$zipObject->getCity() || !$zipObject->getStreet()) {
            return false;
        }
        return true;
    }
}
