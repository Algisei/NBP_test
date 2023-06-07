<?php
class CurrencyRate {
    private $currency;
    private $currency_code;
    private $rate;
    private $created_at;
    private $updated_at;

    public function __construct($currency, $currency_code, $rate, $created_at, $updated_at) {
        $this->currency = $currency;
        $this->currency_code = $currency_code;
        $this->rate = $rate;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    // Геттеры и сеттеры для свойств

    public function getCurrency() {
        return $this->currency;
    }

    public function setCurrency($currency) {
        $this->currency = $currency;
    }

    public function getCurrencyCode() {
        return $this->currency_code;
    }

    public function setCurrencyCode($currency_code) {
        $this->currency_code = $currency_code;
    }

    public function getRate() {
        return $this->rate;
    }

    public function setRate($rate) {
        $this->rate = $rate;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt() {
        return $this->updated_at;
    }

    public function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }
}


?>