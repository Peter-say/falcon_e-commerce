<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\OrderService;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function placeOrder(Request $request, PaymentService $paymentService)
    {
        // Get the authenticated user
        $user = Auth::user();
    
        // Retrieve user's shipping address
        $address = Address::where('user_id', $user->id)->first();
    
        // Check if address is missing, redirect if needed
        if (empty($address)) {
            return redirect()->route('user.dashboard.checkout')->with('error_message', 'Please update your shipping address before placing an order.');
        }
        // Process the order
        $result = OrderService::processOrder($request, $paymentService);
    
        // Check and handle order processing result
        if ($result == true) {
            return redirect()->route('user.dashboard.thank-you'); // Redirect to thank-you page on success
        } else {
            return back()->with('error_message', 'Something went wrong'); // Show error message on failure
        }
    }
    

    public function orders()
    {
        $user = auth()->user();
        $orders = Order::where('user_id', $user->id)->latest()->get();
        $totalOrderCount = Order::where('user_id', $user->id)->count();
        return view('dashboard.user.orders.index', [
            'orders' => $orders,
            'totalOrderCount' => $totalOrderCount,
        ]);
    }


    public function orderProducts($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);
        $orderItems = $order->orderItems;
        // $products = [];
        // foreach ($orderItems as $orderItem) {
        //     $products[] = $orderItem->product;
        // }
        return view('dashboard.user.orders.orderItems', [
            'orderItems' => $orderItems,
            // 'products' => $products,
            'order' => $order
        ]);
    }
}
