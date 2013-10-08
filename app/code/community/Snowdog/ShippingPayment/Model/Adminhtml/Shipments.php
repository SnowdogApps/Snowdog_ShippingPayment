<?php
/**
 * 
 * Shipment source model for adminhtml configuration
 * @author Snowdog
 *
 */
class Snowdog_ShippingPayment_Model_Adminhtml_Shipments extends Mage_Core_Model_Abstract
{
    /**
     * 
     * Prepare multipletablerates methods
     */
    protected function getMultipletableratesMethods()
    {
        /** @var Snowdog_ShippingPayment_Model_Mysql4_Multipletablerates */ 
        $ratesModel = Mage::getModel('shippingpayment/tablerates_tablerateFactory')->getResourceModel();
        $multipletableratesMethods = array();
        
        foreach ($ratesModel->getMethodCodenames() as $code)
        {
            $multipletableratesMethods[] = array ( 'label' => $code, 'value' => $code);
        }
        //Add a label        
        return array('multipletablerates_generated' => array('label' => 'Multipletablerates', 'value' => $multipletableratesMethods));        
    }
    
    
    /**
     * 
     * Returns a list of all available carierrs (active). Also includes Pw_Multipletablerates virtual carriers 
     */
    public function toOptionArray()
    {                        
        $multipletableratesMethods = $this->getMultipletableratesMethods();        
        $defaultMethods = Mage::getModel('adminhtml/system_config_source_shipping_allmethods')->toOptionArray(true);

        //get rid of an empty entry
        unset($defaultMethods[0]);        
        $methods = array_merge($multipletableratesMethods, $defaultMethods);
        return $methods;
    }
}