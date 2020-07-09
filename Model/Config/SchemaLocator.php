<?php

namespace MageDev\BrazilZipCode\Model\Config;

use Magento\Framework\Module\Dir;

/**
 * Class SchemaLocator
 * @package MageDev\BrazilZipCode\Model\Config
 */
class SchemaLocator implements \Magento\Framework\Config\SchemaLocatorInterface
{
    const FILE_SCHEMA = 'brazil_zipcode_services.xsd';

    /**
     * Path to corresponding XSD file with validation rules for merged config
     *
     * @var string
     */
    protected $schema = null;

    /**
     * Path to corresponding XSD file with validation rules for separate config files
     *
     * @var string
     */
    protected $perFileSchema = null;

    /**
     * @param \Magento\Framework\Module\Dir\Reader $moduleReader
     */
    public function __construct(\Magento\Framework\Module\Dir\Reader $moduleReader)
    {
        $etcDir = $moduleReader->getModuleDir(Dir::MODULE_ETC_DIR, 'MageDev_BrazilZipCode');
        $this->schema = $etcDir . DIRECTORY_SEPARATOR . self::FILE_SCHEMA;
        $this->perFileSchema = $etcDir . DIRECTORY_SEPARATOR . self::FILE_SCHEMA;
    }

    /**
     * Get path to merged config schema
     *
     * @return string|null
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * Get path to pre file validation schema
     *
     * @return string|null
     */
    public function getPerFileSchema()
    {
        return $this->perFileSchema;
    }
}
