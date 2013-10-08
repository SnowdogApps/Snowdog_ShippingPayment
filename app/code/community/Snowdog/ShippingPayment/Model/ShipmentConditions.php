<?php
/**
 * 
 * Backend model for shipment conditions configuration data
 * @author Snowdog
 *
 */
class Snowdog_ShippingPayment_Model_ShipmentConditions extends Mage_Core_Model_Config_Data
{
    /**
     * Prepeares the data to be saved in the database
     * @see Mage_Core_Model_Abstract::_beforeSave()
     */
    protected function _beforeSave(){
        $groupData = $this->getGroups();
        $fieldData = $groupData['shippingconditions']['fields']['enabled_payments'];
        $json = json_encode($fieldData);
        
        $this->setValue($json);
    }
    
    /**
     * Decodes the data in the database, so it can be displayed in the admin form
     * @see Mage_Core_Model_Abstract::_afterLoad()
     */
    protected function _afterLoad(){
        $decodedValue = json_decode($this->getValue(),true); //decode as assoc array
        $this->setValue($decodedValue);        
    }
    
    /**
     * 
     * Gets an array of shipment conditions for 
     * the validation in Snowdog_ShippingPayment_Block_Onepage_Payment_Methods.
     * Method codes are already resolved from PW_Multipletablerates codenames into Magento
     * method codes. 
     * @see Snowdog_ShippingPayment_Block_Onepage_Payment_Methods
     * @return Array
     */
    public function getShipmentConditions() {
        //Prepare the data
        $config = Mage::getModel('shippingpayment/config');
        $this->setValue($config->getConfigData('shippingconditions','enabled_payments'));
        $this->_afterLoad();
        $value = $this->getValue();
        
        $result = Mage::getModel('shippingpayment/tablerates_translator')->translateKeys($value);
             
        return $result;
    }
}