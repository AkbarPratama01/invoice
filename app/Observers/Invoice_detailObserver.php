<?php

namespace App\Observers;

use App\Invoice_detail;
use App\Invoice;

class Invoice_detailObserver
{
    //KARENA FUNGSI YANG DIJALANKAN SAMA, MAKA KITA MEMBUATNYA KEDALAM FUNGCTION BARU
    private function generateTotal($invoiceDetail)
    {
        //MENGAMBIL INVOICE_ID
        $invoice_id = $invoiceDetail->invoice_id;
        //SELECT DARI TABLE invoice_details BERDASARKAN INVOICE
        $invoice_detail = Invoice_detail::where('invoice_id', $invoice_id)->get();
        //KEMUDIAN DIJUMLAH UNTUK MENDAPATKAN TOTALNYA
        $total = $invoice_detail->sum(function($i) {
            //DIMANA KETENTUAN YANG DIJUMLAHKAN ADALAH HASIL DARI price* qty
            return $i->price * $i->qty;
        });
        //UPDATE TABLE invoice PADA FIELD TOTAL
        $invoiceDetail->invoice()->update([
            'total' => $total
        ]);
    }
    /**
     * Handle the invoice_detail "created" event.
     *
     * @param  \App\Invoice_detail  $invoiceDetail
     * @return void
     */
    public function created(Invoice_detail $invoiceDetail)
    {
        //PANGGIL METHOD BARU TERSEBUT
        $this->generateTotal($invoiceDetail);
    }

    /**
     * Handle the invoice_detail "updated" event.
     *
     * @param  \App\Invoice_detail  $invoiceDetail
     * @return void
     */
    public function updated(Invoice_detail $invoiceDetail)
    {
        $this->generateTotal($invoiceDetail);
    }

    /**
     * Handle the invoice_detail "deleted" event.
     *
     * @param  \App\Invoice_detail  $invoiceDetail
     * @return void
     */
    public function deleted(Invoice_detail $invoiceDetail)
    {
        $this->generateTotal($invoiceDetail);
    }

    /**
     * Handle the invoice_detail "restored" event.
     *
     * @param  \App\Invoice_detail  $invoiceDetail
     * @return void
     */
    public function restored(Invoice_detail $invoiceDetail)
    {
        //
    }

    /**
     * Handle the invoice_detail "force deleted" event.
     *
     * @param  \App\Invoice_detail  $invoiceDetail
     * @return void
     */
    public function forceDeleted(Invoice_detail $invoiceDetail)
    {
        //
    }
}
