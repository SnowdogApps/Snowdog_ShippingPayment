<?php
/**
 * 
 * Class responsible for translating the fronend label of an restricted_shipment attribute
 * @author Snowdog
 *
 */
class Snowdog_ShippingPayment_Model_Entity_Frontend_RestrictedShipment extends Mage_Eav_Model_Entity_Attribute_Frontend_Abstract
{
    public function getLabel()
    {
        $label = parent::getLabel();
        return Mage::helper('shippingpayment')->__($label);
    }   
}