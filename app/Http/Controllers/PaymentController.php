<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Listeners\EmptyCart;
use App\Models\Order;
use App\Models\Payment;
use App\Services\PaymobPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\Empty_;

class PaymentController extends Controller
{
    protected $paymobService;

    public function __construct(PaymobPaymentService $paymobService)
    {
        $this->paymobService = $paymobService;
    }

    /**
     * Initiate payment process
     */
    // public function checkout(Request $request, $orderId)
    // {
    //     try {
    //         // Get order from database
    //         $order = Order::findOrFail($orderId);

    //         // Check if order belongs to authenticated user
    //         if ($order->user_id !== Auth::user()->id) {
    //             return redirect()->back()->with('error', 'Unauthorized access to order');
    //         }

    //         // Get amount
    //         $amount = $order->total;

    //         // Step 1: Authenticate with Paymob
    //         $this->paymobService->authenticate();

    //         // Step 2: Register order with Paymob
    //         $paymobOrder = $this->paymobService->registerOrder(
    //             $amount,
    //             [], // Optional items array
    //             $order->id // Use your order ID as merchant_order_id
    //         );

    //         // Get Paymob order ID
    //         $paymobOrderId = $paymobOrder['id'];

    //         // Step 3: Get billing data (from user or order)
    //         $billingData = [
    //             'first_name' => $order->address->name ?? auth()->user()->name ?? 'NA',
    //             'last_name' => 'NA',
    //             'email' => $order->address->email ?? auth()->user()->email ?? 'NA',
    //             'phone_number' => $order->address->phone_number ?? auth()->user()->phone_number ?? 'NA',
    //             'street' => $order->address->street_addresses ?? 'NA',
    //             'city' => 'NA',
    //             'country' =>  'EG',
    //             'state' => 'NA',
    //             'postal_code' =>  'NA',
    //             'apartment' => 'NA',
    //             'floor' => 'NA',
    //             'building' => 'NA',
    //         ];

    //         // Step 4: Get payment key
    //         $paymentKey = $this->paymobService->getPaymentKey(
    //             $paymobOrderId,
    //             $amount,
    //             $billingData
    //         );

    //         // Step 5: Generate iframe URL
    //         $iframeUrl = $this->paymobService->getIframeUrl($paymentKey);

    //         // Update order with payment information
    //         $order->payment_provider = 'paymob';
    //         $order->payment_order_id = $paymobOrderId;
    //         $order->save();

    //         // Save payment attempt in database
    //         Payment::create([
    //             'order_id' => $order->id,
    //             'payment_provider' => 'paymob',
    //             'provider_order_id' => $paymobOrderId,
    //             'amount' => $amount,
    //             'currency' => 'EGP', // Change as needed
    //             'status' => 'pending'
    //         ]);

    //         // Redirect to checkout page with iframe URL
    //         return view('payment.payment', compact('order', 'iframeUrl'));
    //     } catch (\Exception $e) {
    //         Log::error('Payment initiation failed', ['error' => $e->getMessage()]);
    //         return redirect()->back()->with('error', 'Payment initiation failed: ' . $e->getMessage());
    //     }
    // }

