# Invoice Number for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/helmab/invoice-number.svg?style=flat-square)](https://packagist.org/packages/helmab/invoice-number)
[![Total Downloads](https://img.shields.io/packagist/dt/helmab/invoice-number.svg?style=flat-square)](https://packagist.org/packages/helmab/invoice-number)

Generate the invoice number for Laravel application.

## Installation

You can install the package via composer:

```bash
composer require helmab/invoice-number
```

Publish `invoice-number.php` configuration file:

```bash
php artisan vendor:publish --provider="Helmab\InvoiceNumber\InvoiceNumberServiceProvider"
```

## Usage

```php

use Helmab\InvoiceNumber\Traits\HasInvoiceNumber;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model {

    use HasInvoiceNumber;

    protected $invoice_number_column = 'invoice_number';

    protected $fillable = [
        'invoice_number'
    ];
}
```

### Get Latest Invoice Number

```php
namespace App\Http\Controllers;

use Helmab\InvoiceNumber\InvoiceNumber;

class InvoiceController extends Controller {

    public function getLatestInvoiceNumber()
    {
        return (new InvoiceNumber())->invoiceNumber();
    }
    
}
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email mabhelitc@gmail.com instead of using the issue tracker.

## Credits

-   [Mab Hel](https://github.com/helmab)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
