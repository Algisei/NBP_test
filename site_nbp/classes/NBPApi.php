<?php
class NBPApi {
    private $apiUrl;

    public function __construct($apiUrl) {
        $this->apiUrl = $apiUrl;
    }

    public function getCurrencyRates() {
        $url = $this->apiUrl . "/exchangerates/tables/a";
        $response = @file_get_contents($url);

        if ($response !== false) {
            $data = json_decode($response, true);
            if (isset($data[0]['rates'])) {
                return $data[0]['rates'];
            }
        }

        return [];
    }
}
?>