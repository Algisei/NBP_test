<?php
    class CurrencyConversionResult {
    private $sourceCurrency;
    private $targetCurrency;
    private $amount;
    private $convertedAmount;
    private $createdAt;
    private $updatedAt;

    public function __construct($sourceCurrency, $targetCurrency, $amount, $convertedAmount) {
        $this->sourceCurrency = $sourceCurrency;
        $this->targetCurrency = $targetCurrency;
        $this->amount = $amount;
        $this->convertedAmount = $convertedAmount;
    }

    // Геттеры и сеттеры для свойств

    public function getSourceCurrency() {
        return $this->sourceCurrency;
    }

    public function setSourceCurrency($sourceCurrency) {
        $this->sourceCurrency = $sourceCurrency;
    }

    public function getTargetCurrency() {
        return $this->targetCurrency;
    }

    public function setTargetCurrency($targetCurrency) {
        $this->targetCurrency = $targetCurrency;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function getConvertedAmount() {
        return $this->convertedAmount;
    }

    public function setConvertedAmount($convertedAmount) {
        $this->convertedAmount = $convertedAmount;
    }
    
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
    
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}

?>