<?php

namespace Helmab\InvoiceNumber\Traits;

use Carbon\Carbon;

trait HasInvoiceNumber
{
    public static function bootHasInvoiceNumber()
    {
        static::creating(function ($model) {
            $instance = (new static());

            $invoice_number_column = $instance->invoice_number_column ?? config('invoice-number.column');

            $model->$invoice_number_column = $instance->invoiceNumber();
        });
    }

    public function invoiceNumber(): string
    {
        $renew_by = config('invoice-number.renew_by');

        switch ($renew_by) {
            case 'max_invoice':
                return $this->invoiceNumberByMaxInvoiceNumber();
            case 'day':
                return $this->invoiceNumberByDay();
            case 'week':
                return $this->invoiceNumberByWeek();
            case 'month':
                return $this->invoiceNumberByMonth();
            case 'year':
                return $this->invoiceNumberByYear();
            case 'infinite':
            default:
                return $this->invoiceNumberByInfinite();
        }
    }

    private function invoiceNumberByMaxInvoiceNumber(): string
    {
        $invoice_number_column = $this->invoice_number_column;

        $config = config('invoice-number');
        $max_invoice = $config['max_invoice'];

        $latest_invoice = $this->newQuery()->latest()->first();
        if (!(isset($latest_invoice) && isset($latest_invoice->$invoice_number_column))) {
            $invoice_number = 1;
        } else {
            $latest_invoice_number = $this->removeAllNonNumericCharacters($latest_invoice->$invoice_number_column);
            if ($latest_invoice_number === $max_invoice) {
                $invoice_number = 1;
            } else {
                $invoice_number = $latest_invoice_number + 1;
            }
        }

        return $this->getInvoiceNumber($invoice_number);
    }

    private function invoiceNumberByInfinite(): string
    {
        return $this->getInvoiceNumber($this->newQuery()->count() + 1);
    }

    private function invoiceNumberByDay(): string
    {
        $latest_invoice_number = $this->newQuery()
            ->whereDay('created_at', Carbon::now())
            ->count();

        return $this->getInvoiceNumber($latest_invoice_number + 1);
    }

    private function invoiceNumberByWeek(): string
    {
        $latest_invoice_number = $this->newQuery()
            ->whereDay('created_at', Carbon::now())
            ->count();

        return $this->getInvoiceNumber($latest_invoice_number + 1);
    }

    private function invoiceNumberByMonth(): string
    {
        $latest_invoice_number = $this->newQuery()
            ->whereMonth('created_at', Carbon::now())
            ->count();

        return $this->getInvoiceNumber($latest_invoice_number + 1);
    }

    private function invoiceNumberByYear(): string
    {
        $latest_invoice_number = $this->newQuery()
            ->whereMonth('created_at', Carbon::now())
            ->count();

        return $this->getInvoiceNumber($latest_invoice_number + 1);
    }

    private function getInvoiceNumber($number): string
    {
        $config = config('invoice-number');

        $digits = $config['digits'];
        $prefix = $config['prefix'];
        $concatenation_symbol = $config['concatenation_symbol'];

        $invoice_number = sprintf("%0" . $digits . "d", $number);

        if (isset($prefix)) {
            $invoice_number = $prefix . $concatenation_symbol . $invoice_number;
        }

        return $invoice_number;
    }

    private function removeAllNonNumericCharacters(string $str): int
    {
        return (int)preg_replace("/\D/", "", $str);
    }
}
