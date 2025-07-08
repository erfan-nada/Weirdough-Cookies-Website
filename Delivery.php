<?php
class Delivery {
    private $deliveryID;
    private $deliveryAddress;
    private $deliveryDate;
    private $trackingNumber;
    private $orderID;

    public function setDeliveryID($id) {
        $this->deliveryID = $id;
    }

    public function setDeliveryAddress($address) {
        $this->deliveryAddress = $address;
    }

    public function setDeliveryDate($date) {
        $this->deliveryDate = $date;
    }

    public function setTrackingNumber($number) {
        $this->trackingNumber = $number;
    }

    public function setOrderID($orderID) {
        $this->orderID = $orderID;
    }

    public function getDeliveryID() {
        return $this->deliveryID;
    }

    public function getDeliveryAddress() {
        return $this->deliveryAddress;
    }

    public function getDeliveryDate() {
        return $this->deliveryDate;
    }

    public function getTrackingNumber() {
        return $this->trackingNumber;
    }

    public function getOrderID() {
        return $this->orderID;
    }

    public function scheduleDelivery($order) {
        $this->orderID = $order->getOrderID();
        echo "Delivery scheduled for order ID: {$this->orderID}\n";
    }

    public function updateDeliveryStatus() {
        echo "Delivery status updated for tracking #: {$this->trackingNumber}\n";
    }
}
?>
