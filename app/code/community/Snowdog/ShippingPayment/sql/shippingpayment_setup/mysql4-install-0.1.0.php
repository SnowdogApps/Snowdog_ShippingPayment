<?php

$installer = $this;

$installer->startSetup();
$code = Mage::getModel('shippingpayment/config')->getAttributeCode();
$entityTypeId = Mage::getModel('eav/entity')->setType('catalog_product')->getTypeId(); 

$attribute = array(
	'type' => 'text',
    'user_defined' => 1,
	'input' => 'multiselect',
    'source' => 'shippingpayment/entity_source_restrictedShipment',
	'backend' => 'shippingpayment/entity_backend_restrictedShipment',
	'frontend' => 'shippingpayment/entity_frontend_restrictedShipment',
    'required' => 0, 
    'label' => 'Restricted shipment methods',   
); 
$installer->addAttribute($entityTypeId, $code, $attribute);

$installer->endSetup();
