<?php
/**
 * 
 * Handles the creation of a proper resource model for tablerates (used for codenames translation) 
 * @author Snowdog
 *
 */
class Snowdog_ShippingPayment_Model_Tablerates_TablerateFactory extends Mage_Core_Model_Abstract
{
    protected $supportedModules = array( 'Pw_Multipletablerates' => 'multipletablerates',
                                         'Webshopapps_Matrixrate' => 'matrixrates',                                           
									    );
    
    /**
     * 
     * Supported modules 
     * @return array array('title' => 'resource class name')
     */									    
    public function getSupportedModules()
    {
        return $this->supportedModules;
    }							
    		    
    /**
     * Return an apropriate resource model, based on installed extensions (user choice)
     * @return Snowdog_ShippingPayment_Model_Mysql4_Default  
     */
    public function getResourceModel()
    {
        $config = Mage::getModel('shippingpayment/config');
        $class = $config->getConfigData('tablerates', 'module');
        if(!empty($class) && $config->getConfigData('tablerates', 'enabled'))
        {
            $module = Mage::getResourceModel('shippingpayment/'.$class);
            if($module->checkIfModuleInstalled())
              return $module;
        }
        return Mage::getResourceModel('shippingpayment/default');
    }
}
