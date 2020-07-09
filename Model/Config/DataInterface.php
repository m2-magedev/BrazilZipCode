<?php


namespace MageDev\BrazilZipCode\Model\Config;

/**
 * Interface DataInterface
 * @package MageDev\BrazilZipCode\Model\Config
 */
interface DataInterface
{
    /**
     * Get configuration of all registered services
     *
     * @return array
     */
    public function getAll();
}