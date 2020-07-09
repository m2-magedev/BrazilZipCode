<?php

namespace MageDev\BrazilZipCode\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;

class ServicesSortOrder extends AbstractFieldArray
{

    private $serviceRenderer;

    protected function _prepareToRender()
    {
        $this->addColumn('service_name', [
            'label'=> __('Service Name'),
            'renderer' => $this->getServiceRenderer()
        ]);

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
        parent::_construct();
    }

    private function getServiceRenderer()
    {
        if (!$this->serviceRenderer) {
            $this->serviceRenderer = $this->getLayout()->createBlock(
                ServiceColumn::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->serviceRenderer;
    }

    protected function _prepareArrayRow(DataObject $row)
    {
        $options = [];

        $serviceName = $row->getServiceName();
        if ($serviceName !== null) {
            $options['option_' . $this->getServiceRenderer()->calcOptionHash($serviceName)] = 'selected="selected"';
        }

        $row->setData('option_extra_attrs', $options);
    }
}
