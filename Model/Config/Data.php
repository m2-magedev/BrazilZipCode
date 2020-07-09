<?php

namespace MageDev\BrazilZipCode\Model\Config;

/**
 * Class Data
 * @package MageDev\BrazilZipCode\Model\Config
 */
class Data extends \Magento\Framework\Config\Data implements DataInterface
{
    /**
     * @inheritDoc
     */
    public function getAll()
    {
        return $this->get('services');
    }
}