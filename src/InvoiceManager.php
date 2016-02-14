<?php

namespace src;


class InvoiceManager
{
    private $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function loadInvoice($invoiceId)
    {
        $sql = 'SELECT * FROM invoice WHERE invoice_id = :invoice_id';
        $statement = $this->db->prepare($sql);
        $statement->execute(array(':invoice_id' => $invoiceId));
        $statement->setFetchMode(\PDO::FETCH_CLASS,'Invoice');
        $invoice = $statement->fetch();

        $sql = 'SELECT * FROM invoice_item WHERE invoice_id = :invoice_id';
        $statement = $this->db->prepare($sql);
        $statement->execute(array(':invoice_id' => $invoiceId));
        $statement->setFetchMode(\PDO::FETCH_CLASS,'InvoiceItem');

        while($invoiceItem = $statement->fetch()){
            $invoice->addInvoiceItem($invoiceItem);
        }

        return $invoice;
    }
}