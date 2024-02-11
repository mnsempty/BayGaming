<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Notifications\InvoicePaid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoicesController extends Controller
{
    public function createInvoice($orderId)
    {

        try {
            DB::beginTransaction();
            // Buscar la orden por ID
            $order = Order::findOrFail($orderId);

            $invoice = new Invoice;
            $invoice->orders_id = $order->id;
            $invoice->date = now();
            $invoice->subtotal = $order->total;
            // Guardar la factura en la base de datos
            $invoice->save();

            DB::commit();
            // Redirigir al usuario a la página de éxito
            return back()->with('success', 'Factura creada');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['message' => 'Error al crear la factura.'. $e->getMessage()]);
        }
    }
    //todo check
    public function sendInvoice($orderId){
        try {
            DB::beginTransaction();
            $order = Order::findOrFail($orderId);
            $invoice = $order->invoice;
            $order->user->notify(new InvoicePaid($invoice));

            DB::commit();
            // Redirigir al usuario a la página de éxito
            return back()->with('success', 'mail enviado');
        } catch (\exception $e) {
            DB::rollBack();
            return back()->withErrors(['message' => 'Error al enviar la factura.'. $e->getMessage()]);
        }
    }

}
