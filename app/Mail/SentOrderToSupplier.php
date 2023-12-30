<?php

namespace App\Mail;

use App\Models\Supplier;
use App\Models\SupplierOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;

class SentOrderToSupplier extends Mailable
{
    const MAIL_SUBJECT = 'Đơn đặt hàng';
    const MAIL_TEMPLATE = 'livewire.admin.supplier_order.email_template';

    use Queueable, SerializesModels;

    protected $order;
    protected $supplier;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(SupplierOrder $order, Supplier $supplier)
    {
        $this->order = $order;
        $this->supplier = $supplier;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            from: new Address(env('MAIL_USERNAME'), env('MAIL_FROM_NAME')),
            subject: self::MAIL_SUBJECT . ' ' . $this->order->code,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'livewire.admin.supplier_order.email_template',
            with: [
                'order' => $this->order,
                'supplier' => $this->supplier,
                'items' => json_decode($this->order->items, true)
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
