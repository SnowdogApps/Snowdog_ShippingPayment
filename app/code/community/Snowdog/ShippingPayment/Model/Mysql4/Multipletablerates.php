<?php
/**
 * 
 * Resource model responsible for extracting data from PW_Multipletablerates tables
 * @author Snowdog
 *
 */
class Snowdog_ShippingPayment_Model_Mysql4_Multipletablerates extends Snowdog_ShippingPayment_Model_Mysql4_Default
{
    protected $namePrefix = 'multipletablerates_bestway_';
    
    protected function _construct()
	{
		$this->_init('shippingpayment/multipletablerates', 'pk');
	}
	
	/**
     * 
     * Checks if the tablerate module tables exist in the Database. 
     */
	public function checkIfModuleInstalled()
	{
	    try {	    
    	    $result = $this->_getReadAdapter()->describeTable(Mage::getSingleton('core/resource')->getTableName('shippingpayment/multipletablerates')); //throws exception	    
    	    if (empty($result))
    	        return false;
    	    return true;
	    }
	    catch (Exception $e) {
	        return false; 
	    }
	}
	
	/**
	 * 
	 * Get the MTPR shipment method codenames (unique)
	 * @return array([0] => code0, [1] => code1 ...)
	 */
	public function getMethodCodenames()
	{
	    $read = $this->_getReadAdapter();
	    
	    //table name of PW_Multipple table rates
		$table = Mage::getSingleton('core/resource')->getTableName('shippingpayment/multipletablerates');
		
		/** @var Zend_Db_Select*/         
		$select = $read->select()->from($table,'method_code')->group('method_code');		
		if(!empty($table))
		    return $read->fetchCol($select);
		return array();	
	}
	
	/**
	 * 
	 * Translate MTPR shipment method codenames into magento shipment method codes
	 */
	public function getShipmentMethods($codeName)
	{
	    $read = $this->_getReadAdapter();
	    
	    //table name of PW_Multipple table rates
		$table = Mage::getSingleton('core/resource')->getTableName('shippingpayment/multipletablerates');
		
		/** @var Zend_Db_Select*/         
		$select = $read->select()->from($table,'pk')->where('method_code = ?', $codeName);		
			
		$names = array();
		if(!empty($table))
		{
    		$ids = $read->fetchCol($select);
    		foreach ($ids as $id)
    		{
    		    $names[] = $this->namePrefix.$id;
    		}
		}
			
		return $names;
	}
	
	
}