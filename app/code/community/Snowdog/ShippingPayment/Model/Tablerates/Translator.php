<?php
/**
 * 
 * Translates codenames into real magento shipping codes
 * @author Snowdog
 *
 */
class Snowdog_ShippingPayment_Model_Tablerates_Translator extends Mage_Core_Model_Abstract
{
    /**
     *     
     * @var Snowdog_ShippingPayment_Model_Config
     */
    protected $config = null;

    /**
     * 
     * @var Snowdog_ShippingPayment_Model_Mysql4_Default
     */
    protected $resource = null;
    
    /**
     * 
     * @return Snowdog_ShippingPayment_Model_Config
     */
    protected function getConfig()
    {
        if ($this->config == null){
           $this->config = Mage::getSingleton('shippingpayment/config');
        }
        return $this->config;
    }
    
    protected function getResourceModel()
    {
        if ($this->resource == null){
           $this->resource = Mage::getModel('shippingpayment/tablerates_tablerateFactory')->getResourceModel();
        }
        return $this->resource;
    }
    
    /**
     * 
     * Translates codename into an array of shipment codes
     * @param unknown_type $codeName
     */
    protected function translate($codename)
    {
        if($this->getConfig()->isMagentoShipmentMethod($codename))
        {
            return array($codename); 
        }
        else if ($this->getConfig()->getConfigData('tablerates','enabled'))
        {
            return $this->getResourceModel()->getShipmentMethods($codename);
        }
        return array();
    }
    
    /**
     * 
     * Translates a codename array into method codes array 
     * @param array $codenames array( 'codename1' => $sth1, 'codename2' => $sth2 )						   
     * @return array  
     */    
    public function translateKeys($codenames)
    {
        $result = array();
        foreach($codenames as $codename => $value)
        {
            $translatedCodes = $this->translate($codename);
            foreach ($translatedCodes as $code)
            {
                $result[$code] = $value;
            }
        }        
        return $result;
    }
    
    /**
     * 
     * Translates a codename array into method codes array 
     * @param array $codenames array('codename1', 'codename2')						   
     * @return array  
     */
    public function translateValues($codenames)
    {
        $result = array();
        foreach($codenames as $codename)
        {
            
            $translatedCodes = $this->translate($codename);
            $result = array_merge($result , $translatedCodes);
        }        
        return $result;    
    }
    
    
}