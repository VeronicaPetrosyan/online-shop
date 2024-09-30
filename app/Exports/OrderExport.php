<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Order::with('orderItems.product', 'user')->get();
    }

    public function headings(): array
    {
        return [
            'Order Id',
            'User Id',
            'Product Id',
            'Product Name',
            'Quantity',
            'Price',
            'Name',
            'Surname',
            'Address',
            'City',
            'Country',
            'PostCode',
            'Mobile',
            'Email',
            'Payment Method',
            'Notes',
            'Total Amount',
            'Status',
            'Created At',
            'Updated At'
        ];
    }

    public function map($order): array
    {

        $rows =[];
        foreach ($order->orderItems as $item) {
            $rows[] = [
                $order->id,
                $order->user->id,
                $item->product->id,
                $item->product->title,
                $item->quantity,
                $item->price,
                $order->name,
                $order->surname,
                $order->address,
                $order->city,
                $order->country,
                $order->postcode,
                $order->mobile,
                $order->email,
                $order->payment_method,
                $order->notes,
                $order->total_amount,
                $order->status,
                $order->created_at,
                $order->updated_at,
            ];
        }

        return $rows;
    }
}
