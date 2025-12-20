<?php

namespace PreferencesExamples\Model\ResourceModel;

class Product extends \Magento\Catalog\Model\ResourceModel\Product
{
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel|\Magento\Framework\DataObject $object)
    {
        $object->setName('[PREF CUSTOM] ' . $object->getName());
        return parent::_beforeSave($object);
    }
}
