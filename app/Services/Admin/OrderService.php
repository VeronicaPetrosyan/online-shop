<?php


namespace App\Services\Admin;

use App\Models\Order;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class OrderService
{
    public function getOrders($filters = [])
    {
        $query = Order::with('orderItems.product');

        if (!empty($filters['order_id'])) {
            $query->where('id', $filters['order_id']);
        }

        if (!empty($filters['created_at'])) {
            $query->whereDate('created_at', '=', $filters['created_at']);
        }

        if (!empty($filters['updated_at'])) {
            $query->whereDate('updated_at', '=', $filters['updated_at']);
        }

        if (!empty($filters['product_names'])) {
            $query->whereHas('orderItems.product', function ($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['product_names'] . '%');
            });
        }

        if (!empty($filters['total_amount'])) {
            $query->where('total_amount', '>=', $filters['total_amount']);
        }

        $orders = $query->paginate(10);


        return $orders;
    }

    public function updateOrderStatus($id, $status)
    {
        $order = Order::findOrFail($id);
        $order->status = $status;
        $order->save();
    }

    public function getOrdersByMonth()
    {
        $monthNames = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];

        $ordersByMonth = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as orders_count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        foreach ($ordersByMonth as $order) {
            $order->month_name = $monthNames[$order->month];
        }

        return $ordersByMonth;
    }

    public function exportOrdersCsv()
    {
        $orders = Order::with('orderItems.product')->get();
        $csvFileName = 'orders.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        ];

        $handle = fopen($csvFileName, 'w');
        fputcsv($handle,
            [
                'Order Id',
                'User Id',
                'Products',
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
            ]);


        foreach ($orders as $order) {
            $productNames = $order->orderItems->map(function ($item) {
                return $item->product->title;
            })->implode(', ');

            fputcsv($handle,
                [
                    $order->id,
                    $order->user->id,
                    $productNames,
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
                    $order->created_at,
                    $order->updated_at
                ]);
        }

        fclose($handle);

        return Response::download($csvFileName)->deleteFileAfterSend(true);
    }

}
