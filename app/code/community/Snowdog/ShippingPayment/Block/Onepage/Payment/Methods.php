<?php
class Snowdog_ShippingPayment_Block_Onepage_Payment_Methods extends Mage_Checkout_Block_Onepage_Payment_Methods {
  
  public function isDisabled($paymentCode) {
    $shippingMethodCode = $this->getQuote()->getShippingAddress()->getShippingMethod();
    
    $disabled = $disabledClass = null;
    
    $conditionsModel = Mage::getModel('shippingpayment/shipmentConditions');
    $allowedCond = $conditionsModel->getShipmentConditions();
        
    if (array_key_exists($shippingMethodCode, $allowedCond)) {
      if ( ! in_array($paymentCode, $allowedCond[$shippingMethodCode])) {
        return true;
      }
    }
    $shippingMethodCode = 's_method_' . $shippingMethodCode;
	
	if (array_key_exists($shippingMethodCode, $allowedCond)) {
      if ( ! in_array($paymentCode, $allowedCond[$shippingMethodCode])) {
        return true;
      }
    }
    return false;
  }
  
  // end class
}
