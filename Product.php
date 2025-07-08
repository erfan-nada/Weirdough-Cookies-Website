<?php
class Product {
    private $productID;
    private $name;
    private $description;
    private $price;
    private $stock;

    public function setProductID($id) {
        if (!empty($id)) {
            $this->productID = $id;
        } else {
            echo "Invalid product ID.\n";
        }
    }

    public function setName($name) {
        if (strlen($name) >= 2) {
            $this->name = $name;
        } else {
            echo "Product name must be at least 2 characters long.\n";
        }
    }

    public function setDescription($desc) {
        if (!empty($desc)) {
            $this->description = $desc;
        } else {
            echo "Description cannot be empty.\n";
        }
    }

    public function setPrice($price) {
        if (is_numeric($price) && $price >= 0) {
            $this->price = $price;
        } else {
            echo "Price must be a non-negative number.\n";
        }
    }

    public function setStock($stock) {
        if (is_numeric($stock) && $stock >= 0) {
            $this->stock = $stock;
        } else {
            echo "Stock must be a non-negative number.\n";
        }
    }


    public function getProductID() {
        return $this->productID;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getStock() {
        return $this->stock;
    }


    public function reviewProduct() {
        echo "Reviewing product: {$this->name}\n";
    }

    public function searchProduct() {
        echo "Searching for product: {$this->name}\n";
    }

    public function customizeProduct() {
        echo "Customizing product: {$this->name}\n";
    }
}
?>
