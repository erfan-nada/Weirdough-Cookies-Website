<?php
require_once("Payment.php");

class PayInCash extends Payment {
    private $cashReceived;
    private $changeGiven;

    public function setCashReceived($cash) {
        if (is_numeric($cash) && $cash >= 0) {
            $this->cashReceived = $cash;
        } else {
            echo "Cash received must be a non-negative number.\n";
        }
    }

    public function setChangeGiven($change) {
        if (is_numeric($change) && $change >= 0) {
            $this->changeGiven = $change;
        } else {
            echo "Change given must be a non-negative number.\n";
        }
    }

    public function getCashReceived() {
        return $this->cashReceived;
    }

    public function getChangeGiven() {
        return $this->changeGiven;
    }

    public function makePayment() {
        echo "Payment of {$this->getAmount()} made in cash.\n";
        $this->setPaymentStatus("Paid");
    }

    public function payCash() {
        $this->makePayment();
        $this->setChangeGiven($this->cashReceived - $this->getAmount());
        echo "Change given: {$this->getChangeGiven()}\n";
    }
}
?>
