<?php


namespace MageDev\BrazilZipCode\Api;

use MageDev\BrazilZipCode\Api\Data\ZipCodeInterface;
use MageDev\BrazilZipCode\Model\ZipCode;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * @api
 */
interface ZipCodeRepositoryInterface
{

    /**
     * Save
     *
     * @param ZipCodeInterface $zipObject
     * @return ZipCodeInterface
     *
     * @throws CouldNotSaveException
     */
    public function save(ZipCodeInterface $zipObject);

    /**
     * Get by id
     *
     * @param int $id
     * @return ZipCodeInterface
     *
     * @throws NoSuchEntityException
     */
    public function getById($id);

    /**
     * Get by zipcode
     *
     * @param string $zipCode
     * @return ZipCodeInterface
     *
     * @throws NoSuchEntityException
     */
    public function getByZipCode($zipCode);

    /**
     * Delete
     *
     * @param ZipCodeInterface $zipObject
     * @return bool
     *
     * @throws CouldNotDeleteException
     */
    public function delete(ZipCodeInterface $zipObject);

    /**
     * Delete by id
     *
     * @param int $id
     * @return bool
     *
     * @throws CouldNotDeleteException
     */
    public function deleteById($id);

    /**
     * Get list
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     *
     * @throws NoSuchEntityException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

}