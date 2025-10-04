# Fride PHP SDK

Простой PHP SDK для интеграции с сервисом Fride без внешних зависимостей (кроме cURL и стандартного JSON), поддерживает использование через Composer и через обычный require.

## Установка через Composer

```bash
composer require fride/php-sdk
```

## Подключение через require без Composer

```php
require __DIR__ . '/php-sdk/src/autoload.php';
```

## Быстрый старт с общим клиентом

```php
use Fride\Bootstrap;
use Fride\Schemas\InvoiceCreateRequest;
use Fride\Schemas\InvoiceGetInfoRequest;
use Fride\Schemas\PayoffCreateRequest;
use Fride\Schemas\PayoffGetInfoRequest;
use Fride\Schemas\MerchantGetServicesRequest;

// {YOUR_API_KEY}, {BASE_URL}, {timeoutSeconds, default: 30}, {connectTimeoutSeconds, default: 10}
$fride = new Bootstrap('YOUR_API_KEY', 'https://api.fride.io');

// Создание заказа
$createInvReq = InvoiceCreateRequest::fromArray([
  'merchant_id' => '48ceb004-06b1-4ed6-9b61-aa8ad0dc5ae0',
  'order_id' => 'my_order_id_1',
  'amount' => 10.28,
  'currency' => 'USD',
  'comment' => 'Order #1',
]);
$invoice = $fride->invoices()->create($createInvReq);

// Получение информации о заказе
$getInfoInvReq = InvoiceGetInfoRequest::fromArray([
  'merchant_id' => '48ceb004-06b1-4ed6-9b61-aa8ad0dc5ae0',
  'order_id' => 'my_order_id_1',
]);
$infoInv = $fride->invoices()->getInfo($getInfoInvReq);

// Получение баланса
$balance = $fride->accounts()->getBalance();

// Получение доступных методов оплаты
$merchantServices = $fride->services()->getMerchantServices(MerchantGetServicesRequest::fromArray([
  'merchant_id' => '48ceb004-06b1-4ed6-9b61-aa8ad0dc5ae0',
]));

// Создание выплаты
$createPayoffReq = PayoffCreateRequest::fromArray([
  'service' => 'tron',
  'wallet_to' => 'Txxxx',
  'amount' => 1000.50,
  'subtract' => 2,
  'order_id' => 'Payoff-1',
]);
$payoff = $fride->payoffs()->create($createPayoffReq);

// Получение информации о выплате
$infoPayoff = $fride->payoffs()->getInfo(PayoffGetInfoRequest::fromArray([
  'payoff_id' => '24f48f28-4b02-42c7-ad0e-ab14ec7a7d05'
]));

// Получение курса валют
$rates = $fride->payoffs()->getRates();

// Получение списка доступных банков для выплаты через СБП
$sbpBanks = $fride->payoffs()->getSbpBanks();

// Получение доступных методов выплат
$payoffServices = $fride->services()->getPayoffServices();
```

## Использование без общего клиента

```php
use Fride\Client;
use Fride\Api\Payoffs;
use Fride\Schemas\PayoffGetInfoRequest;

$payoffsClient = new Fride\Api\Payoffs(
	new Client('YOUR_API_KEY', 'https://api.fride.io')
);

// Получение информации о выплате
$payoffInfo = $payoffsClient->getInfo(PayoffGetInfoRequest::fromArray([
  'payoff_id' => '24f48f28-4b02-42c7-ad0e-ab14ec7a7d05'
]));
```

## Обработка ошибок
- Если HTTP статус не 200 — кидается `Fride\Exceptions\FrideApiException`.
  - Если в теле ответа есть поле `error` (string) — его текст попадёт в исключение.
  - Иначе будет сообщение: «Неизвестная ошибка».
- Сетевые и транспортные ошибки — `Fride\Exceptions\FrideHttpException`.

### Доступ к контексту ошибки
```php
use Fride\Exceptions\FrideApiException;
use Fride\Exceptions\FrideHttpException;

try {
  $balance = $fride->accounts()->getBalance();
} catch (FrideApiException $e) {
  $e->getStatusCode();     // HTTP статус
  $e->getUrl();            // URL запроса
  $e->getMethod();         // Метод (GET/POST)
  $e->getResponseBody();   // Сырое тело ответа
  $e->getResponseData();   // Декодированный JSON (если есть)
  $e->getHeaders();        // Ответные заголовки (map lowercase)
  $e->getRequestBody();    // Тело отправленного запроса (если было)
} catch (FrideHttpException $e) {
  $e->getCurlCode();       // Код ошибки cURL
  $e->getUrl();
  $e->getMethod();
}
```

## Webhook подпись
```php
use Fride\Webhook\Signature;

$isValid = Signature::check($rawJsonBody, $headerSignature, $secretKey);
```

## Требования
- PHP >= 7.4
- Расширение cURL
