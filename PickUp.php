<?php
class PickUp {
    private $pickupID;
    private $pickupLocation;
    private $scheduledTime;
    private $isReady = false;
    private $orderID;

    public function setPickupID($id) {
        $this->pickupID = $id;
    }

    public function setPickupLocation($location) {
        $this->pickupLocation = $location;
    }

    public function setScheduledTime($time) {
        $this->scheduledTime = $time;
    }

    public function setOrderID($orderID) {
        $this->orderID = $orderID;
    }

    public function getPickupID() {
        return $this->pickupID;
    }

    public function getPickupLocation() {
        return $this->pickupLocation;
    }

    public function getScheduledTime() {
        return $this->scheduledTime;
    }

    public function getIsReady() {
        return $this->isReady;
    }

    public function getOrderID() {
        return $this->orderID;
    }

    public function schedulePickup($order) {
        $this->orderID = $order->getOrderID();
        echo "Pickup scheduled for order ID: {$this->orderID}\n";
    }

    public function markAsReady() {
        $this->isReady = true;
        echo "Pickup ID {$this->pickupID} is ready for collection.\n";
    }
}
?>
