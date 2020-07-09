<?php


namespace MageDev\BrazilZipCode\Model\Config;

/**
 * Class Reader
 * @package MageDev\BrazilZipCode\Model\Config
 */
class Reader extends \Magento\Framework\Config\Reader\Filesystem
{
    /**
     * List of identifier attributes for merging
     *
     * @var array
     */
    protected $_idAttributes = [
        '/services/service'        => 'id'
    ];
}