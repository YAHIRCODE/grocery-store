<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LowStockNotification extends Mailable
{
    use Queueable, SerializesModels;
 
    public $products;
    public $adminName;
 
    /**
     * Create a new message instance.
     */
    public function __construct($products, $adminName = 'Administrador')
    {
        $this->products = $products;
        $this->adminName = $adminName;
    }
 
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '⚠️ Alerta: Productos con Stock Bajo - Grocery Store',
        );
    }
 
    /**
     * Get the message content definition.
     */
public function content(): Content
{
    return new Content(
        // Como el archivo está en views/Low_stock_notification.blade.php
      view: 'Low_stock_notification',
    );
}
 
    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}