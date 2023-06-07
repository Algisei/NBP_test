<?php
class CurrencyConversionResultRepository {
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function saveConversionResult($conversionResult) {
        $query = "INSERT INTO conversion_results (source_currency, target_currency, amount, converted_amount, created_at, updated_at)
                  VALUES (?, ?, ?, ?, NOW(), NOW())";
        $params = [
            $conversionResult->getSourceCurrency(),
            $conversionResult->getTargetCurrency(),
            $conversionResult->getAmount(),
            $conversionResult->getConvertedAmount()
        ];

        return $this->database->executeQuery($query, $params);
    }

    public function getConversionResults()
{
    $query = "SELECT * FROM conversion_results ORDER BY id DESC LIMIT 10";
    $stmt = $this->database->executeQuery($query);

    $results = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result = new CurrencyConversionResult(
            $row['source_currency'],
            $row['target_currency'],
            $row['amount'],
            $row['converted_amount']
        );
        $result->setCreatedAt($row['created_at']);
        $result->setUpdatedAt($row['updated_at']); // Используйте метод setUpdatedAt
        $results[] = $result;
    }

    return $results;
}
}
?>