    public function checkout(Request $request, $orderId)
    {
        try {
            // Get order from database
            $order = Order::findOrFail($orderId);

            // Check if order belongs to authenticated user
            if ($order->user_id !== Auth::user()->id) {
                return redirect()->back()->with('error', 'Unauthorized access to order');
            }

            // Check if payment has already been initiated
            $existingPayment = Payment::where('order_id', $order->id)
                ->where('status', '!=', 'failed')
                ->first();

            if ($existingPayment) {
                // Payment already exists, don't create a new one
                return redirect()->route('payment.pending', ['order_id' => $order->id]);
            }

            // Get amount
            $amount = $order->total;

            // Step 1: Authenticate with Paymob
            $this->paymobService->authenticate();

            // Step 2: Register order with Paymob
            $paymobOrder = $this->paymobService->registerOrder(
                $amount,
                [], // Optional items array
                $order->id // Use your order ID as merchant_order_id
            );

            // Get Paymob order ID
            $paymobOrderId = $paymobOrder['id'];

            // Step 3: Get billing data (from user or order)
            $billingData = [
                'first_name' => $order->address->name ?? auth()->user()->name ?? 'NA',
                'last_name' => 'NA',
                'email' => $order->address->email ?? auth()->user()->email ?? 'NA',
                'phone_number' => $order->address->phone_number ?? auth()->user()->phone_number ?? 'NA',
                'street' => $order->address->street_addresses ?? 'NA',
                'city' => 'NA',
                'country' =>  'EG',
                'state' => 'NA',
                'postal_code' =>  'NA',
                'apartment' => 'NA',
                'floor' => 'NA',
                'building' => 'NA',
            ];

            // Step 4: Get payment key
            $paymentKey = $this->paymobService->getPaymentKey(
                $paymobOrderId,
                $amount,
                $billingData
            );

            // Step 5: Generate iframe URL
            $iframeUrl = $this->paymobService->getIframeUrl($paymentKey);

            // Update order with payment information
            $order->payment_provider = 'paymob';
            $order->payment_order_id = $paymobOrderId;
            $order->save();

            // Save payment attempt in database
            Payment::create([
                'order_id' => $order->id,
                'payment_provider' => 'paymob',
                'provider_order_id' => $paymobOrderId,
                'amount' => $amount,
                'currency' => 'EGP', // Change as needed
                'status' => 'pending'
            ]);

            // Redirect to checkout page with iframe URL
            return view('payment.payment', compact('order', 'iframeUrl'));
        } catch (\Exception $e) {
            Log::error('Payment initiation failed', ['error' => $e->getMessage()]);

            // Mark the order as payment_failed
            if (isset($order)) {
                $order->payment_status = 'failed';
                $order->save();

                // Also mark any pending payment as failed
                if (isset($paymobOrderId)) {
                    Payment::where('order_id', $order->id)
                        ->where('provider_order_id', $paymobOrderId)
                        ->update(['status' => 'failed']);
                }
            }
            return redirect()->back()->with('error', 'Payment initiation failed: ' . $e->getMessage());
        }
    }


    /**
     * Handle transaction processed callback
     */
    public function processCallback(Request $request)
    {
        try {

            // Log the full request for debugging
            Log::info('Paymob callback received', ['data' => $request->all()]);

            // Process callback data
            $result = $this->paymobService->processCallback($request->all());
            if ($result['success']) {
                // Find order by Paymob order ID
                $merchantOrderId = $result['merchant_order_id'];
                $order = null;

                if ($merchantOrderId) {
                    // If merchant_order_id is available, use it (this is your app's order ID)
                    $order = Order::find($merchantOrderId);
                } else {
                    // Otherwise find by payment_order_id (Paymob's order ID)
                    $order = Order::where('payment_order_id', $result['order_id'])->first();
                }

                if ($order) {
                    // Update order status
                    $order->payment_status = 'paid';
                    $order->payment_transaction_id = $result['transaction_id'];
                    $order->status = 'processing'; // Update order status as needed
                    $order->save();

                    // Update payment record
                    Payment::where('order_id', $order->id)
                        ->where('provider_order_id', $result['order_id'])
                        ->update([
                            'transaction_id' => $result['transaction_id'],
                            'status' => 'completed',
                            'payment_data' => json_encode($result['data'])
                        ]);


                    // For API callbacks
                    if ($request->wantsJson()) {
                        return response()->json(['success' => true]);
                    }
                    event(new OrderCreated($order));
                    return redirect()->route('payment.success', ['order_id' => $order->id]);
                }
            }

            // For API callbacks
            if ($request->wantsJson()) {
                return response()->json(['success' => false]);
            }
            // For redirect callbacks
            return redirect()->route('payment.failed');
        } catch (\Exception $e) {
            Log::error('Payment callback processing failed', ['error' => $e->getMessage()]);

            // For API callbacks
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'error' => $e->getMessage()]);
            }

            // For redirect callbacks
            return redirect()->route('payment.failed');
        }
    }

    public function success(Request $request)
    {
        $orderId = $request->order_id;
        $order = null;

        if ($orderId) {
            $order = Order::find($orderId);
            if (!Auth::check() && $order && $order->user_id) {
                Auth::loginUsingId($order->user_id);
            }
        }

        return view('payment.success', compact('order'));
    }

    public function failed()
    {
        return view('payment.failed');
    }

    public function responseCallback(Request $request)
    {
        try {
            $success = $request->success === 'true';

            // Get user ID from the order if available
            $orderId = $request->order_id ?? null;
            $userId = null;

            if ($orderId) {
                $order = Order::find($orderId);
                if ($order) {
                    $userId = $order->user_id;
                }
            }

            if (!Auth::check() && $userId) {
                Auth::loginUsingId($userId);
            }

            if ($success) {
                event(new OrderCreated($order));


                return redirect()->route('payment.success', ['order_id' => $orderId]);
            } else {
                return redirect()->route('payment.failed');
            }
        } catch (\Exception $e) {
            Log::error('Payment response callback failed', ['error' => $e->getMessage()]);
            return redirect()->route('payment.failed');
        }
    }
}
