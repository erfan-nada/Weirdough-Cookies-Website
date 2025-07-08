<?php
require_once("Payment.php");

class PayWithVisa extends Payment {
    private $cardNumber;
    private $cardHolderName;
    private $expiryDate;
    private $cvv;

    public function setCardNumber($number) {
        if (is_numeric($number) && strlen($number) == 16) {
            $this->cardNumber = $number;
        } else {
            echo "Card number must be 16 digits.\n";
        }
    }

    public function setCardHolderName($name) {
        if (!empty($name)) {
            $this->cardHolderName = $name;
        } else {
            echo "Card holder name cannot be empty.\n";
        }
    }

    public function setExpiryDate($date) {
        if (!empty($date)) {
            $this->expiryDate = $date;
        } else {
            echo "Expiry date is required.\n";
        }
    }

    public function setCVV($cvv) {
        if (is_numeric($cvv) && strlen((string)$cvv) === 3) {
            $this->cvv = $cvv;
        } else {
            echo "CVV must be 3 digits.\n";
        }
    }

    public function getCardNumber() {
        return $this->cardNumber;
    }

    public function getCardHolderName() {
        return $this->cardHolderName;
    }

    public function getExpiryDate() {
        return $this->expiryDate;
    }

    public function getCVV() {
        return $this->cvv;
    }

    public function makePayment() {
        echo "Payment of {$this->getAmount()} made with Visa.\n";
        $this->setPaymentStatus("Paid");
    }

    public function payOnline() {
        $this->makePayment();
        echo "Online payment successful for card ending in " . substr($this->cardNumber, -4) . ".\n";
    }
}
?>
