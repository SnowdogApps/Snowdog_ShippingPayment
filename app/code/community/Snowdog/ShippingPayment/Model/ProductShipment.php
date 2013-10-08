<?php
/**
 * 
 * Handling product shipment depedencies.
 * @author Snowdog
 *
 */
class Snowdog_ShippingPayment_Model_ProductShipment extends Mage_Core_Model_Abstract
{
    /**
     * 
     * Is product shipment verification enabled
     * @return true|false
     */
    public function getEnabled() {
        return Mage::getModel('shippingpayment/config')->getConfigData('productshipment','enabled');
    }
    
    /**
     * 
     * Gets restricted shipments from an item collection
     * @param $itemCollection
     * @return array 
     */
    public function getRestrictedShipments($itemCollection) {
        $attributeCode = Mage::getSingleton('shippingpayment/config')->getAttributeCode();
        $result = array();
        foreach ($itemCollection as $item) {
            $productModel = $item->getProduct();
            $allowedShipments = $productModel->load($productModel->getId())->getData($attributeCode);
            if(!empty($allowedShipments))
            {
                if(empty($result))
                    $result = $allowedShipments;
                else 
                    $result = array_merge($result, $allowedShipments);
            }
        }        
        //Translate multipletablerates codenames into magento method_codes
        $codes = Mage::getModel('shippingpayment/tablerates_translator')->translateKeys($result);
 
        return $codes;
    }
    
    
}