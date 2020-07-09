<?php

namespace MageDev\BrazilZipCode\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class ZipCode
 * @package MageDev\BrazilZipCode\Model\ResourceModel
 */
class ZipCode extends AbstractDb
{
    const TABLE_NAME = 'magedev_brazil_zipcode';

    const ID_FIELD_NAME = 'id';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, self::ID_FIELD_NAME);
    }
}
