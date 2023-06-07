<?php
class CurrencyConverter {
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function convertCurrency($amount, $sourceCurrency, $targetCurrency) {
        // Получение курсов валют из базы данных
        $query = "SELECT rate FROM currency_rates WHERE currency_code = ? ORDER BY date DESC LIMIT 1";
        $stmt = $this->database->executeQuery($query, [$sourceCurrency]);
        $sourceRate = $stmt->fetchColumn();

        $stmt = $this->database->executeQuery($query, [$targetCurrency]);
        $targetRate = $stmt->fetchColumn();

        // Конвертация суммы
        $convertedAmount = ($amount / $sourceRate) * $targetRate;

        return $convertedAmount;
    }
}

?>