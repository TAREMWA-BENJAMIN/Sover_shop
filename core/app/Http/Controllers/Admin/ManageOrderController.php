<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Constants\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManageOrderController extends Controller
{
    public function allOrders(Request $request)
    {
        $pageTitle = "Manage Orders";
        $orders    = $this->orderData();
        return view('admin.orders.all', compact('pageTitle', 'orders'));
    }

    private function orderData($scope = null)
    {
        if ($scope) {
            $orders = Order::$scope();
        } else {
            $orders = Order::query();
        }

        return $orders->searchable(['order_track'])->orderBy('id', 'desc')->where(function ($q) {
            $q->where('pay_status', Status::PAY_PAID)
                ->where('payment_type', Status::PAYMENT_TYPE_DIRECT)
                ->orWhere('payment_type', Status::PAYMENT_TYPE_CASH_ON_DELIVERY);
        })->with('user', 'product')->paginate(getPaginate());
    }

    public function orderDetails($id)
    {
        $pageTitle = "Order Details";
        $order     = Order::findOrFail($id);
        $contact   = getContent('contact_us.content', true);
        return view('admin.orders.details', compact('pageTitle', 'order', 'contact'));
    }

    public function pending(Request $request)
    {
        $pageTitle = "Pending Orders";
        $orders    = $this->orderData('pending');
        return view('admin.orders.all', compact('pageTitle', 'orders'));
    }

    public function processing(Request $request)
    {
        $pageTitle = "Processing Orders";
        $orders    = $this->orderData('processing');
        return view('admin.orders.all', compact('pageTitle', 'orders'));
    }

    public function delivered(Request $request)
    {
        $pageTitle = "Delivered Orders";
        $orders    = $this->orderData('delivered');
        return view('admin.orders.all', compact('pageTitle', 'orders'));
    }
    public function cancelled(Request $request)
    {
        $pageTitle = "Cancelled Orders";
        $orders    = $this->orderData('cancelled');
        return view('admin.orders.all', compact('pageTitle', 'orders'));
    }
    public function codOrders(Request $request)
    {
        $pageTitle = "Cash On Delivery Orders";
        $orders    = $this->orderData('cod');
        return view('admin.orders.all', compact('pageTitle', 'orders'));
    }

    public function markAsProcess($id)
    {
        $order         = Order::findOrFail($id);
        $order->status = Status::ORDER_PROCESSING;
        $order->save();
        $notify[] = ['success', 'Order marked as processing'];
        return back()->withNotify($notify);
    }
    public function markAsDelivered($id)
    {
        $order         = Order::findOrFail($id);
        $order->status = Status::ORDER_COMPLETED;
        $order->save();
        $notify[] = ['success', 'Order marked as delivered'];
        return back()->withNotify($notify);
    }
    public function cancel(Request $request)
    {
        $order         = Order::findOrFail($request->id);
        $order->status = Status::ORDER_CANCELLED;
        $order->save();
        $notify[] = ['success', 'Order has been cancelled'];
        return back()->withNotify($notify);
    }
}
