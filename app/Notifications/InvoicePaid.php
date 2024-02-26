<?php

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoicePaid extends Notification
{
    use Queueable;

    public $invoice;


    /**
     * Create a new notification instance.
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $url = url('/invoice/' . $this->invoice->id);
        $order = $this->invoice->order; // Asumiendo que la orden está relacionada con la factura
        // Puedes incluir cualquier dato de la orden que necesites
        $orderData = $order->orderData;
        $orderDataArray = json_decode($orderData, true);
        return (new MailMessage)
            ->subject('Invoice Paid')
            //todo url aun no hace nada,solamente lo dejamos para futuro
            ->markdown('mail.invoice.paid', ['invoice' => $this->invoice, 'url' => $url,'name' => $notifiable->name,'order'=>$order,'orderData' => $orderDataArray,]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
