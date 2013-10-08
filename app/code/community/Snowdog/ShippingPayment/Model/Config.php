<?php
/**
 * 
 * Configuration handling model
 * @author Snowdog
 *
 */
class Snowdog_ShippingPayment_Model_Config extends Mage_Core_Model_Abstract
{
    /**
     * Name of the product attribute
     */
    protected $productShipmentAttributeCode = "restricted_shipments"; 
    
    /**
     * Lazy loading
     * @var Array     
     */
    protected $magentoShipmentMethods = null;
    
 
    /**
     * 
     * Returns the value of config key
     * @param string $section
     * @param string $field
     */
    public function getConfigData($section, $field)
    {
        return Mage::getStoreConfig('shippingpayment/'.$section.'/'.$field);
    }
    
    /**
     * Access method for the product shipment attribute code 
     */
    public function getAttributeCode()
    {
        return $this->productShipmentAttributeCode; 
    }
    
    /**
     * 
     * Gets a list of active shipment methods in magento (not Multipletablerates methods) 
     */
    public function getMagentoActiveShipmentMethods()
    {
        if($this->magentoShipmentMethods == null)
        {
            $this->magentoShipmentMethods = array();
            
            $carriers = Mage::getSingleton('shipping/config')->getAllCarriers();
            foreach ($carriers as $carrierCode=>$carrierModel) {
                if (!$carrierModel->isActive()  === true) {
                    continue;
                }
                $carrierMethods = $carrierModel->getAllowedMethods();
                if (!$carrierMethods) {
                    continue;
                }            
                foreach ($carrierMethods as $methodCode=>$methodTitle) {
                    $this->magentoShipmentMethods[] = $carrierCode.'_'.$methodCode;
                }
            }
        }            
        return $this->magentoShipmentMethods;
    }
    
    /**
     * Checks if method code indicates a magento shipment method
     * @return true|false
     */
    public function isMagentoShipmentMethod($methodCode)
    {
        $methods = $this->getMagentoActiveShipmentMethods();
        return in_array($methodCode, $methods);   
    }
    
}