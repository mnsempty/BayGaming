<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    

    public function generatePDF($orderId)
    {
        $order = Order::findOrFail($orderId);

        $orderData = json_decode($order->orderData, true);

        // Obtén los datos necesarios para la vista
        $data = [
            'title' => 'Factura del pedido',
            'order' => $order,
            'orderData' => $orderData,
        ];

        // Genera el PDF usando la vista 'pdf' y los datos
        //! pdf no PDF en esta version de doom-pdf
        $pdf = Pdf::loadView('auth.order_pdf', $data);

        $fecha = now()->format('Y-m-d_H-i-s');
        // Descarga el PDF o muestra en navegador
        return $pdf->download('Factura_BayGaming_'.$fecha.'.pdf');
    }
}
