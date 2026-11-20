# marktmentor/api

Official PHP SDK for the [MarktMentor Public API](https://api.marktmentor.nl):
bol product research and your own store data. Requires PHP 8.1 or later.

```sh
composer require marktmentor/api guzzlehttp/guzzle
```

The SDK sends its requests with a PSR-18 HTTP client. It finds an installed one
by itself; Guzzle is the usual choice. Without a PSR-18 client, Composer stops
with "No PSR-18 clients found".

Try it without an account with the public test key `mm_test_demo`: it answers
every endpoint with fixed example data (product `9300000138905032`, niche
`6797`), free. See <https://api.marktmentor.nl/guides/test-key>.

```php
use MarktMentor\MarktMentorClient;

$demo = new MarktMentorClient(token: 'mm_test_demo');
echo $demo->products->get('9300000138905032')?->data->title, "\n";
```

```php
use MarktMentor\Exceptions\MarktMentorApiException;
use MarktMentor\MarktMentorClient;
use MarktMentor\Products\Requests\ListProductsRequest;
use MarktMentor\Products\Requests\SalesHistoryProductsRequest;
use MarktMentor\Types\AllowanceError;

$client = new MarktMentorClient(token: getenv('MARKTMENTOR_API_KEY'));

try {
    foreach ($client->products->list(new ListProductsRequest(['search' => 'drinkfles'])) as $product) {
        echo $product->productCode, ' ', $product->title, "\n"; // all pages
    }
    $history = $client->products->salesHistory(
        'ean:8712345678901',
        new SalesHistoryProductsRequest(['period' => '1Y', 'interval' => 'month']),
    );
} catch (MarktMentorApiException $error) {
    if ($error->getCode() === 402) {
        echo 'Allowance used up: ', AllowanceError::fromJson($error->getBody())->code, "\n";
    }
}
```

Spending is limited by your account setting, not by the SDK: extra usage above
the bundle is off by default, and the organization owner sets a monthly maximum
in the dashboard. A used-up allowance gives HTTP 402; the body is an
`AllowanceError` whose `code` is `bundle_exhausted`, `overage_limit_reached` or
`free_quota_exhausted`. The generated reference is in `reference.md`.
