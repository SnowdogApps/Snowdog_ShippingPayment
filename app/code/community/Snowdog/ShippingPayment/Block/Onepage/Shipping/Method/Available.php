<?php
/**
 * 
 * Block provides a list of shipping methods (rates) for the onepage checkout process 
 * @author Snowdog
 *
 */
class Snowdog_ShippingPayment_Block_Onepage_Shipping_Method_Available extends Mage_Checkout_Block_Onepage_Shipping_Method_Available
{
      
    public function getShippingRates()
    {
      $restrictionsModel = Mage::getModel('shippingpayment/shipmentRestrictions');
      $restrictedCarriers = $restrictionsModel->getRestrictedCarriersMethodCodes();
      $productShipmentModel = Mage::getModel('shippingpayment/productShipment');
      $productShipmentRestrictions = $productShipmentModel->getRestrictedShipments($this->getQuote()->getItemsCollection());
      
      $restrictedShipments = array();
      
      $rates = parent::getShippingRates();
      $grandTotal = $this->getQuote()->getGrandTotal();
      if((!$restrictionsModel->getEnabled() || !$restrictionsModel->isActive($grandTotal)) && (!$productShipmentModel->getEnabled()))
          return $rates;
          
      if($restrictionsModel->getEnabled() && $restrictionsModel->isActive($grandTotal) && !empty($restrictedCarriers))
          $restrictedShipments = array_merge($restrictedShipments, $restrictedCarriers);    
          
      if($productShipmentModel->getEnabled() && !empty($productShipmentRestrictions))
          $restrictedShipments = array_merge($restrictedShipments, $productShipmentRestrictions);
          
          

      $result = array();
      foreach ($rates as $groupName => $groupedRates)
          foreach($groupedRates as $rate){              
              if(!in_array($rate->getCode(), $restrictedShipments))
              {
                  if(!isset($result[$groupName]))
                      $result[$groupName] = array();
                  $result[$groupName][] = $rate;
              }              
          }

      return $result;
    }
}
