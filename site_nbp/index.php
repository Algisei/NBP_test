<?php
require_once 'config.php';
require_once 'classes/Database.php';
require_once 'classes/NBPApi.php';
require_once 'classes/CurrencyRate.php';
require_once 'classes/CurrencyRateRepository.php';
require_once 'classes/CurrencyConverter.php';
require_once 'classes/CurrencyConversionResult.php';
require_once 'classes/CurrencyConversionResultRepository.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// new Database + connection to db
$database = new Database($databaseHost, $databaseName, $databaseUsername, $databasePassword);
$database->connect();

// new NBPApi and get currency rates thru API
$nbpApi = new NBPApi('https://api.nbp.pl/api');
$currencyRates = $nbpApi->getCurrencyRates();

// new CurrencyRateDAO and save rates to db
$currencyRateRepository = new CurrencyRateRepository($database);

foreach ($currencyRates as $currencyRateData) {
    $currencyRate = new CurrencyRate(
        $currencyRateData['currency'],
        $currencyRateData['code'],
        $currencyRateData['mid'],
        date('Y-m-d H:i:s'),
        date('Y-m-d H:i:s')
    );
    $currencyRateRepository->saveCurrencyRate($currencyRate);
}

// new CurrencyConversionResultRepository
$conversionResultRepository = new CurrencyConversionResultRepository($database);

// Processing a currency conversion request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $sourceCurrency = $_POST['source_currency'];
    $targetCurrency = $_POST['target_currency'];

    // new CurrencyConverter and do the convertsion
    $currencyConverter = new CurrencyConverter($database);
    $convertedAmount = $currencyConverter->convertCurrency($amount, $sourceCurrency, $targetCurrency);

    // new CurrencyConversionResult and save conversion result to db
    $conversionResult = new CurrencyConversionResult($sourceCurrency, $targetCurrency, $amount, $convertedAmount);
    $conversionResultRepository->saveConversionResult($conversionResult);
}

// Get 10 last results
$conversionResults = $conversionResultRepository->getConversionResults(10);

// List of currencies
$currencies = array_column($currencyRates, 'code');
?>

<!DOCTYPE html>
<html>

<head>
    <title>Currency Converter</title>
    <link rel="stylesheet" type="text/css" href="style.css">
     <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>

<body>
    <h1>Currency Converter</h1>

    <?php
    // Get unique currency codes
    $currencies = array_unique(array_column($currencyRates, 'code'));
    sort($currencies); // Alphabetical sorting
    ?>

    <form method="POST" action="">
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" required min="0" step="0.01">

        <label for="source_currency">Currency from:</label>
        <select id="source_currency" name="source_currency" required>
            <?php foreach ($currencies as $currency) : ?>
                <option value="<?php echo $currency; ?>"><?php echo $currency; ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="target_currency">Currency to:</label>
        <select id="target_currency" name="target_currency" required>
            <?php foreach ($currencies as $currency) : ?>
                <option value="<?php echo $currency; ?>"><?php echo $currency; ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <input type="submit" value="Convert">
    </form>

    <h2>Conversion Results:</h2>
    <table>
        <tr>
            <th>Currency from</th>
            <th>Currency to</th>
            <th>Amount to convert</th>
            <th>Result amount</th>
            <th>Date</th>
        </tr>
        <?php foreach ($conversionResults as $result) : ?>
            <tr>
                <td><?php echo $result->getSourceCurrency(); ?></td>
                <td><?php echo $result->getTargetCurrency(); ?></td>
                <td><?php echo $result->getAmount(); ?></td>
                <td><?php echo $result->getConvertedAmount(); ?></td>
                <td><?php echo $result->getCreatedAt(); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Currency Rates:</h2>
    <table>
        <tr>
            <th>Currency</th>
            <th>Code</th>
            <th>Rate</th>
            <!--<th>Last Updated</th>-->
        </tr>
        <?php foreach ($currencyRates as $currencyRateData) : ?>
            <tr>
                <td><?php echo $currencyRateData['currency']; ?></td>
                <td><?php echo $currencyRateData['code']; ?></td>
                <td><?php echo $currencyRateData['mid']; ?></td>
                <!--<td>-->
                <!--    <?php echo isset($currencyRateData['last_updated']) ? $currencyRateData['last_updated'] : 'N/A'; ?>-->
                <!--</td>-->
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>

