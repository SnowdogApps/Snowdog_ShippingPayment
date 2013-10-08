<?php
/**
 * 
 * Adminhtml model for restricted_shipments attribute
 * @author Snowdog
 *
 */
class Snowdog_ShippingPayment_Model_Entity_Source_RestrictedShipment extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    public function getAllOptions()
    {
        if (is_null($this->_options)) {
            $emptyField = array (array('label' => Mage::helper('shippingpayment')->__('All shipment methods available'), 'value' => 'none'));
            $this->_options = array_merge($emptyField, Mage::getModel('shippingpayment/adminhtml_shipments')->toOptionArray());
        }
        return $this->_options;
    }
    
	/**
     * Get a text for option value
     *
     * @param string|integer $value
     * @return string
     */
    public function getOptionText($value)
    {
        $options = $this->getAllOptions();
        foreach ($options as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return false;
    }
}