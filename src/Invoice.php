<?php

namespace src;


class Invoice
{
    const STATUS_ISSUED = 1;
    const STATUS_PAID = 2;
    const STATUS_CANCELLED = 3;

    public $invoice_id;
    public $customer_id;
    public $status_id;
    public $price_total = 0;
    public $date_created;

    /**
     * @var InvoiceItem[]
     */
    public $invoiceItems = array();

    /**
     * @param InvoiceItem $item
     */
    public function addInvoiceItem(InvoiceItem $item)
    {
        $this->invoiceItems[$item->product_id] = $item;
    }

    /**
     * @param InvoiceItem $item
     */
    public function removeInvoiceItem(InvoiceItem $item)
    {
        unset($this->invoiceItems[$item->product_id]);
    }

    public function setTotals()
    {
        $this->price_total = 0;
        foreach($this->invoiceItems as $item){
            $this->price_total += $item->price * $item->quantity;
        }
    }
}