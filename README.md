**Introduction**

This package seeks to help php developers implement the various Mpesa APIs without much hustle. It is based on the REST API whose documentation is available on https://www.flexpay.co.ke/flexpay-api-documentation.
 
**Installation using composer**<br>
`composer require evans-wanguba/flexpay-api`<br>


**Configuration**<br>
At your project root, create a .env file and in it set the consumer key and consumer secret as follows   
`FLEXPAY_API_KEY= [consumer key]` <br>
`FLEXPAY_API_SECRET=[consumer secret]`<br>
`FLEXPAY_TIMEOUT=[timeout]`<br>
`FLEXPAY_ENV=[production or staging]`<br>


**Usage**

web.php:

```php
use Illuminate\Support\Facades\Route;
use EvansWanguba\Flexpay\Http\Controllers\WebhookController;

Route::post('flexpay/webhook', [WebhookController::class, 'handle']);
```

WebhookController.php

```php
namespace EvansWanguba\Flexpay\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Flexpay recommends quick 2xx responses and async processing.
        // Log and push to queue for heavy work.
        \Log::info('Flexpay webhook received', $request->all());
        // example: validate minimal payload
        $payload = $request->all();
        // You should process asynchronously (dispatch job) - but respond immediately:
        return response()->json(['status' => 'ok'], 200);
    }
}
```


**Publishing**

Add package to composer or use path repository.

`Run php artisan vendor:publish --provider="EvansWanguba\Flexpay\FlexpayServiceProvider" --tag="flexpay-config" to publish config.`

Set .env keys as shown earlier.

**Example**
```php
use Flexpay; // facade

public function bookItem()
{
    $resp = \Flexpay::book([
        'productName' => 'Washing Machine',
        'productPrice' => 200,
        'phoneNumber' => '+254712345678',
        'productDeposit' => 50,
        'bookingDays' => 45,
        'paymentType' => 'MPESA',
        'email' => 'jane@example.com',
        'firstName' => 'Jane',
        'lastName' => 'Doe',
    ]);

    return response()->json($resp);
}
```

## Support
See `sample.php` for more examples. The API documentation is also available in the `docs` folder.
Or email me at `ewanguba@gmail.com`