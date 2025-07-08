<?php
abstract class Payment {
    private $amount;
    private $paymentStatus;
    private $paymentDate;

    public function setAmount($amount) {
        if (is_numeric($amount) && $amount >= 0) {
            $this->amount = $amount;
        } else {
            echo "Amount must be a non-negative number.\n";
        }
    }

    public function setPaymentStatus($status) {
        if (!empty($status)) {
            $this->paymentStatus = $status;
        } else {
            echo "Payment status cannot be empty.\n";
        }
    }

    public function setPaymentDate($date) {
        if (!empty($date)) {
            $this->paymentDate = $date;
        } else {
            echo "Payment date is required.\n";
        }
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getPaymentStatus() {
        return $this->paymentStatus;
    }

    public function getPaymentDate() {
        return $this->paymentDate;
    }

    abstract public function makePayment();

    public function purchaseGiftCard() {
        echo "Gift card purchased with amount {$this->amount}.\n";
    }
}
?>
