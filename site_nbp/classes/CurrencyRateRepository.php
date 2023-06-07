<?php
class CurrencyRateRepository {
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

   public function saveCurrencyRate($currencyRate) {
    $query = "INSERT INTO currency_rates (currency, currency_code, rate, date) VALUES (?, ?, ?, ?)";
    $params = [
        $currencyRate->getCurrency(),
        $currencyRate->getCurrencyCode(),
        $currencyRate->getRate(),
        $currencyRate->getCreatedAt()
    ];

    return $this->database->executeQuery($query, $params);
}

}
?>