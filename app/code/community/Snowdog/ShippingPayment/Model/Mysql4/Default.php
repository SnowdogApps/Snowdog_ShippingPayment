<?php
/**
 * 
 * Default resource model providing data about extra shipping methods. Used as an empty stub. 
 * @author Snowdog
 *
 */
class Snowdog_ShippingPayment_Model_Mysql4_Default extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        //do nothing                
    }
    
    /**
     * 
     * Checks if the tablerate module tables exist in the Database. 
     */
	public function checkIfModuleInstalled()
	{
	    return true;
	}
    
    /**
     * 
     * Extra shipment codenames 
     */
    public function getMethodCodenames()
    {
        return array();
    }
    
    /**
     * 
     * Shipment method codes for a specific codename 
     * @param string $codeName
     */
    public function getShipmentMethods($codeName)
    {
        return array();
    }
    
}