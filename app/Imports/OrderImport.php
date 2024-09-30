<?php

namespace App\Imports;

use App\Models\Order;
use App\Models\OrderItem;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $order = Order::create([
            'user_id' => $row['user_id'],
            'name' => $row['name'],
            'surname' => $row['surname'],
            'address' => $row['address'],
            'city' => $row['city'],
            'country' => $row['country'],
            'postcode' => $row['postcode'],
            'mobile' => $row['mobile'],
            'email' => $row['email'],
            'payment_method' => $row['payment_method'],
            'notes' => $row['notes'],
            'total_amount' => $row['total_amount'],
            'status' => $row['status'],
        ]);

        return new OrderItem([
            'order_id' => $order->id,
            'product_id' => $row['product_id'],
            'quantity' => $row['quantity'],
            'price' => $row['price'],
        ]);

    }


}
