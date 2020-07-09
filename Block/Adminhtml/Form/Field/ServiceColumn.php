<?php
declare(strict_types=1);

namespace MageDev\BrazilZipCode\Block\Adminhtml\Form\Field;

use MageDev\BrazilZipCode\Model\Config\Data;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\View\Element\Html\Select;

/**
 * Class ServiceColumn
 * @package MageDev\BrazilZipCode\Block\Adminhtml\Form\Field
 */
class ServiceColumn extends Select
{

    /**
     * Set "name" for <select> element
     *
     * @param string $value
     * @return $this
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * Set "id" for <select> element
     *
     * @param $value
     * @return $this
     */
    public function setInputId($value)
    {
        return $this->setId($value);
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    public function _toHtml(): string
    {
        if (!$this->getOptions()) {
            $this->setOptions($this->getSourceOptions());
        }
        return parent::_toHtml();
    }

    private function getSourceOptions(): array
    {
        /** @var Data $data */
        $data = ObjectManager::getInstance()->create(Data::class);
        $services = $data->getAll();

        $result = [];
        foreach ($services as $service) {
            $result[] = ['label' => $service['name'], 'value'=> $service['name']];
        }
        return $result;
    }
}
