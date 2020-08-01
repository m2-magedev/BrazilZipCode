<?php

namespace MageDev\BrazilZipCode\Model;

use MageDev\BrazilZipCode\Api\Data\ZipCodeInterface;
use MageDev\BrazilZipCode\Model\ResourceModel\ZipCode as ZipCodeResourceModel;
use Magento\Framework\Model\AbstractModel;

/**
 * Class ZipCode
 * @package MageDev\BrazilZipCode\Model
 */
class ZipCode extends AbstractModel implements ZipCodeInterface
{
    protected $_idFieldName = 'id';

    public function _construct()
    {
        $this->_init(ZipCodeResourceModel::class);
    }

    public function setId($id)
    {
        $this->setData($this->_idFieldName, $id);
        return $this;
    }

    public function getId()
    {
        return $this->getData($this->_idFieldName);
    }

    public function setZipCode($zipcode)
    {
        $zipcode = preg_replace('~\D~', '', $zipcode);
        $this->setData(self::FIELD_ZIPCODE, $zipcode);
        return $this;
    }

    public function getZipCode()
    {
        return $this->getData(self::FIELD_ZIPCODE);
    }

    public function setStreet($street)
    {
        $this->setData(self::FIELD_STREET, $street);
        return $this;
    }

    public function getStreet()
    {
        return $this->getData(self::FIELD_STREET);
    }

    public function setNeighborhood($neighborhood)
    {
        $this->setData(self::FIELD_NEIGHBORHOOD, $neighborhood);
        return $this;
    }

    public function getNeighborhood()
    {
        return $this->getData(self::FIELD_NEIGHBORHOOD);
    }

    public function setAdditionalInfo($info)
    {
        $this->setData(self::FIELD_INFO, $info);
        return $this;
    }

    public function getAdditionalInfo()
    {
        return $this->getData(self::FIELD_INFO);
    }

    public function setCity($city)
    {
        $this->setData(self::FIELD_CITY, $city);
        return $this;
    }

    public function getCity()
    {
        return $this->getData(self::FIELD_CITY);
    }

    public function setRegion($region)
    {
        $this->setData(self::FIELD_REGION, $region);
        return $this;
    }

    public function getRegion()
    {
        return $this->getData(self::FIELD_REGION);
    }

    public function setRegionId($regionId)
    {
        $this->setData(self::FIELD_REGION_ID, $regionId);
        return $this;
    }

    public function getRegionId()
    {
        return $this->getData(self::FIELD_REGION_ID);
    }

    public function setCode($code)
    {
        $this->setData(self::FIELD_CODE, $code);
        return $this;
    }

    public function getCode()
    {
        return $this->getData(self::FIELD_CODE);
    }

    public function setDataSource($source)
    {
        $this->setData(self::FIELD_DATASOURCE, $source);
        return $this;
    }

    public function getDataSource()
    {
        return $this->getData(self::FIELD_DATASOURCE);
    }

    public function setIsValid($status)
    {
        $this->setData(self::FIELD_IS_VALID, $status);
        return $this;
    }

    public function getIsValid()
    {
        return $this->getData(self::FIELD_IS_VALID);
    }
}
