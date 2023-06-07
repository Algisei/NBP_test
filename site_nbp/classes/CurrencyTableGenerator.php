<?php
class CurrencyTableGenerator {
    public function generateCurrencyTable($currencyRates) {
        if (empty($currencyRates)) {
            return "No currency rates found.";
        }

        $table = '<table>
                    <tr>
                        <th>Currency Code</th>
                        <th>Rate</th>
                        <th>Table Type</th>
                        <th>Effective Date</th>
                    </tr>';

        foreach ($currencyRates as $rate) {
            $table .= '<tr>';
            $table .= '<td>' . $rate['currency_code'] . '</td>';
            $table .= '<td>' . $rate['rate'] . '</td>';
            $table .= '<td>' . $rate['table_type'] . '</td>';
            $table .= '<td>' . $rate['effective_date'] . '</td>';
            $table .= '</tr>';
        }

        $table .= '</table>';

        return $table;
    }
}

?>