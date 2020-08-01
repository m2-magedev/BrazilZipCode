<?php

namespace MageDev\BrazilZipCode\Api\Data;

interface ZipCodeInterface
{
    const FIELD_ZIPCODE = 'zip_code';
    const FIELD_STREET = 'street';
    const FIELD_NEIGHBORHOOD = 'neighborhood';
    const FIELD_INFO = 'additional_info';
    const FIELD_CITY = 'city';
    const FIELD_REGION = 'region';
    const FIELD_REGION_ID = 'region_id';
    const FIELD_CODE = 'code';
    const FIELD_DATASOURCE = 'data_source';
    const FIELD_IS_VALID = 'is_valid';
    const FIELD_CREATED_AT = 'created_at';
    const FIELD_UPDATED_AT = 'updated_at';

    /**
     * @param $zipcode
     * @return mixed
     */
    public function setZipCode($zipcode);

    /**
     * @return mixed
     */
    public function getZipCode();

    /**
     * @param $street
     * @return mixed
     */
    public function setStreet($street);

    /**
     * @return mixed
     */
    public function getStreet();

    /**
     * @param $neighborhood
     * @return mixed
     */
    public function setNeighborhood($neighborhood);

    /**
     * @return mixed
     */
    public function getNeighborhood();

    /**
     * @param $info
     * @return mixed
     */
    public function setAdditionalInfo($info);

    /**
     * @return mixed
     */
    public function getAdditionalInfo();

    /**
     * @param $city
     * @return mixed
     */
    public function setCity($city);

    /**
     * @return mixed
     */
    public function getCity();

    /**
     * @param $region
     * @return mixed
     */
    public function setRegion($region);

    /**
     * @return mixed
     */
    public function getRegion();

    /**
     * @param $regionId
     * @return mixed
     */
    public function setRegionId($regionId);

    /**
     * @return mixed
     */
    public function getRegionId();

    /**
     * @param $code
     * @return mixed
     */
    public function setCode($code);

    /**
     * @return mixed
     */
    public function getCode();

    /**
     * @param $source
     * @return mixed
     */
    public function setDataSource($source);

    /**
     * @return mixed
     */
    public function getDataSource();

    /**
     * @param $status
     * @return mixed
     */
    public function setIsValid($status);

    /**
     * @return mixed
     */
    public function getIsValid();
}