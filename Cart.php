<?php
class Cart {
    private $cartID;
    private $cartItems = []; 
    private $totalPrice = 0.0;

    // Setters
    public function setCartID($id) {
        if (!empty($id)) {
            $this->cartID = $id;
        } else {
            echo "Cart ID cannot be empty.\n";
        }
    }

    public function setTotalPrice($price) {
        if (is_numeric($price) && $price >= 0) {
            $this->totalPrice = $price;
        } else {
            echo "Total price must be a non-negative number.\n";
        }
    }


    public function getCartID() {
        return $this->cartID;
    }

    public function getCartItems() {
        return $this->cartItems;
    }

    public function getTotalPrice() {
        return $this->totalPrice;
    }


    public function addProduct($product, $price = 0) {
        $this->cartItems[] = $product;
        $this->totalPrice += $price;
        echo "Product added to cart. Total is now: {$this->totalPrice}\n";
    }

    public function removeProduct($product, $price = 0) {
        $initialCount = count($this->cartItems);
        $this->cartItems = array_filter($this->cartItems, fn($p) => $p !== $product);
        $removedCount = $initialCount - count($this->cartItems);
        $this->totalPrice -= ($price * $removedCount);
        echo "Removed product(s) from cart. Total is now: {$this->totalPrice}\n";
    }

    public function showCart() {
        echo "Cart ID: {$this->cartID}\n";
        echo "Items in cart:\n";
        print_r($this->cartItems);
        echo "Total price: {$this->totalPrice}\n";
    }
}
?>
