<?php

class Snowdog_ShippingPayment_Model_Observer {
	public function verifyMethods(Varien_Event_Observer $observer) {
		$event = $observer->getEvent();
		$order = $event->getOrder();
		if(!$order->getId()) {
			$shippingMethod = $order->getShippingMethod();
			$shippingDescription = $order->getShippingDescription();
			$paymentMethod = $order->getPayment()->getMethod();
			$paymentLabel = $order->getPayment()->getMethodInstance()->getTitle();
			$allowed = Mage::getStoreConfig('shippingpayment/shippingconditions/enabled_payments');
			$allowed = json_decode($allowed, true);
			if(isset($allowed[$shippingMethod]) && !in_array($paymentMethod, $allowed[$shippingMethod])) {
				$message = Mage::getStoreConfig('shippingpayment/shippingconditions/message');
				$message = str_replace('{payment}', $paymentLabel, $message);
				$message = str_replace('{shipping}', $shippingDescription, $message);
				throw new Exception($message);
			}
		}
	}
}
