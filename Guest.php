<?php
class Guest {
    private $guestID;
    private $searchHistory = [];

    public function setGuestID($id) {
        $this->guestID = $id;
    }

    public function getGuestID() {
        return $this->guestID;
    }

    public function getSearchHistory() {
        return $this->searchHistory;
    }

    public function searchProduct($product) {
        $this->searchHistory[] = $product;
        echo "Guest searching for: $product";
    }

    public function findNearbyStores() {
        echo "Finding nearby stores...";
    }

    public function contactStore() {
        echo "Contacting store...";
    }
}
?>
