<?php

namespace App\Http\Controllers\User;

use App\Models\Order;

use App\Models\Product;
use App\Constants\Status;
use App\Models\ShippingInfo;
use Illuminate\Http\Request;
use App\Models\AdminNotification;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{

    public function orders(Request $request)
    {
        $search    = $request->search;
        $pageTitle = "Order History";
        $orders    = Order::where('user_id', auth()->id())->searchable(['order_track'])
            ->where(function ($q) {
                $q->where('pay_status', Status::PAY_PAID)->where('payment_type', Status::PAYMENT_TYPE_DIRECT)
                    ->orWhere('payment_type', Status::PAYMENT_TYPE_CASH_ON_DELIVERY);
            })
            ->latest()->paginate(getPaginate());
        return view('Template::user.order_history', compact('pageTitle', 'orders', 'search'));
    }

    public function submitOrder(Request $request)
    {
        $request->validate([
            'name'       => 'required',
            'email'      => 'required|email',
            'phone'      => 'required',
            'city'       => 'required',
            'address'    => 'required',
            'post_code'  => 'required|numeric',
            'shipping'   => 'required|in:1,2',
            'payment'    => 'required|in:1,2',
            'product_id' => 'required|int',
            'qty'        => 'required|numeric|gt:0'
        ]);

        $general = gs();
        $product = Product::active()->findOrFail($request->product_id);
        if (!$product) {
            $notify[] = ['error', 'Product not found!'];
            return back()->withNotify($notify);
        }
        if ($product->stock < $request->qty) {
            $notify[] = ['error', 'Quantity exceeds the remaining stock!'];
            return back()->withNotify($notify);
        }

        $price = $product->price() * $request->qty;

        $order              = new Order();
        $order->order_track = orderTrack();
        $order->user_id     = auth()->id();
        $order->product_id  = $request->product_id;
        $order->qty         = $request->qty;

        $order->product_price = getAmount($product->price());
        $order->delivery_area = $request->shipping;
        $order->payment_type  = $request->payment;

        if ($request->shipping == 1 && $general->shipping_charge_inside != -1) {
            $totalAmount = getAmount($price + $general->shipping_charge_inside);
        } elseif ($request->shipping == 2 && $general->shipping_charge_outside != -1) {
            $totalAmount      = getAmount($price + $general->shipping_charge_outside);
        } else $totalAmount = getAmount($price);

        $order->total_amount = $totalAmount;
        $order->save();

        //shipping info
        $shipping             = new ShippingInfo();
        $shipping->order_id   = $order->id;
        $shipping->name       = $request->name;
        $shipping->email      = $request->email;
        $shipping->phone      = $request->phone;
        $shipping->city       = $request->city;
        $shipping->address    = $request->address;
        $shipping->post_code  = $request->post_code;
        $shipping->additional = $request->additional;
        $shipping->save();

        if ($request->payment == 2) {
            $product->stock -= $request->qty;
            $product->save();
            $adminNotification            = new AdminNotification();
            $adminNotification->user_id   = auth()->id();
            $adminNotification->title     = 'New order has been placed';
            $adminNotification->click_url = urlPath('admin.order.pending', ['search' => $order->order_track]);
            $adminNotification->save();

            notify(auth()->user(), 'ORDER_PLACED', [
                'product'     => $order->product->name,
                'qty'         => $order->qty,
                'currency'    => $general->cur_text,
                'p_price'     => getAmount($order->product_price),
                'total_price' => getAmount($order->total_amount),
                'time'        => showDateTime($order->created_at, 'd M Y @ h:i a'),
            ]);

            $notify[] = ['success', 'Your order has been placed successfully'];
            return redirect(route('user.order.history'))->withNotify($notify);
        } else {
            session()->put('order_id', $order->id);
            return redirect(route('user.deposit.index'));
        }
    }

    public function cancelOrder($id)
    {
        $order = Order::where('user_id', auth()->id())->findOrFail($id);

        if ($order->status == Status::ORDER_PROCESSING || $order->status == Status::ORDER_COMPLETED || $order->pay_status == Status::PAYMENT_TYPE_DIRECT) {
            $notify[] = ['error', 'Order can not be cancelled'];
            return back()->withNotify($notify);
        }

        $order->status = Status::ORDER_CANCELLED;
        $order->save();

        $order->product->stock += $order->qty;
        $order->product->save();

        $notify[] = ['success', 'Order has been cancelled'];
        return back()->withNotify($notify);
    }
}
