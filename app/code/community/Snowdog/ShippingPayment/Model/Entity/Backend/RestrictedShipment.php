<?php
/**
 * 
 * Backend model for restricted_shipments attribute. Handles saving/loading to the database 
 * @author Snowdog
 *
 */
class Snowdog_ShippingPayment_Model_Entity_Backend_RestrictedShipment extends Mage_Eav_Model_Entity_Attribute_Backend_Abstract 
{
	/**
	 * 
     * Prepeares the data to be saved in the database
     */
    public function beforeSave($object){
        $attrCode = $this->getAttribute()->getAttributeCode();
        $value = $object->getData($attrCode);
        
        if(empty($value) || in_array('none', $value)) //Check if we should clear the option list 
            $value = array();
            
        $json = json_encode($value);        
        $object->setData($attrCode, $json);
        
    }
    
    /**
     * 
     * Decodes the data in the database, so it can be displayed in the admin form
     */
    public function afterLoad($object){
        $attrCode = $this->getAttribute()->getAttributeCode();
        $value = $object->getData($attrCode);
        $decodedValue = json_decode($value,true); //decode as assoc array
        $object->setData($attrCode, $decodedValue);        
    }
}