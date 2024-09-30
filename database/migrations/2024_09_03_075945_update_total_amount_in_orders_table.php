<?php

use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateTotalAmountInOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'total_amount')) {
                $table->decimal('total_amount', 10, 2)->default(0);
            }
        });

        $orders = Order::with('orderItems')->get();
        foreach ($orders as $order) {
            $totalAmount = 0;

            foreach ($order->orderItems as $orderItem) {
                $totalAmount += $orderItem->price * $orderItem->quantity;
            }

            $order->total_amount = $totalAmount;
            $order->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'total_amount')) {
                $table->dropColumn('total_amount');
            }
        });
    }
}

