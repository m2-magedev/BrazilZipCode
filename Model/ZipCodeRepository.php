<?php


namespace MageDev\BrazilZipCode\Model;


use MageDev\BrazilZipCode\Api\Data\SourceType;
use MageDev\BrazilZipCode\Api\Data\ZipCodeInterface;
use MageDev\BrazilZipCode\Api\Data\ZipCodeInterfaceFactory;
use MageDev\BrazilZipCode\Model\ResourceModel\ZipCode as ZipCodeResourceModel;
use MageDev\BrazilZipCode\Api\ZipCodeRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class ZipCodeRepository implements ZipCodeRepositoryInterface
{
    /** @var ZipCodeInterface[] */
    protected $zipCodes;

    /** @var ZipCodeInterfaceFactory */
    private $zipCodeFactory;

    /** @var ZipCodeResourceModel */
    private $zipCodeResource;

    /**
     * ZipCodeRepository constructor.
     * @param ZipCodeResourceModel $resourceModel
     * @param ZipCodeInterfaceFactory $zipCodeFactory
     */
    public function __construct(
        ZipCodeResourceModel $resourceModel,
        ZipCodeInterfaceFactory $zipCodeFactory
    ) {
        $this->zipCodeResource = $resourceModel;
        $this->zipCodes = [];
        $this->zipCodeFactory = $zipCodeFactory;
    }

    /**
     * Save
     * @param ZipCodeInterface $zipObject
     * @return ZipCodeInterface|ZipCode
     * @throws CouldNotSaveException
     */
    public function save(ZipCodeInterface $zipObject)
    {
        try {
            if ($zipObject->getId()) {
                $zipObject = $this->getById($zipObject->getId())->addData($zipObject->getData());
            }

            $this->zipCodeResource->save($zipObject);

        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Unable to save new zipcode. Error: %1', $e->getMessage()));
        }

        return $zipObject;
    }

    /**
     * Get by id
     * @param int $id
     * @return ZipCodeInterface|ZipCode|mixed
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        if (!isset($this->zipCodes[$id])) {
            /** @var ZipCode $object */
            $object = $this->zipCodeFactory->create();
            $this->zipCodeResource->load($object, $id);
            if (!$object->getId()) {
                throw new NoSuchEntityException(__('ZipCode with specified ID %1 not found.', $id));
            }
            $this->zipCodes[$id] = $object;
        }

        return $this->zipCodes[$id];
    }

    /**
     * Get by zipcode
     * @param string $zipCode
     * @return ZipCodeInterface|ZipCode|mixed
     * @throws NoSuchEntityException
     */
    public function getByZipCode($zipCode)
    {
        $id = null;
        if ($this->zipCodes) {
            $id = $this->getZipByCode($zipCode);
        }

        if (!$id) {
            /** @var ZipCode $object */
            $object = $this->zipCodeFactory->create()->load($zipCode, ZipCodeInterface::FIELD_ZIPCODE);
            if (!$object->getId()) {
                throw new NoSuchEntityException(__('ZipCode %1 not found.', $zipCode));
            }
            $id = $object->getId();
            $object->setDataSource(SourceType::DATABASE);
            $this->zipCodes[$id] = $object;
        }

        return $this->zipCodes[$id];
    }

    /**
     * Get zip code
     * @param $zipCode
     * @return int|string|null
     */
    private function getZipByCode($zipCode)
    {
        foreach ($this->zipCodes as $key => $value) {
            if ($value->getZipCode() === $zipCode) {
                return $key;
            }
        }

        return null;
    }

    /**
     * Delete
     * @param ZipCodeInterface $zipObject
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(ZipCodeInterface $zipObject)
    {
        try {
            $this->zipCodeResource->delete($zipObject);

            unset($this->zipCodes[$zipObject->getId()]);
        } catch (\Exception $e) {
            if ($zipObject->getEntityId()) {
                throw new CouldNotDeleteException(
                    __(
                        'Unable to remove Zip Code with ID %1. Error: %2',
                        [$zipObject->getEntityId(), $e->getMessage()]
                    )
                );
            }
            throw new CouldNotDeleteException(__('Unable to remove Zip Code. Error: %1', $e->getMessage()));
        }

        return true;
    }

    /**
     * Delete by id
     * @param int $id
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteById($id)
    {
        try {
            $zipModel = $this->getById($id);
            $this->delete($zipModel);
        } catch (NoSuchEntityException $exception) {
            throw new CouldNotDeleteException(
                __(
                    'Unable to remove Zip Code with ID %1. Error: %2',
                    [$id, $exception->getMessage()]
                )
            );
        }

        return true;
    }

    /**
     * Get list
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface|void
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        // TODO: Implement getList() method.
    }
}