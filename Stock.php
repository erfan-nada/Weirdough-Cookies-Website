<?php
class Stock {
    private $stockID;
    private $productID;
    private $quantity;
    private $lastUpdated;

    public function setStockID($id) {
        $this->stockID = $id;
    }

    public function setProductID($pid) {
        $this->productID = $pid;
    }

    public function setQuantity($qty) {
        if (is_numeric($qty) && $qty >= 0) {
            $this->quantity = $qty;
        } else {
            echo "Quantity must be a non-negative number.";
        }
    }

    public function setLastUpdated($date) {
        $this->lastUpdated = $date;
    }

    public function getStockID() {
        return $this->stockID;
    }

    public function getProductID() {
        return $this->productID;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getLastUpdated() {
        return $this->lastUpdated;
    }
}
?>
