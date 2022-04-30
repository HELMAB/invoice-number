<?php

return [
    'column' => 'invoice_number',

    'digits' => 10,

    'prefix' => null,

    'concatenation_symbol' => '-',

    /*
     *   RENEW BY:
     *
     * - infinite:
     * - max_invoice:
     * - day:
     * - week:
     * - month:
     * - year:
     */
    'renew_by' => 'infinite',

    'max_invoices' => 120,
];
