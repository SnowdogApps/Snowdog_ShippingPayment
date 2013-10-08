<?php
/**
 * 
 * Provides information about shipment restrictions (mainly from configuration)
 * @author Snowdog
 *
 */
class Snowdog_ShippingPayment_Model_ShipmentRestrictions extends Mage_Core_Model_Abstract
{
    protected $section = 'restricted';
    
    /**
     * @var Snowdog_ShippingPayment_Model_Config
     */
    protected $config;
     
    
    public function _construct()
    {
        parent::_construct();
        $this->config = Mage::getSingleton('shippingpayment/config');
    }
    
    public function getEnabled()
    {
        return $this->config->getConfigData($this->section, 'enabled');
    } 
    
    public function getThreshold()
    {
        return $this->config->getConfigData($this->section, 'threshold');
    }
    
    /**
     * 
     * Checks if $grandTotal < threshold
     * @param double $grandTotal (tax included!)
     * @return true|false
     */
    public function isActive($grandTotal)
    {
        return $grandTotal >= $this->getThreshold();
    }
    
    /**
     * Returns restricted carrier method codes (Magento ones, not PW_MTR codes) 
     * @return array
     */
    public function getRestrictedCarriersMethodCodes()
    {
        $carriersCodeNames = $this->config->getConfigData($this->section, 'carriers');
        $carriersCodeNames = explode(',', $carriersCodeNames);

        $shipmentCodes = Mage::getModel('shippingpayment/tablerates_translator')->translateValues($carriersCodeNames);
       
        return $shipmentCodes;        
    }
}