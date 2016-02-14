<?php

namespace src;


class InvoiceManager
{
    private $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * @param int $invoiceId
     * @return mixed
     */
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

    /**
     * @param Invoice $invoice
     * @param Customer $customer
     * @param array $productsArray
     */
    public function raiseInvoice(Invoice $invoice, Customer $customer, array $productsArray)
    {
        $invoice->customer_id = $customer->customer_id;
        $invoice->status_id = Invoice::STATUS_ISSUED;
        $invoice->date_created = new \DateTime();

        foreach($productsArray as $productItem)
        {
            $product = $productItem['product'];
            $quantity = $productItem['quantity'];

            $invoiceItem = new InvoiceItem();
            $invoiceItem->product_id = $product->product_id;
            $invoiceItem->quantity = $quantity;
            $invoiceItem->price = $product->price;

            $invoice->addInvoiceItem($invoiceItem);
            $invoice->setTotals();
            $this->storeInvoice($invoice);
        }
    }

    /**
     * @param Invoice $invoice
     */
    protected function storeInvoice(Invoice $invoice)
    {
        $sql = 'INSERT INTO invoice (status_id,customer_id,price_total, date_created) VALUES (:status, :customer, :price, :date_created)';
        $stm = $this->db->prepare($sql);
        $stm->execute(array(':status' => $invoice->status_id, ':customer' => $invoice->customer_id,
                            ':price' => $invoice->price_total, ':date_created' => $invoice->date_created->format('Y-m-d H:i:s')));
        $invoiceId = $this->db->lastInsertId();
        if(!$invoiceId)
            throw new \Exception('Invoice was not stored');
        $invoice->invoice_id = $invoiceId;

        foreach($invoice->invoiceItems as $item){
            $sql = 'INSERT INTO invoice_item (invoice_id, product_id, quantity, price) VALUES (:invoice_id, :product_id, :quantity, :price)';
            $stm = $this->db->prepare($sql);
            $stm->execute(array(':invoice_id' => $invoiceId, ':product_id' => $item->product_id, ':quantity' => $item->quantity, ':price' => $item->price));
        }
        return $invoice;
    }
}