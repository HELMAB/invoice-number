<?php

namespace Helmab\InvoiceNumber;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Helmab\InvoiceNumber\Skeleton\SkeletonClass
 */
class InvoiceNumberFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'invoice-number';
    }
}
