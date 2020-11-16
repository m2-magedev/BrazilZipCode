<?php

namespace MageDev\BrazilZipCode\Gateway\Services;

use MageDev\BrazilZipCode\Api\Data\ZipCodeInterface;
use MageDev\BrazilZipCode\Gateway\AbstractZipCodeService;

class ViaCep extends AbstractZipCodeService
{
    const BASE_URL = "https://viacep.com.br/ws/";

    /** @inheritdoc */
    public function getAddressData(ZipCodeInterface $zipObject)
    {
        $zipObject = parent::getAddressData($zipObject);

        $uri = self::BASE_URL . "{$zipObject->getZipCode()}/json";

        try {
            $response = $this->get($uri, true);
        } catch (\Exception $e) {
            return $zipObject;
        }

        if ($response && $response->getStatusCode() == 200) {
            $responseBody = json_decode($response->getBody(), true);
            $isError = isset($responseBody['erro']) && $responseBody['erro'] === true;

            if ($isError) {
                return $zipObject;
            }

            $zipObject->setStreet($responseBody['logradouro'] ?? null);
            $zipObject->setRegion($responseBody['uf'] ?? null);
            $zipObject->setRegionId($this->config->getRegionId($responseBody['uf'] ?? null, 'BR'));
            $zipObject->setNeighborhood($responseBody['bairro'] ?? null);
            $zipObject->setCity($responseBody['localidade'] ?? null);
            $zipObject->setAdditionalInfo($responseBody['complemento'] ?? null);
            $zipObject->setCode($responseBody['ibge'] ?? null);
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
