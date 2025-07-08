<?php
class Order {
    private $orderID;
    private $orderItems = []; 
    private $totalPrice = 0;
    private $pickupID;
    private $deliveryID;
    private $pickup; 
    private $delivery;

    public function setOrderID($id) {
        if (!empty($id)) {
            $this->orderID = $id;
        } else {
            echo "Order ID cannot be empty.\n";
        }
    }

    public function setTotalPrice($price) {
        if (is_numeric($price) && $price >= 0) {
            $this->totalPrice = $price;
        } else {
            echo "Invalid total price.\n";
        }
    }

    public function setPickup($pickup) {
        $this->pickup = $pickup;
    }

    public function setDelivery($delivery) {
        $this->delivery = $delivery;
    }

    public function getOrderID() {
        return $this->orderID;
    }

    public function getOrderItems() {
        return $this->orderItems;
    }

    public function getTotalPrice() {
        return $this->totalPrice;
    }

    public function getPickup() {
        return $this->pickup;
    }

    public function getDelivery() {
        return $this->delivery;
    }

    public function confirmOrder($products) {
        $this->orderItems = $products;
        echo "Order confirmed with " . count($products) . " items.\n";
    }

    public function trackOrder() {
        echo "Tracking order ID: {$this->orderID}\n";
    }

    public function selectDeliveryOption() {
        echo "Delivery option selected for order ID: {$this->orderID}\n";
    }
}
?>
