<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    public function gererateInvoice($id = null)
    {
        $data = [
            'invoice_number' => 'INV-001',
            'invoice_date' => '2022-01-01',
            'due_date' => '2022-01-31',
            'customer' => [
                'name' => 'John Doe',
                'address' => '123 Main St, Anytown, USA',
                'city' => 'Anytown',
                'state' => 'CA',
                'zip' => '12345',
            ],
            'items' => [
                [
                    'name' => 'Product A',
                    'description' => 'Description A',
                    'quantity' => 1,
                    'price' => 100,
                    'total' => 100,
                ],
                [
                    'name' => 'Product B',
                    'description' => 'Description B',
                    'quantity' => 2,
                    'price' => 50,
                    'total' => 100,
                ],
            ],
            'subtotal' => 200,
            'tax' => 20,
            'total' => 220,
        ];
        return view('backend.invoice.index', $data);
    }
}