<?php
/**
 * 
 * Backend configuration form element. Allows user to enter certain shipment conditions 
 * @author Snowdog
 *
 */
class Snowdog_ShippingPayment_Block_Adminhtml_ShipmentConditions extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /**
     * 
     * Retrieves active payements list from the magento configuration
     * 
     */
    protected function getActivePayments()
    {
        $payments = Mage::getSingleton('payment/config')->getActiveMethods();      

        $methods = array();  
        foreach ($payments as $paymentCode=>$paymentModel) {
            $paymentTitle = Mage::getStoreConfig('payment/'.$paymentCode.'/title');
            $methods[$paymentCode] = array(
                'label'   => $paymentTitle,
                'value' => $paymentCode               
            );
        }
        
        return $methods;
    }
    
    /**
     * 
     * Displays the controls set
     *    
     */
    public function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    { 
        $currentValue = $element->getValue(); //Config value
        $html = '';
       
        $payments = $this->getActivePayments();
        
        $shipments = Mage::getModel('shippingpayment/adminhtml_shipments')->toOptionArray();
        
        foreach ($shipments as $shipment)
        {
            foreach($shipment['value'] as $method)
            {                
                $config = array ( 
                    'name' => 'groups[shippingconditions][fields][enabled_payments]['.$method['value'].']', 
                    'label' => $method['label'], 
                    'values' => $this->getActivePayments(),                    
                );
                //Fill the forms with current value
                if(isset($currentValue[$method['value']])) 
                    $config['value'] = $currentValue[$method['value']];               
                $html .= $element->addField($method['value'], 'multiselect', $config)->toHtml();
            }
        }
        
        return $html;
    }
    
  
}