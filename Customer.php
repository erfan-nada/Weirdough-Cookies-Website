<?php
require_once("User.php");

class Customer extends User {
    private $address;
    private $orderHistory = []; 
    private $loyaltyPoints = 0;
    private $shoppingCart = []; 


    public function setAddress($address) {
        if (!empty($address)) {
            $this->address = $address;
        } else {
            echo "Address cannot be empty.\n";
        }
    }

    public function setLoyaltyPoints($points) {
        if (is_numeric($points) && $points >= 0) {
            $this->loyaltyPoints = $points;
        } else {
            echo "Loyalty points must be a non-negative number.\n";
        }
    }

    public function getAddress() {
        return $this->address;
    }

    public function getOrderHistory() {
        return $this->orderHistory;
    }

    public function getLoyaltyPoints() {
        return $this->loyaltyPoints;
    }

    public function getShoppingCart() {
        return $this->shoppingCart;
    }

    public function displayProduct($product) {
        echo "Displaying product: $product\n";
    }

    public function addToCart($product) {
        $this->shoppingCart[] = $product;
        echo "Product added to cart.\n";
    }

    public function pay($payment) {
        echo "Customer is paying...\n";
        $payment->makePayment();
    }

    public function subscribeToNewsletter() {
        echo "Customer subscribed to newsletter.\n";
    }

    public function viewCart() {
        echo "Cart contains:\n";
        print_r($this->shoppingCart);
    }

    public function removeFromCart($product) {
        $this->shoppingCart = array_filter($this->shoppingCart, fn($p) => $p !== $product);
        echo "Product removed from cart if it existed.\n";
    }

    public function addOrderToHistory($order) {
        $this->orderHistory[] = $order;
        echo "Order added to history.\n";
    }
}
?>
