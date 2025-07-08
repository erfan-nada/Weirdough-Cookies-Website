<?php
require_once("User.php");

class Admin extends User {
    private $adminID;
    private $adminPassword;
    private $role;

    public function setAdminID($id) {
        if (!empty($id)) {
            $this->adminID = $id;
        } else {
            echo "Invalid Admin ID.\n";
        }
    }

    public function setAdminPassword($password) {
        if (strlen($password) >= 6) {
            $this->adminPassword = $password;
        } else {
            echo "Admin password must be at least 6 characters long.\n";
        }
    }

    public function setRole($role) {
        if (!empty($role)) {
            $this->role = $role;
        } else {
            echo "Role cannot be empty.\n";
        }
    }

    public function getAdminID() {
        return $this->adminID;
    }

    public function getAdminPassword() {
        return $this->adminPassword;
    }

    public function getRole() {
        return $this->role;
    }

    public function managePromotionsAndLoyaltyRewards($promotionData) {
        echo "Managing promotion: $promotionData\n";
    }

    public function updateStock($stock) {
        echo "Updating stock: $stock\n";
    }

    public function addProduct($product) {
        echo "Adding product: $product\n";
    }

    public function removeProduct($productID) {
        echo "Removing product with ID: $productID\n";
    }

    public function updateProductInfo($productID) {
        echo "Updating product info for ID: $productID\n";
    }
}
?>
