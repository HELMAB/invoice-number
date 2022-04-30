<?php

namespace Helmab\InvoiceNumber;

use Helmab\InvoiceNumber\Traits\HasInvoiceNumber;

class InvoiceNumber
{
    use HasInvoiceNumber;

    public function __toString()
    {
        return $this->invoiceNumber();
    }
}
