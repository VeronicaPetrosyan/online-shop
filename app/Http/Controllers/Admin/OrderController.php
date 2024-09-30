<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrderExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminSearchOrderRequest;
use App\Http\Requests\ImportOrdersRequest;
use App\Imports\OrderImport;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use App\Services\Admin\OrderService as AdminOrderService;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $orderService, $adminOrderService;

    public function __construct(OrderService $orderService, AdminOrderService $adminOrderService)
    {
        $this->orderService = $orderService;
        $this->adminOrderService = $adminOrderService;
    }

    public function index(Request $request)
    {
        $filters = $request->all();
        $orders = $this->adminOrderService->getOrders($filters);
        foreach ($orders as $order) {
            $order->product_names = $this->orderService->getProductNames($order);
        }
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::with('orderItems.product.images')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $this->adminOrderService->updateOrderStatus($id, $request->status);

        return redirect()->route('admin.orders.show', $id)->with('success', 'Order status updated successfully.');
    }

    public function search(AdminSearchOrderRequest $request)
    {
        $filters = $request->all();
        $orders = $this->orderService->searchOrders($filters);
        return view('admin.orders.index', compact('orders'));
    }

    public function showOrdersByMonth()
    {
        $ordersByMonth = $this->adminOrderService->getOrdersByMonth();
        $months = $ordersByMonth->pluck('month_name')->toArray();
        $orderCounts = $ordersByMonth->pluck('orders_count')->toArray();

        return view('admin.orders.monthly_chart', compact('months', 'orderCounts'));
    }

    public function exportCsv()
    {
        return $this->adminOrderService->exportOrdersCsv();
    }

    public function exportExcel()
    {
        return Excel::download(new OrderExport, 'orders.xlsx');
    }

    public function importExcel(ImportOrdersRequest $request)
    {
         // Get the uploaded file
    $file = $request->file('file');

    // Use the uploaded file for import
    Excel::import(new OrderImport, $file);

    return redirect()->back()->with('success', 'Successful import');
    }

}
