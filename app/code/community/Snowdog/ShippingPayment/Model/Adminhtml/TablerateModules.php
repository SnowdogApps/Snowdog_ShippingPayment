<?php
/**
 * 
 * Supported tablerates modules source model for adminhtml configuration
 * @author Snowdog
 *
 */
class Snowdog_ShippingPayment_Model_Adminhtml_TablerateModules extends Mage_Core_Model_Abstract
{
    /**
     * 
     * Returns a list of all supported modules 
     */
    public function toOptionArray()
    {                        
        $supported = Mage::getModel('shippingpayment/tablerates_tablerateFactory')->getSupportedModules();
        $result = array();
        foreach ($supported as $moduleName => $className)
        {
            $result[] = array('label' => $moduleName, 'value' => $className);
        }
        return $result;
    }
}