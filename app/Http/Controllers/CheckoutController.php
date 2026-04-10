<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class CheckoutController extends Controller
{
    private $razorpayApi;

    public function __construct()
    {
        $this->razorpayApi = new Api(
            config('services.razorpay.key_id'),
            config('services.razorpay.key_secret')
        );
    }

    public function index()
    {
        $cartItems = Cart::with('medicine')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty.');
        }

        $total = $cartItems->sum(function($item) {
            return $item->medicine->price * $item->quantity;
        });

        $requiresPrescription = $cartItems->contains(function ($item) {
            return $item->medicine->prescription_required;
        });

        return view('checkout.index', compact('cartItems', 'total', 'requiresPrescription'));
    }

    public function store(Request $request)
    {
        // Define base validation rules

    $rules = [
        'payment_method'   => 'required|string|in:card,cod',
        'delivery_address' => 'required|string|min:5',
        
        // City & State: Only letters and spaces allowed
        'city'             => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/'],
        'state'            => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/'],
        
        // Pincode: Exactly 6 digits
        'pincode'          => 'required|digits:6',
        
        // Landmark: Only letters and spaces allowed (No numbers)
        'landmark'         => ['nullable', 'string', 'regex:/^[a-zA-Z\s]*$/'],
        
        // Alternate Phone: Exactly 10 digits if provided
        'alternate_phone'  => 'nullable|digits:10',
    ];

    $messages = [
        'city.regex' => 'City name should only contain alphabets.',
        'state.regex' => 'State name should only contain alphabets.',
        'landmark.regex' => 'Landmark should not contain any numbers.',
        'alternate_phone.digits' => 'The alternate phone number must be exactly 10 digits.',
        'pincode.digits' => 'Pincode must be a 6-digit numeric code.',
    ];

    if (!Auth::user()->phone) {
        $rules['phone'] = 'required|digits:10|unique:users,phone';
    }

    $request->validate($rules, $messages);

    
        // --- FIX: Validate phone if the user doesn't have one (e.g., Google OAuth users) ---
        if (!Auth::user()->phone) {
            $rules['phone'] = 'required|digits:10|unique:users,phone';
        }

        $request->validate($rules);

        $user = Auth::user();
        
        // Prepare data for profile update
        $userData = [
            'address'  => $request->delivery_address,
            'city'     => $request->city,
            'state'    => $request->state,
            'pincode'  => $request->pincode,
            'landmark' => $request->landmark,
            'country'  => 'India', // Default
        ];

        // If they just filled in their phone, save it to their profile permanently
        if ($request->has('phone')) {
            $userData['phone'] = $request->phone;
        }

        // Update User Profile
        $user->update($userData);

        // Store alternate phone in session for the Razorpay flow
        $alternatePhone = $request->alternate_phone;
        if($request->payment_method === 'card') {
            session(['checkout_alternate_phone' => $alternatePhone]);
        }

        $paymentMethod = $request->input('payment_method');
        $cartItems = Cart::with('medicine')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty.');
        }

        $total = $cartItems->sum(fn($item) => $item->medicine->price * $item->quantity);
        
        // --- COD LOGIC ---
        if ($paymentMethod === 'cod') {
            try {
                $order = $this->_fulfillOrder($user, $cartItems, $total, 'cod', null, null, $alternatePhone);
                
                if ($order->status == 'pending_prescription') {
                    return redirect()->route('prescription.upload', ['order' => $order->id])
                        ->with('success', 'Order placed! Please upload your prescription.');
                }
                return redirect()->route('checkout.success', ['order' => $order->id])->with('success', 'Thank you! Your order has been placed successfully.');

            } catch (Throwable $e) {
                return redirect()->route('cart.index')->with('error', 'Checkout failed: ' . $e->getMessage());
            }
        }

        // --- RAZORPAY LOGIC ---
        if ($paymentMethod === 'card') {
            try {
                $razorpayOrder = $this->razorpayApi->order->create([
                    'receipt'         => 'rcpt_' . time() . '_' . $user->id,
                    'amount'          => $total * 100, 
                    'currency'        => 'INR', 
                    'payment_capture' => 1 
                ]);
                
                $razorpayOrderId = $razorpayOrder['id'];
                session(['razorpay_order_id' => $razorpayOrderId]);

                $requiresPrescription = $cartItems->contains(fn($item) => $item->medicine->prescription_required);
                
                return view('checkout.index', [
                    'cartItems'            => $cartItems,
                    'total'                => $total,
                    'requiresPrescription' => $requiresPrescription,
                    'razorpayOrderId'      => $razorpayOrderId,
                    'razorpayKeyId'        => config('services.razorpay.key_id'),
                    'userName'             => $user->name,
                    'userEmail'            => $user->email,
                    'userPhone'            => $user->phone ?? '9999999999',
                ]);

            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }
    }

    public function verifyPayment(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id'   => 'required|string',
            'razorpay_signature'  => 'required|string',
        ]);

        $paymentId = $request->input('razorpay_payment_id');
        $razorpayOrderId = $request->input('razorpay_order_id');
        $signature = $request->input('razorpay_signature');
        
        if (session('razorpay_order_id') !== $razorpayOrderId) {
            return response()->json(['status' => 'error', 'message' => 'Invalid Order ID.'], 400);
        }

        try {
            $this->razorpayApi->utility->verifyPaymentSignature([
                'razorpay_order_id'   => $razorpayOrderId,
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature'  => $signature
            ]);

            $user = Auth::user();
            $cartItems = Cart::with('medicine')->where('user_id', $user->id)->get();
            $total = $cartItems->sum(fn($item) => $item->medicine->price * $item->quantity);

            $alternatePhone = session('checkout_alternate_phone');

            $order = $this->_fulfillOrder(
                $user, 
                $cartItems, 
                $total, 
                'card', 
                $paymentId,        
                $razorpayOrderId,
                $alternatePhone
            );

            session()->forget(['razorpay_order_id', 'checkout_alternate_phone']);
            
            $redirectUrl = $order->status == 'pending_prescription'
                ? route('prescription.upload', ['order' => $order->id])
                : route('checkout.success', ['order' => $order->id]);

            return response()->json(['status' => 'success', 'redirect_url' => $redirectUrl]);

        } catch (SignatureVerificationError $e) {
            Log::error('Razorpay Signature Verification Failed', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => 'Payment verification failed.'], 400);
        } catch (Throwable $e) {
            Log::error('Order fulfillment failed', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => 'Order fulfillment failed.'], 500);
        }
    }

    private function _fulfillOrder($user, $cartItems, $total, $paymentMethod, $paymentId = null, $razorpayOrderId = null, $alternatePhone = null)
    {
        $requiresPrescription = $cartItems->contains(fn($item) => $item->medicine->prescription_required);
        $orderStatus = $requiresPrescription ? 'pending_prescription' : 'processing';

        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id'           => $user->id,
                'total_amount'      => $total,
                'status'            => $orderStatus,
                'payment_method'    => $paymentMethod,
                'payment_id'        => $paymentId,
                'razorpay_order_id' => $razorpayOrderId,
                'delivery_address'  => $user->address, 
                'alternate_phone'   => $alternatePhone,
                'city'              => $user->city,
                'state'             => $user->state,
                'pincode'           => $user->pincode,
                'landmark'          => $user->landmark,
                'country'           => $user->country ?? 'India',
            ]);

            foreach ($cartItems as $item) {
                if ($item->medicine->stock < $item->quantity) {
                    throw new \Exception('Not enough stock for ' . $item->medicine->name);
                }
                OrderItem::create([
                    'order_id'    => $order->id,
                    'medicine_id' => $item->medicine_id,
                    'quantity'    => $item->quantity,
                    'price'       => $item->medicine->price,
                ]);
                $item->medicine->decrement('stock', $item->quantity);
            }

            Cart::where('user_id', $user->id)->delete();

            DB::commit();
            return $order;

        } catch (Throwable $e) {
            DB::rollBack();
            throw $e; 
        }
    }

    public function success(Request $request)
    {
        $order = Order::with('items.medicine')->find($request->query('order'));

        if (!$order || $order->user_id !== Auth::id()) {
            return redirect()->route('shop.index');
        }

        return view('checkout.success', compact('order'));
    }
}